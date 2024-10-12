<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Customer\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id', 'DESC')->get();

        return view('pages.UserManagement.customer.index', compact('customers'));
    }

    public function store(StoreCustomerRequest $request)
    {
        $user = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
        ]);

        if (!$user) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Berhasil menambahkan pelanggan baru');
    }

    public function edit(Customer $customer)
    {
        return response()->json([
            'status' => true,
            'data' => $customer,
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if (!$customer) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Berhasil mengubah data pelanggan');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data pelanggan',
            'title' => 'Success.',
        ]);
    }
}
