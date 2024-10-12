<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Receivable;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $data = json_decode(file_get_contents(public_path('options/pos.json')), true);
            if (empty($data) || $data == [] || $data == null || $data == '' || $data['pos'] == false) {
                return redirect()->route('admin.pos.register');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $product = Product::orderBy('id', 'DESC')->get();
        $invoice = generateInvoiceNumber('CSR');

        $customers = Customer::orderBy('id', 'DESC')->get();

        return view('pages._Main.Cashier.index', compact('invoice', 'product', 'customers'));
    }

    public function store(Request $request)
    {
        $data = json_decode(json_encode($request->all()));
        $dataTemp = $data->dataTemp;

        $transaction = DB::transaction(function () use ($data, $dataTemp) {
            $transaction = Transaction::create([
                'invoice' => $data->invoice,
                'customer_id' => $data->customer,
                'payment_method' => $data->payment_method,
                'total_price' => $data->total_cost,
                'grand_total' => $data->total_cost,
                'status' => 'Selesai',
                'payment_status' => $data->payment_method == 'cash' ? 'Lunas' : 'Belum Lunas',
                'paid' => $data->paid,
                'change' => $data->change,
                'user_id' => auth()->user()->id,
            ]);

            foreach ($dataTemp as $value) {
                $transaction->order()->create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $value->id_product,
                    'quantity' => $value->quantity,
                    'price' => $value->total_unit_cost,
                ]);

                $product = Product::find($value->id_product);
                $product->stock = $product->stock - $value->quantity;
                $product->save();
            }

            return $transaction;
        });

        if ($data->payment_method == 'debt') {
            Receivable::create([
                'transaction_id' => $transaction->id,
                'paid_amount' => $data->paid,
                'due_date' => $data->due_date,
            ]);

            CashFlow::create([
                'cash_flow_id' => $transaction->id,
                'invoice' => $transaction->invoice,
                'type' => 'Pengeluaran',
                'category' => 'Kasir',
                'nominal' => '0',
                'description' => 'Piutang penjualan offline (kasir)',
            ]);
        } else {
            CashFlow::create([
                'cash_flow_id' => $transaction->id,
                'invoice' => $transaction->invoice,
                'type' => 'Pemasukan',
                'category' => 'Kasir',
                'nominal' => $transaction->grand_total,
                'description' => 'Pendapatan penjualan offline (kasir)',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil',
            'data' => $transaction
        ]);
    }

    public function invoice($id)
    {
        // dd($id);
        $transaction = DB::table('transactions')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select(
                'transactions.id',
                'transactions.invoice',
                DB::raw('transactions.created_at as transaction_date'),
                'transactions.grand_total',
                'orders.id as order_id',
                'products.name as product_name',
                'orders.quantity as product_quantity',
                DB::raw('orders.price / orders.quantity as product_price'),
                DB::raw('orders.price as total_product_price'),
                'users.name as cashier_name',
                'transactions.paid',
                'transactions.change',
            )
            ->where('transactions.id', $id)
            ->groupBy(
                'transactions.id',
                'transactions.invoice',
                'transactions.created_at',
                'transactions.grand_total',
                'orders.id',
                'products.name',
                'orders.quantity',
                'orders.price',
                'users.name',
                'transactions.paid',
                'transactions.change',
            )
            ->orderBy('transactions.created_at', 'DESC')
            ->get();

        $data = [];

        foreach ($transaction as $item) {
            $data[$item->id]['id'] = $item->id;
            $data[$item->id]['transaction_invoice'] = $item->invoice;
            $data[$item->id]['transaction_date'] = $item->transaction_date;
            $data[$item->id]['grand_total'] = $item->grand_total;
            $data[$item->id]['cashier_name'] = $item->cashier_name;
            $data[$item->id]['paid'] = $item->paid;
            $data[$item->id]['change'] = $item->change;
            $data[$item->id]['product'][] = [
                'order_id' => $item->order_id,
                'product_name' => $item->product_name,
                'product_quantity' => $item->product_quantity,
                'product_price' => $item->product_price,
                'total_product_price' => $item->total_product_price,
            ];
        }

        $data = collect($data[$id]);
        return view('pages._Main.Cashier.slip', compact('data'));
    }

    public function close()
    {
        $data = json_decode(file_get_contents(public_path('options/pos.json')), true);

        $transaction = Transaction::whereBetween('created_at', [$data['date'], date('Y-m-d H:i:s')])
            ->where('status', 'Selesai')
            ->where('invoice', 'like', 'INV/%/CSR/%')
            ->get();

        $total = 0;
        foreach ($transaction as $item) {
            $total += $item->grand_total;
        }

        $posRegisterBalance = $data['data']['nominal100'] * 100000 +
            $data['data']['nominal50'] * 50000 +
            $data['data']['nominal20'] * 20000 +
            $data['data']['nominal10'] * 10000 +
            $data['data']['nominal5'] * 5000 +
            $data['data']['nominal2'] * 2000 +
            $data['data']['nominal1'] * 1000 +
            $data['data']['nominal05'] * 500 +
            $data['data']['nominal02'] * 200 +
            $data['data']['nominal01'] * 100;

        $dataTransaction = [
            'total_transaction' => $transaction->count(),
            'total' => $total,
            'pos_register_balance' => $posRegisterBalance,
            'balance' => $posRegisterBalance + $total,
            'data' => json_decode(json_encode($transaction)),
        ];

        return response()->json(
            $dataTransaction
        );
        // dd($dataTransaction);


        // $data['pos'] = false;
        // $data['date'] = date('Y-m-d H:i:s');
        // $data['data'] = [];

        // $json = json_encode($data);
        // file_put_contents(public_path('options/pos.json'), $json);

        // return redirect()->route('admin.pos.register');
    }

    public function close_cashier()
    {
        $data = json_decode(file_get_contents(public_path('options/pos.json')), true);

        $data['pos'] = false;
        $data['date'] = date('Y-m-d H:i:s');
        $data['data'] = [];

        $json = json_encode($data);
        file_put_contents(public_path('options/pos.json'), $json);

        return response()->json([
            'success' => true,
            'message' => 'Kasir berhasil ditutup',
        ]);
    }
}
