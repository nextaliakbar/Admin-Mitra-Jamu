<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Employee\StoreEmployeeRequest;
use App\Models\Employee;
use App\Models\Employment;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('id', 'DESC')->get();
        $employments = Employment::all();

        return view('pages._Main.MasterData.Employee.index', compact('employees', 'employments'));
    }

    public function create()
    {
        $employments = Employment::all();
        return view("pages._Main.MasterData.Employee.index", compact('employments'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create([
            'name' => $request->name ?? null,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
            'employment_id' => $request->employment_id ?? null,
            'status' => $request->status ?? null,
            'department' => $request->department ?? null,

        ]);

        if (!$employee) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Berhasil menambahkan pegawai baru');
    }

    public function edit(Employee $employee)
    {
        return response()->json([
            'status' => true,
            'data' => $employee,

        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'employment_id' => 'required',
            'status' => 'required',
            'department' => 'required',

        ]);

        $employee->update([
          'name' => $request->name ?? null,
          'email' => $request->email ?? null,
          'phone' => $request->phone ?? null,
          'address' => $request->address ?? null,
          'employment_id' => $request->employment_id ?? null,
          'status' => $request->status ?? null,
          'department' => $request->department ?? null,

        ]);

        if (!$employee) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Berhasil mengubah data pegawai');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data pegawai',
            'title' => 'Success.',
        ]);
    }
}
