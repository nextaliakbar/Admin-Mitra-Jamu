<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\Receivable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    public function index()
    {
        $receivables = Receivable::with('transaction')->orderBy('created_at', 'DESC')->get();
        foreach ($receivables as $receivable) {
            $receivable->due_date = Carbon::parse($receivable->due_date)->locale('id')->isoFormat('LL');
            $receivable->formatted_created_date = Carbon::createFromFormat('Y-m-d H:i:s', $receivable->created_at)->locale('id')->isoFormat('D MMMM Y, HH:mm');
        }
        return view('pages._Main.Accounting.Receivable.index', compact('receivables'));
    }

    public function edit($id)
    {
        $receivable = Receivable::findOrFail($id)::with('transaction')->where('id', $id)->first();
        return response()->json([
            'status' => true,
            'data' => $receivable,
        ]);
    }

    public function update(Request $request)
    {
        $receivable = Receivable::findOrFail($request->id);
        $request->validate([
            'paid_amount' => ['required', 'numeric'],
        ]);
        $receivable->update([
            'paid_amount' => $request->paid_amount,
        ]);

        // equal or more than total cost
        if ($receivable->paid_amount >= $receivable->transaction->grand_total) {
            $receivable->transaction->update([
                'payment_status' => 'Lunas',
            ]);
        }

        CashFlow::create([
            'cash_flow_id' => $receivable->id,
            'invoice' => $receivable->transaction->invoice,
            'type' => 'Pemasukan',
            'category' => 'Piutang',
            'nominal' => $request->paid_amount,
            'description' => 'Pembayaran Piutang',
        ]);

        if (!$receivable) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Receivable updated successfully');
    }
}
