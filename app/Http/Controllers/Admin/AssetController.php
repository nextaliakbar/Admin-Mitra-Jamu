<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Asset\StoreAssetRequest;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::orderBy('id', 'DESC')->get();

        return view('pages._Main.MasterData.Asset.index', compact('assets'));
    }

    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create([
            'name' => $request->name ?? null,
            'date' => $request->date ?? null,
            'unit' => $request->unit ?? null,
            'type' => $request->type ?? null,
            'useful_life' => $request->useful_life ?? null,
            'assets_price' => $request->assets_price ?? null,
            'monthly_depreciation' => $request->monthly_depreciation ?? null,

        ]);

        if (!$asset) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Asset created successfully');
    }

    public function edit(Asset $asset)
    {
        return response()->json([
            'status' => true,
            'data' => $asset,
        ]);
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'unit' => 'required',
            'type' => 'required',
            'useful_life' => 'required',
            'assets_price' => 'required',
            'monthly_depreciation' => 'required',
        ]);

        $asset->update([
            'name' => $request->name ?? null,
            'date' => $request->date ?? null,
            'unit' => $request->unit ?? null,
            'type' => $request->type ?? null,
            'useful_life' => $request->useful_life ?? null,
            'assets_price' => $request->assets_price ?? null,
            'monthly_depreciation' => $request->monthly_depreciation ?? null,
        ]);

        if (!$asset) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Asset updated successfully');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        if (!$asset) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Asset deleted successfully',
            'title' => 'Success.',
        ]);
    }
}
