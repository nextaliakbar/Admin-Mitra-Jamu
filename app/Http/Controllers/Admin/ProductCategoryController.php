<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Category\StoreCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $productCategories = ProductCategory::orderBy('id', 'DESC')->get();

        return view('pages._Main.Ecommerce.category.index', compact('productCategories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $productCategory = ProductCategory::create([
            'name' => $request->name,
        ]);

        if (!$productCategory) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Berhasil menambahkan kategori baru');
    }

    public function edit(ProductCategory $category)
    {
        return response()->json([
            'status' => true,
            'data' => $category,
        ]);
    }

    public function update(Request $request, ProductCategory $category)
    {
        $request->validate([
            'name' => ['required', Rule::unique('product_categories', 'name')->ignore($category->id)->whereNull('deleted_at')],
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        if (!$category) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Berhasil mengubah kategori');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus kategori',
            'title' => 'Success.',
        ]);
    }
}
