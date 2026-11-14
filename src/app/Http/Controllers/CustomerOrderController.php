<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerOrderController extends Controller
{
    /**
     * Menampilkan halaman utama pemesanan.
     */
    public function index(): View
    {
        return view('customer.index');
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

        session()->put('customer_service', [
            'service_type' => $validated['service_type'],
        ]);

        return redirect()->route('customer.tenants');
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

    /**
     * Menampilkan produk dari tenant tertentu.
     */
    public function products(Tenant $tenant): View
    {
        abort_unless($tenant->is_active, 404);

        $products = $tenant->products()
            ->latest()
            ->get();

        return view('customer.products', compact('tenant', 'products'));
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

        if (! $customerService) {
            return redirect()
                ->route('customer.index')
                ->with('warning', 'Silakan pilih jenis layanan terlebih dahulu.');
        }

        $tenantIds = array_keys($cart);

        $tenants = Tenant::query()
            ->whereIn('id', $tenantIds)
            ->with('products')
            ->get()
            ->keyBy('id');

        $grandTotal = 0;
        $hasUnavailableItems = false;

        foreach ($cart as $tenantId => $tenantCart) {
            $tenant = $tenants->get($tenantId);

            foreach ($tenantCart['items'] as $productId => $item) {
                $product = $tenant?->products->firstWhere('id', $productId);

                if (! $tenant || ! $tenant->is_active || ! $product || ! $product->is_active) {
                    $hasUnavailableItems = true;

                    continue;
                }

                $grandTotal += (float) $product->price * (int) $item['quantity'];
            }
        }

        return view('customer.checkout', compact(
            'cart',
            'tenants',
            'grandTotal',
            'hasUnavailableItems',
            'customerService'
        ));
    }
}