<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return view('pages._Main.Supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('suppliers', 'name')->whereNull('deleted_at')],
        ]);


        $productCategory = Supplier::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
            'avatar' => $request->avatar ?? asset('images/noimage.png'),
            'status' => $request->status ?? null,
            'type' => $request->type ?? null,
        ]);

        if (!$productCategory) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Supplier created successfully');
    }

    public function edit(Supplier $supplier)
    {
        return response()->json([
            'status' => true,
            'data' => $supplier,
        ]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => ['required', Rule::unique('suppliers', 'name')->ignore($supplier->id)->whereNull('deleted_at')],
        ]);

        $supplier->update([
            'name' => $request->name,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
            'avatar' => $request->avatar ?? null,
            'status' => $request->status ?? null,
            'type' => $request->type ?? null,
        ]);

        if (!$supplier) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Supplier updated successfully');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        if (!$supplier) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Supplier deleted successfully',
            'title' => 'Success.',
        ]);
    }

    public function getSuppliers()
    {
        $suppliers = Supplier::all();

        return response()->json([
            'status' => 'success',
            'data' => $suppliers
        ], 200);
    }
}
