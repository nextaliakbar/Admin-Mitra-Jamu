<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\Debt;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::orderBy('created_at', 'DESC')->get();

        return view('pages._Main.Purchase.index', compact('purchases'));
    }

    public function create()
    {
        return view('pages._Main.Purchase.add');
    }

    public function store(Request $request)
    {
        if ($request->has('purchases') && $request->purchases != null && $request->has('purchases_details') && $request->purchases_details != null) {
            $invoice = generateInvoiceNumber('STC');
            $purchases = json_decode(json_encode($request->purchases));
            $purchases_details = json_decode(json_encode($request->purchases_details));

            $purchase = Purchase::create([
                'user_id' => auth()->user()->id,
                'invoice' => $invoice,
                'date' => $purchases->payment_date,
                'payment_status' => $purchases->payment_status,
                'payment_method' => $purchases->payment_method,
                'note' => $purchases->payment_note,
                'total_cost' => $purchases->total_cost,
            ]);

            foreach ($purchases_details as $purchase_detail) {
                $purchase->purchaseLists()->create([
                    'product_id' => $purchase_detail->product,
                    'supplier_id' => $purchase_detail->supplier,
                    'quantity' => $purchase_detail->quantity,
                    'date' => $purchase_detail->date,
                    'unit_cost' => $purchase_detail->unit_cost,
                    'total_cost' => $purchase_detail->total_unit_cost,
                ]);

                $product = Product::find($purchase_detail->product);
                $product->stock = $product->stock + $purchase_detail->quantity;
                $product->save();
            }

            // if payment status is 'belum' then create debt
            if ($purchases->payment_status == 'belum') {
                Debt::create([
                    'user_id' => auth()->user()->id,
                    'purchase_id' => $purchase->id,
                    'supplier_id' => $purchase_detail->supplier,
                    'paid_amount' => 0,
                ]);

                CashFlow::create([
                    'cash_flow_id' => $purchase->id,
                    'invoice' => $purchase->invoice,
                    'type' => 'Pengeluaran',
                    'category' => 'Pembelian Barang',
                    'nominal' => 0,
                    'description' => 'Pembelian Barang (Stok)',
                ]);
            } else {
                CashFlow::create([
                    'cash_flow_id' => $purchase->id,
                    'invoice' => $purchase->invoice,
                    'type' => 'Pengeluaran',
                    'category' => 'Pembelian Barang',
                    'nominal' => $purchase->total_cost,
                    'description' => 'Pembelian Barang (Stok)',
                ]);
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Purchase berhasil dilakukan',
                ],
                200,
            );
        }

        return response()->json(
            [
                'success' => false,
                'message' => 'Purchase gagal dilakukan, harap lengkapi data',
            ],
            400,
        );
    }

    public function show()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }

    public function edit()
    {
    }
}
