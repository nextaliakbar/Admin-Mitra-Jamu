<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function review(Request $request)
    {
        if (!$request->order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order ID belum diisi'
            ]);
        }

        if (!$request->rating) {
            return response()->json([
                'success' => false,
                'message' => 'Rating belum diisi'
            ]);
        }

        if (!$request->review) {
            return response()->json([
                'success' => false,
                'message' => 'Review belum diisi'
            ]);
        }

        if ($request->rating < 1 || $request->rating > 5) {
            return response()->json([
                'success' => false,
                'message' => 'Rating harus diantara 1 sampai 5'
            ]);
        }

        $review = DB::table('reviews')
            ->join('orders', 'orders.id', '=', 'reviews.order_id')
            ->join('transactions', 'transactions.id', '=', 'orders.transaction_id')
            ->join('customers', 'customers.id', '=', 'transactions.customer_id')
            ->select(
                'reviews.*'
            )
            ->where('order_id', $request->order_id)
            ->where('customers.id', auth()->guard('api')->user()->id)
            ->first();

        $statusOrder = DB::table('orders')
            ->join('transactions', 'transactions.id', '=', 'orders.transaction_id')
            ->select('transactions.status')
            ->where('orders.id', $request->order_id)
            ->first();

        if ($statusOrder->status != 'Selesai') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi belum selesai'
            ]);
        }


        if ($review) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan review untuk produk ini'
            ]);
        }

        Review::create([
            'title' => $request->title,
            'order_id'    => $request->order_id,
            'rating'      => $request->rating,
            'review'      => $request->review
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil ditambahkan'
        ]);
    }

    public function list()
    {
        $transaction = DB::table('transactions')
            ->join('orders', 'orders.transaction_id', '=', 'transactions.id')
            ->leftjoin('reviews', 'reviews.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->select(
                'transactions.invoice as transaction_invoice',
                'orders.id as order_id',
                'products.id as product_id',
                'products.name as product_name',
                'products.slug as product_slug',
                'products.thumbnail as product_thumbnail',
                'reviews.created_at as review_date',
                'reviews.review as review',
                'reviews.rating as rating'
            )
            ->where('transactions.customer_id', auth()->guard('api')->user()->id)
            ->where('transactions.status', 'Selesai')
            ->get();

        $data = [];

        foreach ($transaction as $item) {
            $data[$item->transaction_invoice]['transaction_invoice'] = $item->transaction_invoice;
            if ($item->order_id) {
                $data[$item->transaction_invoice]['orders'][] = [
                    'order_id' => $item->order_id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'product_slug' => $item->product_slug,
                    'product_thumbnail' => $item->product_thumbnail,
                    'review_date' => $item->review_date,
                    'review' => $item->review,
                    'rating' => $item->rating
                ];
            } else {
                $data[$item->transaction_invoice]['orders'] = null;
            }
        }

        return response()->json([
            'success' => true,
            'data' => array_values($data)
        ], 200);
    }

    public function getReviewByOrder($id)
    {
        $review = DB::table('reviews')
            ->join('orders', 'orders.id', '=', 'reviews.order_id')
            ->join('transactions', 'transactions.id', '=', 'orders.transaction_id')
            ->join('customers', 'customers.id', '=', 'transactions.customer_id')
            ->select(
                'reviews.*'
            )
            ->where('order_id', $id)
            ->where('customers.id', auth()->guard('api')->user()->id)
            ->first();

        $statusOrder = DB::table('orders')
            ->join('transactions', 'transactions.id', '=', 'orders.transaction_id')
            ->select('transactions.status')
            ->where('orders.id', $id)
            ->first();

        if ($statusOrder->status != 'Selesai') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi belum selesai'
            ]);
        }


        if ($review) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan review untuk produk ini'
            ]);
        }

        // data review : nama produk, thumbnail, order_id
        $data = DB::table('orders')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->select(
                'orders.id as order_id',
                'products.name as product_name',
                'products.thumbnail as product_thumbnail'
            )
            ->where('orders.id', $id)
            ->first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
