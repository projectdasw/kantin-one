<?php

namespace App\Http\Controllers;

use App\Models\TenantOrder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TenantOrderController extends Controller
{
    /**
     * Menampilkan data pesanan milik tenant yang sedang login.
     */
    public function index(Request $request)
    {
        $tenantId = auth()->user()->tenant_id;

        if (! $tenantId) {
            abort(403, 'Akun tidak terhubung dengan tenant.');
        }

        $query = TenantOrder::query()
            ->with([
                'order.payment',
                'items',
            ])
            ->where('tenant_id', $tenantId)
            ->whereHas('order.payment', function ($paymentQuery) {
                $paymentQuery->where('status', 'paid');
            })
            ->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('pickup_code', 'like', "%{$search}%")
                    ->orWhereHas('order', function ($orderQuery) use ($search) {
                        $orderQuery->where('customer_name', 'like', "%{$search}%");
                    });
            });
        }

        return response()->json([
            'orders' => $query->get(),
            'counts' => TenantOrder::query()
                ->where('tenant_id', $tenantId)
                ->whereHas('order.payment', function ($paymentQuery) {
                    $paymentQuery->where('status', 'paid');
                })
                ->selectRaw("
                    COUNT(*) FILTER (WHERE status = 'pending') AS waiting,
                    COUNT(*) FILTER (WHERE status = 'preparing') AS processing,
                    COUNT(*) FILTER (WHERE status = 'ready') AS ready,
                    COUNT(*) FILTER (WHERE status = 'completed') AS completed
                ")
                ->first(),
        ]);
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tenant_order_id' => ['required', 'uuid'],
            'status' => ['required', 'in:preparing,ready,completed'],
        ]);

        $tenantId = auth()->user()->tenant_id;

        if (! $tenantId) {
            abort(403, 'Akun tidak terhubung dengan tenant.');
        }

        $result = DB::transaction(function () use ($validated, $tenantId) {
            $tenantOrder = TenantOrder::query()
                ->with('order.payment')
                ->where('tenant_id', $tenantId)
                ->whereKey($validated['tenant_order_id'])
                ->lockForUpdate()
                ->first();

            if (! $tenantOrder) {
                return 'not_found';
            }

            if ($tenantOrder->order?->payment?->status !== 'paid') {
                return 'unpaid';
            }

            $transitions = [
                'pending' => 'preparing',
                'preparing' => 'ready',
                'ready' => 'completed',
            ];

            $newStatus = $validated['status'];

            if (($transitions[$tenantOrder->status] ?? null) !== $newStatus) {
                return 'invalid_transition';
            }

            $timestamps = [
                'preparing' => ['accepted_at' => now()],
                'ready' => ['ready_at' => now()],
                'completed' => ['completed_at' => now()],
            ];

            $tenantOrder->update([
                'status' => $newStatus,
                ...$timestamps[$newStatus],
            ]);

            return 'success';
        });

        if ($result !== 'success') {
            $message = 'Perubahan status pesanan tidak valid.';
            $statusCode = 422;

            if ($result === 'not_found') {
                $message = 'Pesanan tidak ditemukan.';
                $statusCode = 404;
            } elseif ($result === 'unpaid') {
                $message = 'Pesanan belum dibayar.';
            }

            return response()->json([
                'message' => $message,
            ], $statusCode);
        }

        return response()->json([
            'message' => 'Status pesanan berhasil diperbarui.',
        ]);
    }
}
