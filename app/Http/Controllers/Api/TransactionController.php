<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        //set middleware
        $this->middleware('auth:api');
    }

    public function listTransaction()
    {
        $transaction = DB::table('transactions')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('reviews', 'orders.id', '=', 'reviews.order_id')
            ->select(
                'transactions.id',
                DB::raw('transactions.created_at as transaction_date'),
                'transactions.status as transaction_status',
                'transactions.invoice',
                'transactions.grand_total',
                'orders.id as order_id',
                'products.name as product_name',
                'products.thumbnail',
                'orders.quantity as product_quantity',
                DB::raw('orders.price / orders.quantity as product_price'),
                DB::raw('orders.price as total_product_price'),
                'transactions.snap_token',
                'reviews.rating'
            )
            ->where('transactions.customer_id', auth()->guard('api')->user()->id)
            ->groupBy(
                'transactions.id',
                'transactions.created_at',
                'transactions.status',
                'transactions.invoice',
                'transactions.snap_token',
                'transactions.grand_total',
                'orders.id',
                'products.name',
                'products.price',
                'products.thumbnail',
                'orders.quantity',
                'orders.price',
                'reviews.rating',
            )
            ->orderBy('transactions.created_at', 'DESC')
            ->get();

        $data = [];

        foreach ($transaction as $item) {
            $data[$item->id]['id'] = $item->id;
            $data[$item->id]['transaction_date'] = $item->transaction_date;
            $data[$item->id]['transaction_status'] = $item->transaction_status;
            $data[$item->id]['transaction_invoice'] = $item->invoice;
            $data[$item->id]['grand_total'] = $item->grand_total;
            $data[$item->id]['snap_token'] = $item->snap_token;
            $data[$item->id]['product'][] = [
                'order_id' => $item->order_id,
                'product_name' => $item->product_name,
                'product_thumbnail' => $item->thumbnail,
                'product_quantity' => $item->product_quantity,
                'product_price' => $item->product_price,
                'total_product_price' => $item->total_product_price,
                'rating' => $item->rating ? true : false,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'List Transaction',
            'data'    => array_values($data)
        ]);
    }

    public function detailTransaction($id)
    {
        $transaction = DB::table('transactions')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            // join customer 
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            // join address
            ->join('addresses', 'customers.id', '=', 'addresses.customer_id')
            ->select(
                'transactions.id',
                DB::raw('transactions.created_at as transaction_date'),
                'transactions.status as transaction_status',
                'transactions.invoice',
                'transactions.courier',
                'transactions.courier_service',
                'transactions.receipt_number',
                'addresses.address as customer_address',
                'transactions.payment_method',
                'transactions.courier_cost',
                'transactions.total_discount',
                'transactions.service_fee',
                'transactions.total_price',
                'transactions.grand_total',
                'orders.id as order_id',
                'products.name as product_name',
                'products.thumbnail',
                'orders.quantity as product_quantity',
                DB::raw('orders.price / orders.quantity as product_price'),
                DB::raw('orders.price as total_product_price'),
                'transactions.snap_token'
            )
            ->where('transactions.customer_id', auth()->guard('api')->user()->id)
            ->where('transactions.id', $id)
            ->groupBy(
                'transactions.id',
                'transactions.created_at',
                'transactions.status',
                'transactions.invoice',
                'transactions.snap_token',
                'orders.id',
                'products.name',
                'products.price',
                'products.thumbnail',
                'orders.quantity',
                'orders.price',
                'transactions.courier',
                'transactions.courier_service',
                'transactions.receipt_number',
                'addresses.address',
                'transactions.payment_method',
                'transactions.courier_cost',
                'transactions.total_discount',
                'transactions.service_fee',
                'transactions.total_price',
                'transactions.grand_total'
            )
            ->get();

        $data = [];

        foreach ($transaction as $item) {
            $data[$item->id]['id'] = $item->id;
            $data[$item->id]['transaction_invoice'] = $item->invoice;
            $data[$item->id]['transaction_date'] = $item->transaction_date;
            $data[$item->id]['transaction_status'] = $item->transaction_status;
            $data[$item->id]['courier'] = $item->courier . ' - ' . $item->courier_service;
            $data[$item->id]['receipt_number'] = $item->receipt_number;
            $data[$item->id]['customer_address'] = $item->customer_address;
            $data[$item->id]['payment_method'] = $item->payment_method;
            $data[$item->id]['total_price'] = $item->total_price;
            $data[$item->id]['courier_cost'] = $item->courier_cost;
            $data[$item->id]['total_discount'] = $item->total_discount;
            $data[$item->id]['service_fee'] = $item->service_fee;
            $data[$item->id]['grand_total'] = $item->grand_total;
            $data[$item->id]['product'][] = [
                'order_id' => $item->order_id,
                'product_name' => $item->product_name,
                'product_thumbnail' => $item->thumbnail,
                'product_quantity' => $item->product_quantity,
                'product_price' => $item->product_price,
                'total_product_price' => $item->total_product_price,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Transaction',
            'data'    => array_values($data)
        ]);
    }
}
