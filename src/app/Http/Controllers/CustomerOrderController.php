<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\TenantOrder;
use App\Models\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomerOrderController extends Controller
{
    /**
     * Menampilkan halaman utama pemesanan.
     */
    public function index(): View
    {
        $tables = Table::query()
            ->where('is_active', true)
            ->whereHas('canteen', function ($query) {
                $query->where('is_active', true);
            })
            ->whereHas('floor', function ($query) {
                $query->where('is_active', true)
                    ->whereHas('building', function ($building) {
                        $building->where('is_active', true);
                    });
            })
            ->with([
                'canteen',
                'floor.building',
            ])
            ->orderBy('table_number')
            ->get();

        $selectedTable = null;

        if (session()->has('customer_table_id')) {
            $selectedTable = $tables->firstWhere(
                'id',
                session('customer_table_id')
            );

            if (! $selectedTable) {
                session()->forget('customer_table_id');
            }
        }

        return view('customer.index', compact(
            'tables',
            'selectedTable'
        ));
    }

    public function simulateTableConnection(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'table_id' => [
                'required',
                'uuid',
                'exists:tables,id',
            ],
        ]);

        $table = Table::query()
            ->where('is_active', true)
            ->whereHas('canteen', function ($query) {
                $query->where('is_active', true);
            })
            ->whereHas('floor', function ($query) {
                $query->where('is_active', true)
                    ->whereHas('building', function ($building) {
                        $building->where('is_active', true);
                    });
            })
            ->findOrFail($validated['table_id']);

        session()->put('customer_table_id', $table->id);

        return redirect()
            ->route('customer.index')
            ->with('success', 'Meja berhasil terhubung.');
    }

    public function disconnectSimulatedTable(): RedirectResponse
    {
        session()->forget('customer_table_id');

        return redirect()
            ->route('customer.index')
            ->with('success', 'Koneksi meja berhasil diputus.');
    }

    public function storeService(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_type' => [
                'required',
                Rule::in([
                    'dine_in',
                    'take_away',
                    'after_activity',
                ]),
            ],
        ]);

        $tableId = null;

        if ($validated['service_type'] === 'dine_in') {
            if (! session()->has('customer_table_id')) {
                return redirect()
                    ->back()
                    ->withErrors([
                        'service_type' => 'Silakan hubungkan meja terlebih dahulu untuk layanan Dine In.',
                    ]);
            }

            $table = Table::query()
                ->where('is_active', true)
                ->whereHas('canteen', function ($query) {
                    $query->where('is_active', true);
                })
                ->whereHas('floor', function ($query) {
                    $query->where('is_active', true)
                        ->whereHas('building', function ($building) {
                            $building->where('is_active', true);
                        });
                })
                ->find(session('customer_table_id'));

            if (! $table) {
                session()->forget('customer_table_id');

                return redirect()
                    ->back()
                    ->withErrors([
                        'service_type' => 'Meja tidak tersedia. Silakan hubungkan kembali meja Anda.',
                    ]);
            }

            $tableId = $table->id;
        }

        session()->put('customer_service', [
            'service_type' => $validated['service_type'],
            'table_id' => $tableId,
        ]);

        return redirect()->route('customer.tenants');
    }

    /**
     * Menyimpan informasi pelanggan dan catatan checkout ke session.
     */
    // public function storeCheckoutDetails(Request $request): RedirectResponse
    // {
    //     $cart = session()->get('customer_cart', []);

    //     if (empty($cart)) {
    //         return redirect()
    //             ->route('customer.cart')
    //             ->with('warning', 'Keranjang belanja masih kosong.');
    //     }

    //     $validated = $request->validate([
    //         'customer_name' => [
    //             'required',
    //             'string',
    //             'max:100',
    //         ],
    //         'customer_phone' => [
    //             'required',
    //             'string',
    //             'max:20',
    //         ],
    //         'notes' => [
    //             'nullable',
    //             'string',
    //             'max:1000',
    //         ],
    //         'tenant_notes' => [
    //             'nullable',
    //             'array',
    //         ],
    //         'tenant_notes.*' => [
    //             'nullable',
    //             'string',
    //             'max:500',
    //         ],
    //     ]);

    //     // Hanya menerima catatan untuk tenant yang ada di keranjang.
    //     $tenantNotes = array_intersect_key(
    //         $validated['tenant_notes'] ?? [],
    //         array_flip(array_keys($cart))
    //     );

    //     session()->put('customer_checkout_details', [
    //         'customer_name' => $validated['customer_name'],
    //         'customer_phone' => $validated['customer_phone'],
    //         'notes' => $validated['notes'] ?? null,
    //         'tenant_notes' => $tenantNotes,
    //     ]);

    //     return redirect()
    //         ->route('customer.checkout')
    //         ->with('success', 'Informasi pesanan berhasil disimpan.');
    // }

    /**
     * Membuat transaksi pesanan pelanggan.
     */
    public function placeOrder(Request $request): RedirectResponse
    {
        $cart = session()->get('customer_cart', []);
        $customerService = session('customer_service');

        if (empty($cart)) {
            return redirect()
                ->route('customer.cart')
                ->with('warning', 'Keranjang belanja masih kosong.');
        }

        if (! $customerService) {
            return redirect()
                ->route('customer.index')
                ->with('warning', 'Silakan pilih jenis layanan terlebih dahulu.');
        }

        $validated = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:100',
            ],
            'customer_phone' => [
                'required',
                'string',
                'max:20',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'tenant_notes' => [
                'nullable',
                'array',
            ],
            'tenant_notes.*' => [
                'nullable',
                'string',
                'max:500',
            ],
            'pickup_date' => $customerService['service_type'] === 'after_activity'
                ? ['required', 'date_format:Y-m-d', 'after_or_equal:today']
                : ['nullable', 'date_format:Y-m-d'],

            'pickup_time' => $customerService['service_type'] === 'after_activity'
                ? ['required', 'date_format:H:i']
                : ['nullable', 'date_format:H:i'],
        ]);

        $serviceType = $customerService['service_type'];

        if (! in_array($serviceType, ['dine_in', 'take_away', 'after_activity'], true)) {
            return redirect()
                ->route('customer.index')
                ->with('warning', 'Jenis layanan belum tersedia.');
        }

        try {
            $order = DB::transaction(function () use (
                $cart,
                $validated,
                $serviceType,
                $customerService
            ) {
                $table = null;

                if ($serviceType === 'dine_in') {
                    $table = Table::query()
                        ->where('id', $customerService['table_id'] ?? null)
                        ->where('is_active', true)
                        ->lockForUpdate()
                        ->first();

                    if (! $table) {
                        throw new \RuntimeException(
                            'Meja yang dipilih sudah tidak tersedia. Silakan pilih meja kembali.'
                        );
                    }
                }

                $tenantIds = array_keys($cart);

                // Ambil ulang tenant aktif dari database.
                $tenants = Tenant::query()
                    ->whereIn('id', $tenantIds)
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                if ($tenants->count() !== count($tenantIds)) {
                    throw new \RuntimeException(
                        'Salah satu kantin sudah tidak tersedia.'
                    );
                }

                $tenantNotes = $validated['tenant_notes'] ?? [];

                $tenantNotes = array_intersect_key(
                    $tenantNotes,
                    array_flip($tenantIds)
                );

                $orderSubtotal = 0;

                // Validasi produk dan hitung ulang subtotal.
                $preparedOrders = [];

                foreach ($cart as $tenantId => $tenantCart) {
                    $items = $tenantCart['items'] ?? [];

                    if (empty($items)) {
                        throw new \RuntimeException(
                            'Terdapat kantin dengan keranjang kosong.'
                        );
                    }

                    $products = Product::query()
                        ->where('tenant_id', $tenantId)
                        ->whereIn('id', array_keys($items))
                        ->where('is_active', true)
                        ->lockForUpdate()
                        ->get()
                        ->keyBy('id');

                    if ($products->count() !== count($items)) {
                        throw new \RuntimeException(
                            'Salah satu produk sudah tidak tersedia. Silakan periksa kembali keranjang.'
                        );
                    }

                    $tenantSubtotal = 0;
                    $preparedItems = [];

                    foreach ($items as $productId => $item) {
                        $product = $products->get($productId);

                        $quantity = filter_var(
                            $item['quantity'] ?? null,
                            FILTER_VALIDATE_INT
                        );

                        if (! $product || $quantity === false || $quantity < 1) {
                            throw new \RuntimeException(
                                'Data produk atau jumlah pesanan tidak valid.'
                            );
                        }

                        // Hitung menggunakan satuan sen untuk menghindari
                        // kesalahan pembulatan selama perhitungan.
                        $unitPrice = (int) round(
                            (float) $product->price * 100
                        );

                        $itemSubtotal = $unitPrice * $quantity;

                        $tenantSubtotal += $itemSubtotal;

                        $preparedItems[] = [
                            'product' => $product,
                            'unit_price' => $unitPrice / 100,
                            'quantity' => $quantity,
                            'subtotal' => $itemSubtotal / 100,
                        ];
                    }

                    $orderSubtotal += $tenantSubtotal;

                    $preparedOrders[] = [
                        'tenant' => $tenants->get($tenantId),
                        'subtotal' => $tenantSubtotal / 100,
                        'items' => $preparedItems,
                        'notes' => $tenantNotes[$tenantId] ?? null,
                    ];
                }

                // Buat transaksi utama.
                $orderNumber = 'ORD-'.now()->format('YmdHis')
                    .'-'.Str::upper(Str::random(6));

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => auth()->id(),
                    'service_type' => $serviceType,
                    'table_id' => $table?->id,
                    'table_code' => $table?->code,
                    'table_name' => $table?->name,
                    'customer_name' => $validated['customer_name'],
                    'customer_phone' => $validated['customer_phone'],
                    'notes' => $validated['notes'] ?? null,
                    'status' => 'pending',
                    'subtotal' => $orderSubtotal / 100,
                    'total' => $orderSubtotal / 100,
                    'pickup_date' => $validated['pickup_date'] ?? null,
                    'pickup_time' => $validated['pickup_time'] ?? null,
                ]);

                // Buat pembayaran QRIS simulasi.
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => 'qris',
                    'amount' => $order->total,
                    'status' => 'pending',
                    'provider' => 'simulation',
                    'expires_at' => now()->addMinutes(15),
                    'metadata' => [
                        'mode' => 'simulation',
                    ],
                ]);

                // Buat pesanan untuk setiap tenant.
                foreach ($preparedOrders as $index => $tenantData) {
                    $tenantOrder = TenantOrder::create([
                        'order_id' => $order->id,
                        'tenant_id' => $tenantData['tenant']->id,
                        'order_number' => 'TO-'.Str::upper(Str::random(12)),
                        'pickup_code' => (string) random_int(100000, 999999),
                        'status' => 'pending',
                        'subtotal' => $tenantData['subtotal'],
                        'notes' => $tenantData['notes'],
                    ]);

                    // Simpan rincian produk tenant.
                    foreach ($tenantData['items'] as $item) {
                        OrderItem::create([
                            'tenant_order_id' => $tenantOrder->id,
                            'product_id' => $item['product']->id,
                            'product_code' => $item['product']->code,
                            'product_name' => $item['product']->name,
                            'unit_price' => $item['unit_price'],
                            'quantity' => $item['quantity'],
                            'subtotal' => $item['subtotal'],
                        ]);
                    }
                }

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return redirect()
                ->route('customer.checkout')
                ->with('error', $exception->getMessage());
        }

        // Kosongkan keranjang hanya setelah transaksi berhasil.
        session()->forget([
            'customer_cart',
            'customer_checkout_details',
            'customer_service',
        ]);

        session()->put('customer_latest_order_id', $order->id);

        return redirect()
            ->route('customer.payment')
            ->with(
                'success',
                'Pesanan berhasil dibuat. Silakan lanjutkan pembayaran QRIS.'
            );
    }

    /**
     * Menampilkan halaman riwayat pesanan.
     */
    public function history(): View
    {
        return view('customer.history');
    }

    /**
     * Mencari dan memfilter riwayat pesanan pelanggan.
     */
    public function searchHistory(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:150'],
            'filter' => [
                'nullable',
                'in:all,processing,pending,completed,failed',
            ],
        ]);

        $search = trim($validated['search'] ?? '');
        $filter = $validated['filter'] ?? 'all';

        if ($search === '') {
            return redirect()
                ->route('customer.history')
                ->with('warning', 'Masukkan nama pemesan atau nomor pesanan untuk mencari riwayat.');
        }

        $query = Order::query()
            ->with(['payment', 'tenantOrders'])
            ->where(function ($query) use ($search) {
                $query->where('order_number', $search)
                    ->orWhereRaw(
                        'LOWER(TRIM(customer_name)) LIKE ?',
                        ['%'.mb_strtolower($search).'%']
                    );
            });

        switch ($filter) {
            case 'processing':
                $query->where('status', 'paid')
                    ->whereHas('tenantOrders', function ($query) {
                        $query->where('status', 'paid');
                    });
                break;

            case 'pending':
                $query->where('status', 'pending');
                break;

            case 'completed':
                $query->whereHas('tenantOrders')
                    ->whereDoesntHave('tenantOrders', function ($query) {
                        $query->where('status', '!=', 'completed');
                    });
                break;

            case 'failed':
                $query->whereIn('status', ['failed', 'expired']);
                break;
        }

        $orders = $query
            ->latest()
            ->limit(20)
            ->get();

        return view('customer.history', compact(
            'orders',
            'search',
            'filter'
        ));
    }

    /**
     * Menampilkan halaman pembayaran QRIS.
     */
    public function payment(): View|RedirectResponse
    {
        $orderId = session('customer_latest_order_id');

        if (! $orderId) {
            return redirect()
                ->route('customer.index')
                ->with('warning', 'Tidak ada transaksi yang perlu dibayar.');
        }

        $order = Order::query()
            ->with('payment')
            ->whereKey($orderId)
            ->first();

        if (! $order || ! $order->payment) {
            return redirect()
                ->route('customer.index')
                ->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $payment = $order->payment;

        return view('customer.pay', compact(
            'order',
            'payment'
        ));
    }

    public function simulatePayment(): RedirectResponse
    {
        abort_unless(
            app()->environment(['local', 'testing']),
            404
        );

        $orderId = session('customer_latest_order_id');

        if (! $orderId) {
            return redirect()
                ->route('customer.index')
                ->with('warning', 'Tidak ada transaksi yang perlu dibayar.');
        }

        $result = DB::transaction(function () use ($orderId): string {
            $order = Order::query()
                ->whereKey($orderId)
                ->lockForUpdate()
                ->first();

            if (! $order) {
                return 'not_found';
            }

            $payment = Payment::query()
                ->where('order_id', $order->id)
                ->lockForUpdate()
                ->first();

            if (! $payment) {
                return 'payment_not_found';
            }

            if ($payment->status === 'paid') {
                return 'already_paid';
            }

            if ($payment->status !== 'pending') {
                return 'invalid_status';
            }

            if ($payment->expires_at && $payment->expires_at->isPast()) {
                $payment->update([
                    'status' => 'expired',
                ]);

                $order->update([
                    'status' => 'expired',
                ]);

                return 'expired';
            }

            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $order->update([
                'status' => 'paid',
            ]);

            TenantOrder::query()
                ->where('order_id', $order->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'paid',
                ]);

            return 'success';
        });

        return match ($result) {
            'success', 'already_paid', 'expired' => redirect()
                ->route('customer.payment.status'),

            'not_found' => redirect()
                ->route('customer.index')
                ->with('error', 'Data pesanan tidak ditemukan.'),

            'payment_not_found' => redirect()
                ->route('customer.index')
                ->with('error', 'Data pembayaran tidak ditemukan.'),

            default => redirect()
                ->route('customer.payment.status'),
        };
    }

    public function simulatePaymentFailure(): RedirectResponse
    {
        abort_unless(
            app()->environment(['local', 'testing']),
            404
        );

        $orderId = session('customer_latest_order_id');

        if (! $orderId) {
            return redirect()
                ->route('customer.index')
                ->with('warning', 'Tidak ada transaksi yang perlu dibayar.');
        }

        $result = DB::transaction(function () use ($orderId): string {
            $order = Order::query()
                ->whereKey($orderId)
                ->lockForUpdate()
                ->first();

            if (! $order) {
                return 'not_found';
            }

            $payment = Payment::query()
                ->where('order_id', $order->id)
                ->lockForUpdate()
                ->first();

            if (! $payment) {
                return 'payment_not_found';
            }

            if ($payment->status !== 'pending') {
                return 'invalid_status';
            }

            if ($payment->expires_at && $payment->expires_at->isPast()) {
                $payment->update(['status' => 'expired']);
                $order->update(['status' => 'expired']);

                TenantOrder::query()
                    ->where('order_id', $order->id)
                    ->where('status', 'pending')
                    ->update(['status' => 'expired']);

                return 'expired';
            }

            $payment->update([
                'status' => 'failed',
                'failure_reason' => 'Simulasi pembayaran gagal.',
            ]);

            $order->update(['status' => 'failed']);

            TenantOrder::query()
                ->where('order_id', $order->id)
                ->where('status', 'pending')
                ->update(['status' => 'failed']);

            return 'failed';
        });

        return match ($result) {
            'failed', 'expired' => redirect()
                ->route('customer.payment.status'),

            'not_found' => redirect()
                ->route('customer.index')
                ->with('error', 'Data pesanan tidak ditemukan.'),

            'payment_not_found' => redirect()
                ->route('customer.index')
                ->with('error', 'Data pembayaran tidak ditemukan.'),

            default => redirect()
                ->route('customer.payment.status'),
        };
    }

    public function paymentStatus(): View|RedirectResponse
    {
        $orderId = session('customer_latest_order_id');

        if (! $orderId) {
            return redirect()
                ->route('customer.index')
                ->with('warning', 'Tidak ada transaksi yang dapat ditampilkan.');
        }

        $order = Order::query()
            ->with('payment')
            ->whereKey($orderId)
            ->first();

        if (! $order || ! $order->payment) {
            return redirect()
                ->route('customer.index')
                ->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $payment = $order->payment;

        // Periksa apakah pembayaran pending sudah melewati batas waktu.
        if (
            $payment->status === 'pending'
            && $payment->expires_at
            && $payment->expires_at->isPast()
        ) {
            DB::transaction(function () use ($order, $payment): void {
                $lockedPayment = Payment::query()
                    ->whereKey($payment->id)
                    ->lockForUpdate()
                    ->first();

                if (
                    $lockedPayment
                    && $lockedPayment->status === 'pending'
                    && $lockedPayment->expires_at
                    && $lockedPayment->expires_at->isPast()
                ) {
                    $lockedPayment->update([
                        'status' => 'expired',
                    ]);

                    Order::query()
                        ->whereKey($order->id)
                        ->where('status', 'pending')
                        ->update([
                            'status' => 'expired',
                        ]);

                    TenantOrder::query()
                        ->where('order_id', $order->id)
                        ->where('status', 'pending')
                        ->update([
                            'status' => 'expired',
                        ]);
                }
            });

            // Ambil kembali status terbaru setelah transaksi.
            $payment->refresh();
            $order->refresh();
        }

        $view = match ($payment->status) {
            'paid' => 'customer.paycomplete',
            'failed' => 'customer.payfailed',
            'pending' => 'customer.paypending',
            'expired' => 'customer.payexpired',
            default => null,
        };

        if (! $view) {
            return redirect()
                ->route('customer.index')
                ->with('error', 'Status pembayaran tidak dikenali.');
        }

        return view($view, compact('order', 'payment'));
    }

    /**
     * Menampilkan daftar tenant aktif.
     */
    public function tenants(): View
    {
        $tenants = Tenant::query()
            ->where('is_active', true)
            ->withCount([
                'products' => fn ($query) => $query
                    ->where('is_active', true),
            ])
            ->latest()
            ->get();

        return view('customer.tenants', compact('tenants'));
    }

    public function storeTenants(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tenant_ids' => [
                'required',
                'array',
                'min:1',
            ],
            'tenant_ids.*' => [
                'required',
                'uuid',
                'distinct',
                'exists:tenants,id',
            ],
        ]);

        $tenantIds = Tenant::query()
            ->whereIn('id', $validated['tenant_ids'])
            ->where('is_active', true)
            ->pluck('id')
            ->all();

        if (count($tenantIds) !== count($validated['tenant_ids'])) {
            return redirect()
                ->back()
                ->withErrors([
                    'tenant_ids' => 'Salah satu kantin sudah tidak tersedia. Silakan pilih kembali.',
                ]);
        }

        // Simpan pilihan kantin
        session()->put('customer_selected_tenants', $tenantIds);

        // Sinkronisasi keranjang dengan pilihan kantin
        $cart = session()->get('customer_cart', []);

        $cart = array_intersect_key(
            $cart,
            array_flip($tenantIds)
        );

        session()->put('customer_cart', $cart);

        return redirect()->route('customer.products');
    }

    /**
     * Menampilkan produk dari tenant tertentu.
     */
    public function products(): View|RedirectResponse
    {
        $tenantIds = session('customer_selected_tenants', []);

        if (empty($tenantIds)) {
            return redirect()
                ->route('customer.tenants')
                ->with('warning', 'Silakan pilih minimal satu kantin.');
        }

        $tenants = Tenant::query()
            ->whereIn('id', $tenantIds)
            ->where('is_active', true)
            ->with([
                'products' => fn ($query) => $query
                    ->where('is_active', true)
                    ->latest(),
            ])
            ->get();

        if ($tenants->isEmpty()) {
            session()->forget('customer_selected_tenants');

            return redirect()
                ->route('customer.tenants')
                ->with('warning', 'Kantin yang dipilih sudah tidak tersedia.');
        }

        return view('customer.products', compact('tenants'));
    }

    /**
     * Menampilkan keranjang belanja pelanggan.
     */
    public function cart(): View
    {
        $cart = session()->get('customer_cart', []);

        $tenantIds = array_keys($cart);

        $tenants = Tenant::query()
            ->whereIn('id', $tenantIds)
            ->with('products')
            ->get()
            ->keyBy('id');

        return view('customer.cart', compact('cart', 'tenants'));
    }

    public function checkout(): View|RedirectResponse
    {
        $cart = session()->get('customer_cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('customer.cart')
                ->with('warning', 'Keranjang belanja masih kosong.');
        }

        $customerService = session('customer_service');
        $checkoutDetails = session('customer_checkout_details', []);

        if (! $customerService) {
            return redirect()
                ->route('customer.index')
                ->with('warning', 'Silakan pilih jenis layanan terlebih dahulu.');
        }

        $customerTable = null;

        if ($customerService['service_type'] === 'dine_in') {
            $customerTable = Table::query()
                ->where('id', $customerService['table_id'] ?? null)
                ->where('is_active', true)
                ->first();

            if (! $customerTable) {
                return redirect()
                    ->route('customer.index')
                    ->with('warning', 'Meja yang dipilih sudah tidak tersedia. Silakan pilih meja kembali.');
            }
        }

        $tenantIds = array_keys($cart);

        $tenants = Tenant::query()
            ->whereIn('id', $tenantIds)
            ->with('products')
            ->get()
            ->keyBy('id');

        $grandTotal = 0;
        $hasUnavailableItems = false;

        foreach ($cart as $tenantId => &$tenantCart) {
            $tenant = $tenants->get($tenantId);

            foreach ($tenantCart['items'] as $productId => &$item) {
                $product = $tenant?->products->firstWhere('id', $productId);

                $item['is_available'] = (
                    $tenant &&
                    $tenant->is_active &&
                    $product &&
                    $product->is_active
                );

                if (! $item['is_available']) {
                    $hasUnavailableItems = true;
                    continue;
                }

                $item['unit_price'] = (float) $product->price;
                $item['product_name'] = $product->name;
                $item['image'] = $product->image;

                $grandTotal += $item['unit_price'] * (int) $item['quantity'];
            }

            unset($item);
        }

        unset($tenantCart);

        return view('customer.checkout', compact(
            'cart',
            'tenants',
            'grandTotal',
            'hasUnavailableItems',
            'customerService',
            'checkoutDetails',
            'customerTable'
        ));
    }
}
