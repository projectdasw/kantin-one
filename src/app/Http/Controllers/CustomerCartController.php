<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class CustomerCartController extends Controller
{
    public function increase(Product $product): JsonResponse
    {
        abort_unless(
            $product->is_active && $product->tenant->is_active,
            404
        );

        $cart = session()->get('customer_cart', []);

        $tenantId = $product->tenant_id;
        $productId = $product->id;

        if (! isset($cart[$tenantId])) {
            $cart[$tenantId] = [
                'tenant_id' => $tenantId,
                'tenant_name' => $product->tenant->name,
                'items' => [],
            ];
        }

        if (! isset($cart[$tenantId]['items'][$productId])) {
            $cart[$tenantId]['items'][$productId] = [
                'product_id' => $productId,
                'product_name' => $product->name,
                'product_code' => $product->code,
                'unit_price' => (float) $product->price,
                'image' => $product->image,
                'quantity' => 0,
            ];
        }

        $cart[$tenantId]['items'][$productId]['quantity']++;

        session()->put('customer_cart', $cart);

        return response()->json([
             'success' => true,
            'quantity' => $cart[$tenantId]['items'][$productId]['quantity'],
        ]);
    }

    public function decrease(Product $product): JsonResponse
    {
        $cart = session()->get('customer_cart', []);

        $tenantId = $product->tenant_id;
        $productId = $product->id;

        if (isset($cart[$tenantId]['items'][$productId])) {
            $cart[$tenantId]['items'][$productId]['quantity']--;

            if ($cart[$tenantId]['items'][$productId]['quantity'] <= 0) {
                unset($cart[$tenantId]['items'][$productId]);
            }

            if (empty($cart[$tenantId]['items'])) {
                unset($cart[$tenantId]);
            }
        }

        session()->put('customer_cart', $cart);

        return response()->json([
            'success' => true,
            'quantity' => $cart[$tenantId]['items'][$productId]['quantity'] ?? 0,
        ]);
    }

    public function remove(string $productId): JsonResponse
    {
        $cart = session()->get('customer_cart', []);

        foreach ($cart as $tenantId => &$tenantCart) {
            if (isset($tenantCart['items'][$productId])) {
                unset($tenantCart['items'][$productId]);

                if (empty($tenantCart['items'])) {
                    unset($cart[$tenantId]);
                }

                break;
            }
        }

        unset($tenantCart);

        session()->put('customer_cart', $cart);

        return response()->json([
            'success' => true,
        ]);
    }
}