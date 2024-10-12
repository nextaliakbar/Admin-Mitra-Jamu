<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\SalaryPayment;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SalaryPaymentController extends Controller
{
    //
    public function index()
    {
        // $years = SalaryPayment::select(DB::raw('YEAR(salary_date) as year'))->distinct()->get();
        $salary_payment = SalaryPayment::with('employee')->get();
        return view("pages._Main.Accounting.SalaryPayment.index", compact('salary_payment'));
    }

    public function create()
    {
        $invoice = generateInvoiceNumber('SYP');
        $employees = Employee::with('employment')->get();
        return view("pages._Main.Accounting.SalaryPayment.add", compact('employees', 'invoice'));
    }

    public function store(Request $request)
    {
        $chek = SalaryPayment::where('employee_id', $request->id_employee)
            ->whereMonth('salary_date', date('m'))
            ->whereYear('salary_date', date('Y'))->first();

        if ($chek == null) {
            $employee = Employee::with('employment')->where('id', $request->id_employee)->first();
            $salary = new SalaryPayment();
            $salary->invoice = $request->invoice;
            $salary->employee_id = $request->id_employee;
            $salary->salary_date = date('Y-m-d');
            $salary->basic_salary = $employee->employment->basic_salary;
            $salary->salary_reduction = $request->salary_reduction;
            $salary->net_salary = $employee->employment->basic_salary - $request->salary_reduction;
            CashFlow::create([
                'cash_flow_id' => $salary->id,
                'invoice' => $salary->invoice,
                'type' => 'Pengeluaran',
                'category' => 'Pembayaran Gaji',
                'nominal' => $salary->net_salary,
                'description' => 'Pembayaran Gaji',
            ]);
            if ($salary->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Salary Payment successfully paid',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Salary Payment failed to paid',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Salary Payment has been paid',
            ]);
        }
    }


    // Fungsi filter

    // public function loadTable()
    // {
    //     $salary_payment = SalaryPayment::with('employee');
    //     if (request()->get('next') == "all") {
    //         $salary_payment = $salary_payment->whereMonth('salary_date', request()->get('month'));
    //         $salary_payment = $salary_payment->whereYear('salary_date', request()->get('year'));
    //     } else {
    //         if (request()->get('next') == "year") {
    //             $salary_payment->whereYear('salary_date', date('Y'));
    //         } elseif (request()->get('next') == "month") {
    //             $salary_payment->whereMonth('salary_date', date('m'));
    //             $salary_payment->whereYear('salary_date', date('Y'));
    //         } else {
    //             $salary_payment = $salary_payment;
    //         }
    //     }
    //     $salary_payment = $salary_payment->get();
    //     return view("pages.transaksi.salary_payment.table", compact('salary_payment'));
    // }

    public function get_detail($id)
    {
        $chek = SalaryPayment::where('employee_id', $id)->orderBy('id', 'DESC')->first();
        if ($chek) {
            return response()->json(Carbon::parse($chek->salary_date)->locale('id')->isoformat('MMMM'));
        } else {
            return response()->json('No History Payment Salary');
        }
    }

    public function slip($kode)
    {
        $salary_payment = SalaryPayment::where('invoice', $kode)->firstOrFail();
        return view("pages._Main.Accounting.SalaryPayment.slip", compact('salary_payment'));
    }
}
