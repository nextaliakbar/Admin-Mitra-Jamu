<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Voucher\StoreVoucherRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('id', 'DESC')->get();

        return view('pages._Main.Ecommerce.voucher.index', compact('vouchers'));
    }

    public function store(StoreVoucherRequest $request)
    {
        $productCategory = Voucher::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,

        ]);

        if (!$productCategory) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Voucher created successfully');
    }

    public function edit(Voucher $voucher)
    {
        return response()->json([
            'status' => true,
            'data' => $voucher,
        ]);
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'name' => ['required', Rule::unique('vouchers', 'name')->ignore($voucher->id)->whereNull('deleted_at')],
        ]);

        $voucher->update([
            'name' => $request->name,
        ]);

        if (!$voucher) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Voucher updated successfully');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        if (!$voucher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Voucher deleted successfully',
            'title' => 'Success.',
        ]);
    }
}
