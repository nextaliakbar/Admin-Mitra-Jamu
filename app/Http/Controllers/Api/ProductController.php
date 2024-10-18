<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function list()
    {
        // dd(request()->all());

        $products = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_labels', 'products.product_label_id', '=', 'product_labels.id')
            ->leftjoin('orders', 'orders.product_id', '=', 'products.id')
            ->leftjoin('reviews', 'reviews.order_id', '=', 'orders.id')
            ->whereNull('products.deleted_at')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                'product_labels.name as label_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
                DB::raw('CAST(products.price AS INTEGER) as product_price'),
                DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
            )
            ->orderBy('products.created_at', 'ASC')
            ->when(request()->q, function ($data) {
                return $data->where('products.name', 'ILIKE', '%' . request()->q . '%');
            })
            ->when(request()->slug, function ($data) {
                return $data->where('products.slug', '=', request()->slug);
            })
            ->when(request()->filter, function ($data) {
                if (request()->filter == 'active') {
                    return $data->where('products.is_active', '=', 1);
                } elseif (request()->filter == 'draft') {
                    return $data->where('products.is_active', '=', 0);
                }
            })
            ->when(request()->category, function ($data) {
                return $data->where('products.product_category_id', '=', request()->category);
            })
            ->when(request()->label, function ($data) {
                return $data->where('products.product_label_id', '=', request()->label);
            })
            ->groupBy('products.id', 'product_categories.name', 'product_labels.name', 'products.created_at', 'price_after_discount')
            ->get();


        if (request()->sort) {
            switch (request()->sort) {
                case 'price_asc':
                    $products = $products->sortBy('price_after_discount');
                    break;
                case 'price_desc':
                    $products = $products->sortByDesc('price_after_discount');
                    break;
                case 'newest':
                    $products = $products->sortByDesc('created_at');
                    break;
                case 'oldest':
                    $products = $products->sortBy('created_at');
                    break;
                case 'bestseller':
                    $products = $products->sortByDesc('review_count');
                    break;
                case 'rating':
                    $products = $products->sortByDesc('rating_avg');
                    break;
            }
        } else {
            $products = $products->sortByDesc('rating_avg');
        }

        if (request()->rating) {
            switch (request()->rating) {
                case '1':
                    $products = $products->where('rating_avg', '>=', 0)->where('rating_avg', '<', 2);
                    break;
                case '2':
                    $products = $products->where('rating_avg', '>=', 2)->where('rating_avg', '<', 3);
                    break;
                case '3':
                    $products = $products->where('rating_avg', '>=', 3)->where('rating_avg', '<', 4);
                    break;
                case '4':
                    $products = $products->where('rating_avg', '>=', 4)->where('rating_avg', '<', 5);
                    break;
                case '5':
                    $products = $products->where('rating_avg', '>=', 5);
                    break;
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'products' => $products,
            ],
        ], 200);
    }

    public function detail($slug)
    {
        $product = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->leftjoin('orders', 'products.id', '=', 'orders.product_id')
            ->leftjoin('reviews', 'orders.id', '=', 'reviews.order_id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
                DB::raw('CAST(products.price AS INTEGER) as product_price'),
                DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
            )
            ->addSelect(DB::raw('SUM(orders.quantity) as order_quantity'))
            ->where('products.slug', '=', $slug)
            ->groupBy('products.id', 'product_categories.name')
            ->first();

        // review list
        $reviews = DB::table('reviews')
            ->join('orders', 'reviews.order_id', '=', 'orders.id')
            ->join('transactions', 'orders.transaction_id', '=', 'transactions.id')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select(
                'customers.name as customer_name',
                'customers.avatar as customer_avatar',
                'reviews.rating',
                'reviews.review',
                'reviews.created_at as review_date'
            )
            ->where('products.slug', '=', $slug)
            ->orderBy('reviews.created_at', 'DESC')
            ->get();

        // product image list
        $productImages = DB::table('product_images')
            ->select('product_images.*')
            ->where('product_images.product_id', '=', $product->id)
            ->orderBy('product_images.created_at', 'ASC')
            ->get();

        // related products by category
        $relatedProducts = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_labels', 'products.product_label_id', '=', 'product_labels.id')
            ->join('orders', 'orders.product_id', '=', 'products.id')
            ->join('reviews', 'reviews.order_id', '=', 'orders.id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                'product_labels.name as label_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
                DB::raw('CAST(products.price AS INTEGER) as product_price'),
                DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
            )
            ->where('products.product_category_id', '=', $product->product_category_id)
            ->where('products.id', '!=', $product->id)
            ->orderBy('products.created_at', 'DESC')
            ->groupBy('products.id', 'product_categories.name', 'product_labels.name')
            ->limit(4)
            ->get();

        if ($product) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'product' => $product,
                    'product_images' => $productImages,
                    'related_products' => $relatedProducts,
                    'reviews' => $reviews,
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
    }

    public function latestProduct()
    {
        $products = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_labels', 'products.product_label_id', '=', 'product_labels.id')
            ->leftjoin('orders', 'orders.product_id', '=', 'products.id')
            ->leftjoin('reviews', 'reviews.order_id', '=', 'orders.id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                'product_labels.name as label_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
                DB::raw('CAST(products.price AS INTEGER) as product_price'),
                DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
            )
            ->orderBy('products.created_at', 'DESC')
            ->groupBy('products.id', 'product_categories.name', 'product_labels.name')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ], 200);
    }

    public function selectedProduct()
    {
        $products = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_labels', 'products.product_label_id', '=', 'product_labels.id')
            ->leftjoin('orders', 'orders.product_id', '=', 'products.id')
            ->leftjoin('reviews', 'reviews.order_id', '=', 'orders.id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                'product_labels.name as label_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
                DB::raw('CAST(products.price AS INTEGER) as product_price'),
                DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
            )
            ->where('products.is_selected', '=', 1)
            ->orderBy('products.created_at', 'DESC')
            ->groupBy('products.id', 'product_categories.name', 'product_labels.name')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ], 200);
    }
}
