<?php

namespace App\Http\Controllers;

use App\Imports\TransactionImport;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CustomTransactionController extends Controller
{
    public function index()
    {
        // $transactions = \App\CustomTransaction::all();
        $data = DB::table('transactions')
            ->join('orders', 'orders.transaction_id', '=', 'transactions.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('transactions.*', 'products.name as product_name', DB::raw('SUM(orders.quantity) as total_quantity'))
            ->where('transactions.deleted_at', null)
            ->groupBy('transactions.id', 'products.name')
            ->orderBy('transactions.created_at', 'asc')
            ->get();

        // dd($data);

        return view('pages.CustomTransaction.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'path' => 'required',
        ]);

        if (!$request->has('path')) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found, please refresh page and re-upload file'
            ], 404);
        }

        $path = $request->path;

        // the path is public/temporary/xxxxxx-xxxxxxx/xxxxxx.xlsx

        $data = Excel::import(new TransactionImport, $path);

        // dd($data);
        if ($data == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found, please refresh page and re-upload file'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been imported successfully',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $order = Order::where('transaction_id', $id)->first();
        $order->delete();
        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been deleted successfully',
            'data' => $transaction
        ], 200);
    }

    public function edit($id)
    {
        $transaction = Transaction::find($id);
        $order = Order::where('transaction_id', $id)->first();
        $quantity = $order->quantity;

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been updated successfully',
            'data' => $quantity,
            'id' => $id
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required',
        ]);
        $order = Order::where('transaction_id', $id)->first();
        $order->quantity = $request->quantity;
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been updated successfully',
            'data' => $order
        ], 200);
    }
}
