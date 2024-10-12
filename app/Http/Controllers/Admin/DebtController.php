<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\Debt;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index()
    {
        $debts = Debt::with('purchase', 'supplier')->orderBy('created_at', 'DESC')->get();
        foreach ($debts as $debt) {
            $debt->purchase->date = Carbon::parse($debt->purchase->date)->locale('id')->isoFormat('LL');
            $debt->formatted_created_date = Carbon::createFromFormat('Y-m-d H:i:s', $debt->created_at)->locale('id')->isoFormat('D MMMM Y, HH:mm');
        }
        return view('pages._Main.Accounting.Debt.index', compact('debts'));
    }

    public function edit($id)
    {
        $debt = Debt::findOrFail($id)::with('purchase')->where('id', $id)->first();
        return response()->json([
            'status' => true,
            'data' => $debt,
        ]);
    }

    public function update(Request $request)
    {
        $debt = Debt::findOrFail($request->id);
        $request->validate([
            'paid_amount' => ['required', 'numeric'],
        ]);
        $debt->update([
            'paid_amount' => $request->paid_amount,
        ]);

        // equal or more than total cost
        if ($debt->paid_amount >= $debt->purchase->total_cost) {
            $debt->purchase->update([
                'payment_status' => 'lunas',
            ]);
        }

        CashFlow::create([
            'cash_flow_id' => $debt->id,
            'invoice' => $debt->purchase->invoice,
            'type' => 'Pengeluaran',
            'category' => 'Hutang',
            'nominal' => $request->paid_amount,
            'description' => 'Pembayaran Hutang Pembelian Barang (Stok)',
        ]);

        if (!$debt) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Debt updated successfully');
    }
}
