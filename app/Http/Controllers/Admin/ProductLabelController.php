<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Label\StoreLabelRequest;
use App\Models\ProductLabel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductLabelController extends Controller
{
    public function index()
    {
        $productLabels = ProductLabel::orderBy('id', 'DESC')->get();

        return view('pages._Main.Ecommerce.label.index', compact('productLabels'));
    }

    public function store(StoreLabelRequest $request)
    {
        $productCategory = ProductLabel::create([
            'name' => $request->name,
        ]);

        if (!$productCategory) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'ProductLabel created successfully');
    }

    public function edit(ProductLabel $label)
    {
        return response()->json([
            'status' => true,
            'data' => $label,
        ]);
    }

    public function update(Request $request, ProductLabel $label)
    {
        $request->validate([
            'name' => ['required', Rule::unique('product_labels', 'name')->ignore($label->id)->whereNull('deleted_at')],
        ]);

        $label->update([
            'name' => $request->name,
        ]);

        if (!$label) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'ProductLabel updated successfully');
    }

    public function destroy(ProductLabel $label)
    {
        $label->delete();

        if (!$label) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'ProductLabel deleted successfully',
            'title' => 'Success.',
        ]);
    }
}
