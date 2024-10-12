<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    public function index(Request $request)
    {
      if ($request->has('start_date') && $request->has('end_date')) {
        // format date
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        $cashFlow = CashFlow::whereBetween('created_at', [$start_date, $end_date])->orderBy('created_at', 'DESC')->get();
      }else{
        $cashFlow = CashFlow::orderBy('created_at', 'DESC')->get();
      }

        return view('pages._Main.Accounting.Cash.index', compact('cashFlow'));
    }
}
