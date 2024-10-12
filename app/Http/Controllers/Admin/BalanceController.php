<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function index()
    {
        $assetFixed = DB::table('assets')
            ->select(
                'assets.name',
                'assets.assets_price',
            )
            ->where('type', 'fixed')
            ->get();
        $assetCurrent = Asset::where('type', 'current')->get();

        $depresiation = DB::table('assets')
            // select sum of assets.monthly_depreciation
            ->select(
                DB::raw('sum(cast(assets.monthly_depreciation as float)) as depresiation')
            )
            ->where('type', 'fixed')
            ->get();

        $totalAssetFixed = DB::table('assets')
            // select sum assets_price - sum assets.monthly_depresiation
            ->select(
                DB::raw('sum(cast(assets.assets_price as float)) - sum(cast(assets.monthly_depreciation as float)) as total_asset_fixed')
            )
            ->where('type', 'fixed')
            ->first();

        $piutang_usaha = DB::table('transactions')
            ->selectRaw('sum(transactions.grand_total) as piutang_usaha')
            ->where('payment_method', 'debt')
            ->first();

        // sum all product * price - discount * quantity
        $persediaan_barang = DB::table('products')
            ->selectRaw('sum((products.price - (products.price * products.discount / 100)) * products.stock) as persediaan_barang')
            ->first();

        $totalAssetCurrent = DB::table('assets')
            ->select(
                DB::raw('sum(cast(assets.assets_price as float)) as total_asset_current')
            )
            ->where('type', 'current')
            ->first();

        // sum all purchase
        $hutang_usaha = DB::table('purchases')
            ->selectRaw('sum(purchases.total_cost) as hutang_usaha')
            ->where('payment_status', 'belum')
            ->first();

        // sum all payment_salary
        $gaji = DB::table('salary_payments')
            ->selectRaw('sum(salary_payments.net_salary) as gaji')
            ->first();

        // total kewajiban = hutang usaha + gaji
        $totalKewajiban = $hutang_usaha->hutang_usaha + $gaji->gaji;

        $data = [
            'assetFixed' => [],
            'assetCurrent' => 0,
            'depresiation' => 0,
            'totalAssetFixed' => 0,
            'piutang_usaha' => 0,
            'persediaan_barang' => 0,
            'totalAssetCurrent' => 0,
            'totalAsset' => 0, // totalAssetFixed + totalAssetCurrent
            'hutang_usaha' => 0,
            'gaji' => 0,
            'totalKewajiban' => 0,
        ];


        foreach ($assetFixed as $key => $value) {
            $data['assetFixed'][] = [
                'nama' => $value->name,
                'price' => $value->assets_price,
            ];
        }

        foreach ($assetCurrent as $key => $value) {
            $data['assetCurrent'] += $value->assets_price;
        }

        foreach ($depresiation as $key => $value) {
            $data['depresiation'] += $value->depresiation;
        }

        $data['totalAssetFixed'] = $totalAssetFixed->total_asset_fixed;

        $data['piutang_usaha'] = $piutang_usaha->piutang_usaha;

        $data['persediaan_barang'] = $persediaan_barang->persediaan_barang;

        $data['totalAssetCurrent'] = $totalAssetCurrent->total_asset_current;

        $data['totalAsset'] = $data['totalAssetFixed'] + $data['totalAssetCurrent'];

        $data['hutang_usaha'] = $hutang_usaha->hutang_usaha;

        $data['gaji'] = $gaji->gaji;

        $data['totalKewajiban'] = $totalKewajiban;

        // dd($data);

        return view('pages._Main.Accounting.Balance.index', compact('data'));
    }
}
