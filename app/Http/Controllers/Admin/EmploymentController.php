<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Employment\StoreEmploymentRequest;
use App\Models\Employment;
use Illuminate\Http\Request;

class EmploymentController extends Controller
{
    public function index()
    {
        $employments = Employment::orderBy('id', 'DESC')->get();

        return view('pages._Main.MasterData.Employment.index', compact('employments'));
    }

    public function store(StoreEmploymentRequest $request)
    {
        $employment = Employment::create([
            'name' => $request->name ?? null,
            'basic_salary' => $request->basic_salary ?? null,
            'other' => $request->other ?? null,
            'description' => $request->description ?? null,

        ]);

        if (!$employment) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Employment created successfully');
    }

    public function edit(Employment $employment)
    {
        return response()->json([
            'status' => true,
            'data' => $employment,
        ]);
    }

    public function update(Request $request, Employment $employment)
    {
        $request->validate([
            'name' => 'required',
            'basic_salary' => 'required',
            'other' => 'required',
            'description' => 'required',

        ]);

        $employment->update([
            'name' => $request->name ?? null,
            'basic_salary' => $request->basic_salary ?? null,
            'other' => $request->other ?? null,
            'description' => $request->description ?? null,
        ]);

        if (!$employment) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Employment updated successfully');
    }

    public function destroy(Employment $employment)
    {
        $employment->delete();

        if (!$employment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Employment deleted successfully',
            'title' => 'Success.',
        ]);
    }
}
