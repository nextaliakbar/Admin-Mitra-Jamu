<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = DB::table('product_categories')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'List Category',
            'data' => $categories
        ], 200);
    }
}
