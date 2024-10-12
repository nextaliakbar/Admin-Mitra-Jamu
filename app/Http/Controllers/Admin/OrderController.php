<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $transactions = DB::table('transactions')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->select(
                'transactions.id',
                'transactions.created_at',
                'transactions.invoice',
                'transactions.receipt_number',
                'customers.name',
                'transactions.grand_total',
                'transactions.notes',
                'transactions.payment_method',
                'transactions.status',
                'transactions.payment_status'
            )
            ->where(function ($query) {
                $search = request()->search;
                $query->where('transactions.invoice', 'like', "%$search%")
                    ->orWhere('transactions.receipt_number', 'like', "%$search%")
                    ->orWhere('transactions.created_at', 'like', "%$search%");
            })
            ->where('transactions.invoice', 'like', 'INV/%/ECM/%')
            ->orderBy('transactions.created_at', 'DESC')
            ->paginate(10);

        return view('pages._Main.Ecommerce.order.index', compact('transactions'));
    }

    public function show($id)
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
                'transactions.payment_status',
                'transactions.courier_cost',
                'transactions.total_discount',
                'transactions.service_fee',
                'transactions.total_price',
                'transactions.grand_total',
                'products.id as product_id',
                'products.name as product_name',
                'products.thumbnail',
                'orders.quantity as product_quantity',
                DB::raw('orders.price / orders.quantity as product_price'),
                DB::raw('orders.price as total_product_price'),
                'transactions.snap_token'
            )
            ->where('transactions.id', $id)
            ->groupBy(
                'transactions.id',
                'transactions.created_at',
                'transactions.status',
                'transactions.invoice',
                'transactions.snap_token',
                'products.id',
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
                'transactions.grand_total',
                'transactions.payment_status'
            )
            ->get();

        $data = [];

        foreach ($transaction as $item) {
            $data[$item->id]['id'] = $item->id;
            $data[$item->id]['transaction_invoice'] = $item->invoice;
            $data[$item->id]['transaction_date'] = Carbon::parse($item->transaction_date)->format('d F Y');
            $data[$item->id]['transaction_status'] = $item->transaction_status;
            $data[$item->id]['courier'] = $item->courier . ' - ' . $item->courier_service;
            $data[$item->id]['receipt_number'] = $item->receipt_number;
            $data[$item->id]['customer_address'] = $item->customer_address;
            $data[$item->id]['payment_method'] = $item->payment_method;
            $data[$item->id]['payment_status'] = $item->payment_status;
            $data[$item->id]['total_price'] = moneyFormat($item->total_price);
            $data[$item->id]['courier_cost'] = moneyFormat($item->courier_cost);
            $data[$item->id]['total_discount'] = moneyFormat($item->total_discount);
            $data[$item->id]['service_fee'] = moneyFormat($item->service_fee);
            $data[$item->id]['grand_total'] = moneyFormat($item->grand_total);
            $data[$item->id]['product'][] = [
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'product_thumbnail' => $item->thumbnail,
                'product_quantity' => $item->product_quantity,
                'product_price' => moneyFormat($item->product_price),
                'total_product_price' => moneyFormat($item->total_product_price),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Transaction',
            'data'    => array_values($data)
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->editStatus;
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Mengubah Status',
            'data' => $transaction
        ]);
    }

    public function addReceipt(Request $request, $id)
    {
        $request->validate([
            'receipt' => 'required|string|max:255'
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->receipt_number = $request->receipt;
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menambahkan Nomor Resi',
            'data' => $transaction
        ], 200);
    }

    public function invoice($id)
    {
        $transaction = DB::table('transactions')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->select(
                'transactions.id',
                'transactions.created_at',
                'transactions.invoice',
                'transactions.receipt_number',
                'customers.name',
                'customers.email',
                'customers.phone',
                'customers.address',
                'transactions.grand_total',
                'transactions.notes',
                'transactions.payment_method',
                'transactions.status',
            )
            ->where('transactions.id', $id)
            ->first();

        $orders = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select(
                'orders.id',
                'orders.quantity',
                'orders.price',
                'products.name',
                'products.slug',
                'products.image',
            )
            ->where('orders.transaction_id', $id)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Mendapatkan Data Invoice',
            'data' => [
                'transaction' => $transaction,
                'orders' => $orders,
            ],
        ]);
    }

    public function tracking($id)
    {
        if ($id == null) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Resi belum diisi',
            ]);
        }

        $transaction = Transaction::findOrFail($id);
        $id = $transaction->receipt_number;
        $courier = dataCourier($transaction->courier);

        $dataTransaction = [
            'invoice' => $transaction->invoice,
            'date' => Carbon::parse($transaction->created_at)->format('d F Y'),
        ];

        if ($transaction->receipt_number == null || $transaction->receipt_number == '') {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Resi belum diisi',
                'transaction' => $dataTransaction,
            ]);
        }

        $curl = curl_init();
        $key = config('services.rajaongkir.key');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "waybill=$id&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Resi tidak ditemukan',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Melacak Nomor Resi',
                'data' => json_decode($response, true),
                'transaction' => $dataTransaction,
            ]);
        }
    }
}
