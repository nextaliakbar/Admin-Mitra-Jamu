<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashierRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $data = json_decode(file_get_contents(public_path('options/pos.json')), true);
            // if data{pos: treu} or data{pos: false}
            if ($data['pos'] == true) {
                return redirect()->route('admin.cashier.index');
            } else {
                return $next($request);
            }
        });
    }

    public function index()
    {
        return view('pages._Main.Cashier.register_pos');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nominal100' => 'required',
            'nominal50' => 'required',
            'nominal20' => 'required',
            'nominal10' => 'required',
            'nominal5' => 'required',
            'nominal2' => 'required',
            'nominal1' => 'required',
            'nominal05' => 'required',
            'nominal02' => 'required',
            'nominal01' => 'required',
        ]);

        $data = json_decode(file_get_contents(public_path('options/pos.json')), true);

        $data['pos'] = true;
        $data['date'] = date('Y-m-d H:i:s');
        $data['data'] = [
            'nominal100' => $request->nominal100,
            'nominal50' => $request->nominal50,
            'nominal20' => $request->nominal20,
            'nominal10' => $request->nominal10,
            'nominal5' => $request->nominal5,
            'nominal2' => $request->nominal2,
            'nominal1' => $request->nominal1,
            'nominal05' => $request->nominal05,
            'nominal02' => $request->nominal02,
            'nominal01' => $request->nominal01,
        ];

        $json = json_encode($data);

        $file = public_path('options/pos.json');
        file_put_contents($file, $json);

        return redirect()->route('admin.cashier.index')->with('success', 'POS setup successfully');
    }
}
