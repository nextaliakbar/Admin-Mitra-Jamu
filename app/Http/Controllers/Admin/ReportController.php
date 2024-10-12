<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
  public function index(Request $request)
  {
    if ($request->has('start_date') && $request->has('end_date')) {
      // format date
      $start_date = date('Y-m-d', strtotime($request->start_date));
      $end_date = date('Y-m-d', strtotime($request->end_date));
      $transaction = DB::table('transactions')
          ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
          ->join('products', 'orders.product_id', '=', 'products.id')
          ->select(
              'transactions.id',
              DB::raw('transactions.created_at as transaction_date'),
              'transactions.status as transaction_status',
              'transactions.invoice',
              'transactions.grand_total',
              'orders.id as order_id',
              'products.id as product_id',
              'products.name as product_name',
              'products.thumbnail',
              'orders.quantity as product_quantity',
              DB::raw('orders.price / orders.quantity as product_price'),
              DB::raw('orders.price as total_product_price'),
              'transactions.snap_token'
          )
          ->whereBetween('transactions.created_at', [$start_date, $end_date])
          ->groupBy(
              'transactions.id',
              'transactions.created_at',
              'transactions.status',
              'transactions.invoice',
              'transactions.snap_token',
              'transactions.grand_total',
              'orders.id',
              'products.id',
              'products.name',
              'products.price',
              'products.thumbnail',
              'orders.quantity',
              'orders.price'
          )
          ->orderBy('transactions.created_at', 'DESC')
          ->get();
        }else{
          $transaction = DB::table('transactions')
          ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
          ->join('products', 'orders.product_id', '=', 'products.id')
          ->select(
              'transactions.id',
              DB::raw('transactions.created_at as transaction_date'),
              'transactions.status as transaction_status',
              'transactions.invoice',
              'transactions.grand_total',
              'orders.id as order_id',
              'products.id as product_id',
              'products.name as product_name',
              'products.thumbnail',
              'orders.quantity as product_quantity',
              DB::raw('orders.price / orders.quantity as product_price'),
              DB::raw('orders.price as total_product_price'),
              'transactions.snap_token'
          )
          ->groupBy(
              'transactions.id',
              'transactions.created_at',
              'transactions.status',
              'transactions.invoice',
              'transactions.snap_token',
              'transactions.grand_total',
              'orders.id',
              'products.id',
              'products.name',
              'products.price',
              'products.thumbnail',
              'orders.quantity',
              'orders.price'
          )
          ->orderBy('transactions.created_at', 'DESC')
          ->get();
        }
      $dataTransaction = [];

      foreach ($transaction as $item) {
          $dataTransaction[$item->id]['id'] = $item->id;
          $dataTransaction[$item->id]['transaction_date'] = $item->transaction_date;
          $dataTransaction[$item->id]['transaction_status'] = $item->transaction_status;
          $dataTransaction[$item->id]['transaction_invoice'] = $item->invoice;
          $dataTransaction[$item->id]['grand_total'] = $item->grand_total;
          $dataTransaction[$item->id]['snap_token'] = $item->snap_token;
          $dataTransaction[$item->id]['product'][] = [
              'order_id' => $item->order_id,
              'product_id' => $item->product_id, // 'product_id' => $item->order_id,
              'product_name' => $item->product_name,
              'product_thumbnail' => $item->thumbnail,
              'product_quantity' => $item->product_quantity,
              'product_price' => $item->product_price,
              'total_product_price' => $item->total_product_price,
          ];
      }

      $data = [];
      foreach ($dataTransaction as $item) {
          $date = $item['transaction_date'];
          $invoice = $item['transaction_invoice'];
          $harga_jual = $item['grand_total'];
          // harga beli get from product->purchaseList->unit_cost
          foreach ($item['product'] as $product) {
              $harga_beli = DB::table('purchase_lists')
                  ->where('product_id', $product['product_id'])
                  ->select('unit_cost')
                  ->first();

              $harga_beli = $harga_beli->unit_cost * $product['product_quantity'];
          }


          $total_laba_rugi = $harga_jual - $harga_beli;

          $data[] = [
              'date' => $date,
              'invoice' => $invoice,
              'harga_jual' => $harga_jual,
              'harga_beli' => $harga_beli,
              'total_laba_rugi' => $total_laba_rugi,
          ];
      }

      $collection = collect($data);

      $total = [
          'total_penjualan' => $collection->sum('harga_jual'),
      ];

      $total = collect($total);

      return view('pages._Main.Accounting.Report.index', [
          'data' => $collection,
          'total' => $total,
      ]);
  }
}
