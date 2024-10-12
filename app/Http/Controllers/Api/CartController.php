<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);


        $cart = Cart::where('product_id', $request->product_id)->where('customer_id', auth()->guard('api')->user()->id);

        $product = Product::where('id', $request->product_id)->first();
        $productPrice = $product->price - ($product->price * $product->discount / 100);

        if ($cart->exists()) {
            if ($cart->first()->quantity + $request->quantity > $cart->first()->product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product stock is not enough',
                ], 400);
            }
            $cart->increment('quantity', $request->quantity);
            $cart->update([
                'price' => $productPrice * $cart->first()->quantity,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product quantity updated',
            ], 200);
        }

        if ($request->quantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Product stock is not enough',
            ], 400);
        }

        $addCart = Cart::create([
            'customer_id' => auth()->guard('api')->check() ? auth()->guard('api')->user()->id : null,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $productPrice * $request->quantity,
        ]);

        if (!$addCart) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
        ], 200);
    }

    public function list()
    {
        $carts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select(
                'carts.id',
                'carts.quantity',
                'products.id as product_id',
                'products.name',
                'products.discount',
                'products.thumbnail',
                DB::raw('CAST(products.price AS FLOAT) as product_price'),
                DB::raw('CAST((products.price - (products.price * products.discount / 100)) AS FLOAT) as price_after_discount'),
                DB::raw('CAST(products.stock AS FLOAT) as total_stock'),
                DB::raw('CAST((products.price - (products.price * products.discount / 100)) * carts.quantity AS FLOAT) as total_price_product'),
            )
            ->where('carts.customer_id', auth()->guard('api')->user()->id)
            ->orderBy('carts.id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Cart list',
            'data' => $carts,
        ], 200);
    }

    public function cartSummary()
    {
        $carts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select(
                DB::raw('CAST(SUM(products.price * carts.quantity) AS FLOAT) as total_price_before_discount'),
                DB::raw('CAST(SUM(carts.quantity) AS FLOAT) as total_product'),
                DB::raw('CAST(SUM(products.price * products.discount / 100) * carts.quantity AS FLOAT) as total_discount_price'),
                DB::raw('CAST(SUM(products.price - (products.price * products.discount / 100)) * carts.quantity AS FLOAT) as total_price'),
                DB::raw('CAST(SUM(products.weight * carts.quantity) AS FLOAT) as total_weight'),
            )
            ->where('carts.customer_id', auth()->guard('api')->user()->id)
            ->groupBy('carts.customer_id', 'carts.quantity', 'products.discount', 'products.price')
            ->get();

        $total_price_before_discount = 0;
        $total_product = 0;
        $total_discount_price = 0;
        $total_price = 0;
        $total_weight = 0;

        foreach ($carts as $cart) {
            $total_price_before_discount += $cart->total_price_before_discount;
            $total_product += $cart->total_product;
            $total_discount_price += $cart->total_discount_price;
            $total_price += $cart->total_price;
            $total_weight += $cart->total_weight;
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart summary',
            'data' => [
                'total_price_before_discount' => $total_price_before_discount,
                'total_product' => $total_product,
                'total_discount_price' => $total_discount_price,
                'total_price' => $total_price,
                'total_weight' => $total_weight,
            ],
        ], 200);
    }

    public function removeCart($id)
    {
        $cart = Cart::where('id', $id)->where('customer_id', auth()->guard('api')->user()->id);

        if (!$cart->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found',
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart deleted',
        ], 200);
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('id', $id)->where('customer_id', auth()->guard('api')->user()->id);

        if (!$cart->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found',
            ], 404);
        }

        $productPrice = Product::where('id', $cart->first()->product_id)->first();
        $productPrice = $productPrice->price - ($productPrice->price * $productPrice->discount / 100);

        if ($request->quantity > $cart->first()->product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Product stock is not enough',
            ], 400);
        }

        $cart->update([
            'quantity' => $request->quantity,
            'price' => $productPrice * $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
        ], 200);
    }
}
