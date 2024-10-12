<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForecastController extends Controller
{
    public function index()
    {
        // $productInit = DB::table('transactions')
        //     ->join('orders', 'orders.transaction_id', '=', 'transactions.id')
        //     ->join('products', 'orders.product_id', '=', 'products.id')
        //     ->select('products.id', 'products.name')
        //     ->groupBy('products.id', 'products.name')
        //     ->get();

        $product_id = "e9e29f39-5899-4532-8cb9-4c6ee70af5e3";
        $period = '5';
        $alpha = '0.761';
        $beta = '0';
        $gamma = '1';

        // count total quantity of orders by product
        $countOrder = DB::table('transactions')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(orders.quantity) as total'))
            ->where('products.id', $product_id)
            ->first();
        $countOrder = $countOrder->total;

        $countCity = DB::table('transactions')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('addresses', 'addresses.customer_id', '=', 'customers.id')
            ->join('subdistricts', 'addresses.subdistrict_id', '=', 'subdistricts.subdistrict_id')
            ->join('cities', 'subdistricts.city_id', '=', 'cities.city_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            // count total quantity of orders
            ->select('cities.name', DB::raw('SUM(orders.quantity) as total'))
            ->where('products.id', $product_id)
            ->groupBy('cities.name')
            // ->limit(3)
            ->get();

        $total = $countCity->sum('total');
        foreach ($countCity as $city) {
            $city->percentage = round($city->total / $total * 100, 2);
        }

        $countCity = $countCity->sortByDesc('percentage')->take(3);


        $productsByCategory = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->select('product_categories.name as category', 'products.name as product', 'products.id as id')
            ->orderBy('product_categories.name')
            ->get()
            ->groupBy('category');

        // productsByCategory where has order in last 5 years
        $productsByCategory = $productsByCategory->map(function ($item, $key) {
            return $item->filter(function ($product) {
                return DB::table('transactions')
                    ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
                    ->join('products', 'orders.product_id', '=', 'products.id')
                    ->select('transactions.created_at', 'orders.quantity', 'products.name as product_name')
                    ->where('products.id', $product->id)
                    ->orderBy('transactions.created_at')
                    ->get()
                    ->count() > 0;
            });
        });

        $productsByCategory = $productsByCategory->filter(function ($item) {
            return $item->count() > 0;
        });

        // if product has orders in every 5 years ago

        // FORECASTING


        $data = DB::table('transactions')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('transactions.created_at', 'orders.quantity', 'products.name as product_name')
            ->where('products.id', $product_id)
            ->orderBy('transactions.created_at')
            ->get();

        if (!$data->count()) {
            return view('pages._Main.Forecast.index2', compact(
                'countOrder',
                'countCity',
                'productsByCategory'
            ), [
                'error' => 'Data tidak ditemukan, silahkan upload data penjualan di menu "Manajemen Penjualan"'
            ]);
        }

        $productName = $data->first()->product_name;

        $dataMonth = $data->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->created_at)->locale('id')->isoFormat('MMMM YYYY');
        });

        $data = $dataMonth->map(function ($item) {
            return $item->sum('quantity');
        });

        $data = $data->toArray();

        $data = array_values($data);

        // dd($dataMonth, $data);

        $forecast = $this->forecast($data, $period, $alpha, $beta, $gamma);

        $dataForecast = $forecast['dataForecastAkhir'];

        $dataMonth = $dataMonth->keys()->toArray();
        for ($i = 1; $i <= $period; $i++) {
            $dataMonth[] = \Carbon\Carbon::now()->locale('id')->addMonths($i)->isoFormat('MMMM YYYY');
        }

        $dataActual = json_encode($data);
        $dataForecast = json_encode($dataForecast);
        $dataMonth = json_encode($dataMonth);
        $mape = $forecast['mape'];
        $mse = $forecast['mse'];

        $dataTable = array();
        for ($i = 0; $i < count(array_slice($forecast['dataForecastAkhir'], 12)); $i++) {
            $data = [
                'year' => explode(' ', json_decode($dataMonth)[$i])[1],
                'month' => explode(' ', json_decode($dataMonth)[$i])[0],
                'actual' => $forecast['dataAfter12FirstMonths'][$i] ?? 0,
                'forecast' => $forecast['dataForecastAfter12FirstMonths'][$i] ?? 0,
                'error' => $forecast['error'][$i] ?? 0,
            ];

            array_push($dataTable, $data);
        }

        return view('pages._Main.Forecast.index', compact(
            'countOrder',
            'countCity',
            'productsByCategory',
            'dataForecast',
            'dataActual',
            'dataMonth',
            'productName',
            'mape',
            'mse',
            'dataTable',
            'product_id',
        ));
    }

    public function chart(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'period' => 'required',
            'alpha' => 'required',
            'beta' => 'required',
            'gamma' => 'required',
        ]);

        $product_id = $request->product_id;
        $period = $request->period;
        $alpha = $request->alpha;
        $beta = $request->beta;
        $gamma = $request->gamma;

        $data = DB::table('transactions')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('transactions.created_at', 'orders.quantity', 'products.name as product_name')
            ->where('products.id', $product_id)
            ->orderBy('transactions.created_at')
            ->get();

        $productName = $data->first()->product_name;

        $dataMonth = $data->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->created_at)->locale('id')->isoFormat('MMMM YYYY');
        });

        $data = $dataMonth->map(function ($item) {
            return $item->sum('quantity');
        });

        $data = $data->toArray();

        $data = array_values($data);

        $forecast = $this->forecast($data, $period, $alpha, $beta, $gamma);

        $dataForecast = $forecast['dataForecastAkhir'];

        $dataMonth = $dataMonth->keys()->toArray();
        for ($i = 1; $i <= $period; $i++) {
            $dataMonth[] = \Carbon\Carbon::now()->locale('id')->addMonths($i)->isoFormat('MMMM YYYY');
        }

        $dataActual = json_encode($data);
        $dataForecast = json_encode($dataForecast);
        $dataMonth = json_encode($dataMonth);
        $mape = $forecast['mape'];
        $mse = $forecast['mse'];

        $dataTable = array();
        for ($i = 0; $i < count(array_slice($forecast['dataForecastAkhir'], 12)); $i++) {
            $data = [
                'year' => explode(' ', json_decode($dataMonth)[$i])[0],
                'month' => explode(' ', json_decode($dataMonth)[$i])[1],
                'actual' => $forecast['dataAfter12FirstMonths'][$i] ?? 0,
                'forecast' => $forecast['dataForecastAfter12FirstMonths'][$i] ?? 0,
                'error' => $forecast['error'][$i] ?? 0,
            ];

            array_push($dataTable, $data);
        }

        return view('pages._Main.Forecast.forecast_chart', compact(
            'dataForecast',
            'dataActual',
            'dataMonth',
            'productName',
            'mape',
            'mse',
            'dataTable'
        ));
    }

    public function table(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'period' => 'required',
            'alpha' => 'required',
            'beta' => 'required',
            'gamma' => 'required',
        ]);

        $product_id = $request->product_id;
        $period = $request->period;
        $alpha = $request->alpha;
        $beta = $request->beta;
        $gamma = $request->gamma;

        $data = DB::table('transactions')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('transactions.created_at', 'orders.quantity', 'products.name as product_name')
            ->where('products.id', $product_id)
            ->orderBy('transactions.created_at')
            ->get();

        $productName = $data->first()->product_name;

        $dataMonth = $data->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->created_at)->locale('id')->isoFormat('MMMM YYYY');
        });

        $data = $dataMonth->map(function ($item) {
            return $item->sum('quantity');
        });

        $data = $data->toArray();

        $data = array_values($data);

        $forecast = $this->forecast($data, $period, $alpha, $beta, $gamma);

        $dataForecast = $forecast['dataForecastAkhir'];

        $dataMonth = $dataMonth->keys()->toArray();
        for ($i = 1; $i <= $period; $i++) {
            $dataMonth[] = \Carbon\Carbon::now()->locale('id')->addMonths($i)->isoFormat('MMMM YYYY');
        }

        $dataActual = json_encode($data);
        $dataForecast = json_encode($dataForecast);
        $dataMonth = json_encode($dataMonth);
        $mape = $forecast['mape'];
        $mse = $forecast['mse'];

        $dataTable = array();
        for ($i = 0; $i < count(array_slice($forecast['dataForecastAkhir'], 12)); $i++) {
            $data = [
                'year' => explode(' ', json_decode($dataMonth)[$i])[1],
                'month' => explode(' ', json_decode($dataMonth)[$i])[0],
                'actual' => $forecast['dataAfter12FirstMonths'][$i] ?? 0,
                'forecast' => $forecast['dataForecastAfter12FirstMonths'][$i] ?? 0,
                'error' => $forecast['error'][$i] ?? 0,
            ];

            array_push($dataTable, $data);
        }

        return view('pages._Main.Forecast.forecast_table', compact(
            'dataForecast',
            'dataActual',
            'dataMonth',
            'productName',
            'mape',
            'mse',
            'dataTable'
        ));
    }

    public function count(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
        ]);

        $product_id = $request->product_id;

        $countOrder = DB::table('transactions')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(orders.quantity) as total'), 'products.name as product_name')
            ->where('products.id', $product_id)
            ->groupBy('products.name')
            ->first();
        $count = $countOrder->total;
        $productName = $countOrder->product_name;


        $countCity = DB::table('transactions')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('addresses', 'addresses.customer_id', '=', 'customers.id')
            ->join('subdistricts', 'addresses.subdistrict_id', '=', 'subdistricts.subdistrict_id')
            ->join('cities', 'subdistricts.city_id', '=', 'cities.city_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('cities.name', DB::raw('SUM(orders.quantity) as total'))
            ->where('products.id', $product_id)
            ->groupBy('cities.name')
            ->get();

        $total = $countCity->sum('total');
        foreach ($countCity as $city) {
            $city->percentage = round($city->total / $total * 100, 2);
        }

        $countCity = $countCity->sortByDesc('total')->take(3);


        return response()->json([
            'countOrder' => $count,
            'productName' => $productName,
            'countCity' => $countCity,
        ]);
    }

    public function forecast($data, $period, $alpha, $beta, $gamma)
    {
        // data = array of data
        $data = array_values($data);

        // data 12 bulan pertama
        $dataFirst12Months = array_slice($data, 0, 12);

        // initial level = average of data 12 bulan pertama
        $initialLevel = array_sum($dataFirst12Months) / count($dataFirst12Months);

        // initial trend = average of the difference between data 12 bulan pertama
        $initialTrend = (array_sum(array_slice($data, 12, 12)) - array_sum($dataFirst12Months)) / (12 * 12);

        // initial seasonal indices = data 12 bulan pertama / initial level
        $initialSeasonalIndices = [];
        for ($i = 0; $i < count($dataFirst12Months); $i++) {
            $initialSeasonalIndices[$i] = $data[$i] / $initialLevel;
        }

        // data 12 bulan setelah 12 bulan pertama
        $dataAfter12FirstMonths = array_slice($data, 12);

        // initial value
        $level = $initialLevel;
        $trend = $initialTrend;
        $seasonalIndices = $initialSeasonalIndices;

        // alpha, beta, gamma convert to float
        $alpha = (float) $alpha;
        $beta = (float) $beta;
        $gamma = (float) $gamma;

        // perhitungan
        $dataLevel = [];
        $dataTrend = [];
        $dataSeasonalIndices = [];
        $dataForecast = [];
        for ($i = 0; $i < count($dataAfter12FirstMonths); $i++) {
            // pengecekan data apakah ada atau tidak (jika tidak ada maka diisi dengan 0)
            if ($i < count($dataAfter12FirstMonths)) {
                $currentData = $dataAfter12FirstMonths[$i];
            } else {
                $currentData = 0;
            }

            // temporary value
            $previousLevel = $level;
            $previousTrend = $trend;
            $previousSeasonalIndices = $seasonalIndices[$i % 12];

            // perhitungan level, trend, seasonal index, dan forecast sesuai rumus
            $level = $alpha * ($currentData / $previousSeasonalIndices) + (1 - $alpha) * ($previousLevel + $previousTrend);
            $trend = $beta * ($level - $previousLevel) + (1 - $beta) * $previousTrend;
            $seasonalIndices[$i % 12] = $gamma * ($currentData / $level) + (1 - $gamma) * $previousSeasonalIndices;
            $forecast[$i] = ($previousLevel + 1 * $previousTrend) * $previousSeasonalIndices;

            // simpan data level, trend, seasonal index, dan forecast ke array
            $dataLevel[] = $level;
            $dataTrend[] = $trend;
            $dataSeasonalIndices[] = $seasonalIndices[$i % 12];
            $dataForecast[] = $forecast[$i];
        }

        // initial value untuk perhitungan forecast berikutnya
        // dd($dataLevel, $dataTrend, $dataSeasonalIndices, $dataForecast);
        $lastLevel = $dataLevel[count($dataLevel) - 1];
        $lastTrend = $dataTrend[count($dataTrend) - 1];
        $dataLastSeasonalIndices = array_slice($dataSeasonalIndices, count($dataSeasonalIndices) - 12);

        // perhitungan forecast berikutnya
        $forecast = [];
        for ($i = 0; $i < $period; $i++) {
            $forecast[$i] = ($lastLevel + ($i + 1) * $lastTrend) * $dataLastSeasonalIndices[$i % 12];
        }

        // perhitungan error
        $error = [];
        for ($i = 0; $i < count($dataAfter12FirstMonths); $i++) {
            $error[$i] = $dataAfter12FirstMonths[$i] - $dataForecast[$i];
        }

        // perhitungan squared error
        $sequaredError = [];
        for ($i = 0; $i < count($error); $i++) {
            $sequaredError[$i] = $error[$i] * $error[$i];
        }

        // perhitungan absolute precentage error
        $absolutePrecentageError = [];
        for ($i = 0; $i < count($error); $i++) {
            $absolutePrecentageError[$i] = abs($error[$i] / $dataAfter12FirstMonths[$i]) * 100;
        }

        // perhitungan mse dan mape
        $mse = array_sum($sequaredError) / count($sequaredError);
        $mape = array_sum($absolutePrecentageError) / count($absolutePrecentageError);

        // $dataForecastAkhir = 12 bulan pertama set to null + dataforecast + forecast
        $dataForecastAkhir = array_merge(array_fill(0, 12, null), $dataForecast, $forecast);
        // round data forecast akhir
        $dataForecastAkhir = array_map(function ($value) {
            return round($value);
        }, $dataForecastAkhir);

        $dataForecastAfter12FirstMonths = array_slice($dataForecastAkhir, 12);

        // data yang akan dikembalikan
        $data = [
            'dataAfter12FirstMonths' => $dataAfter12FirstMonths,
            'dataLevel' => $dataLevel,
            'dataTrend' => $dataTrend,
            'dataSeasonalIndices' => $dataSeasonalIndices,
            'dataForecast' => $dataForecast,
            'dataLastSeasonalIndices' => $dataLastSeasonalIndices,
            'forecast' => $forecast,
            'error' => $error,
            'sequaredError' => $sequaredError,
            'absolutePrecentageError' => $absolutePrecentageError,
            'mse' => $mse,
            'mape' => $mape,
            'dataForecastAkhir' => $dataForecastAkhir,
            'dataForecastAfter12FirstMonths' => $dataForecastAfter12FirstMonths,
        ];

        return $data;
    }
}
