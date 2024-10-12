<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function list()
    {
        $wishlist = Wishlist::where('customer_id', auth()->guard('api')->user()->id)->first();
        if (!$wishlist) {
            return response()->json([
                'success' => true,
                'message' => 'Wishlist kosong'
            ], 200);
        }

        $wishlists = DB::table('products')
            ->join('wishlists', 'products.id', '=', 'wishlists.product_id')
            ->leftjoin('orders', 'orders.product_id', '=', 'products.id')
            ->leftjoin('reviews', 'reviews.order_id', '=', 'orders.id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.slug as product_slug',
                'products.thumbnail as product_thumbnail',
                'products.discount as product_discount',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
                DB::raw('CAST(products.price AS INTEGER) as product_price'),
                DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
            )
            ->where('wishlists.customer_id', auth()->guard('api')->user()->id)
            ->orderBy('products.created_at', 'ASC')
            ->groupBy('products.id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $wishlists
        ], 200);
    }

    public function wishlist(Request $request)
    {
        $wishlist = Wishlist::where('customer_id', auth()->guard('api')->user()->id)->where('product_id', $request->product_id)->first();

        if ($wishlist) {
            $wishlist->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari wishlist'
            ]);
        }

        Wishlist::create([
            'customer_id' => auth()->guard('api')->user()->id,
            'product_id'  => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke wishlist'
        ]);
    }

    public function getWishlistStatus($slug)
    {
        $wishlist = DB::table('wishlists')
            ->join('products', 'products.id', '=', 'wishlists.product_id')
            ->select('products.slug')
            ->where('wishlists.customer_id', auth()->guard('api')->user()->id)
            ->where('products.slug', $slug)
            ->first();

        if ($wishlist) {
            return response()->json([
                'success' => true,
                'data' => true
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => false
        ]);
    }
}
