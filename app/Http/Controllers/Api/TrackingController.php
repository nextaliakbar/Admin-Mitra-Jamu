<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;

class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function tracking($id)
    {
        if ($id == null) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Resi belum diisi',
            ]);
        }

        $transaction = Transaction::findOrFail($id);
        $id = $transaction->receipt_number;
        $courier = dataCourier($transaction->courier);

        $dataTransaction = [
            'invoice' => $transaction->invoice,
            'date' => Carbon::parse($transaction->created_at)->format('d F Y'),
            'status' => $transaction->status,
        ];

        if ($transaction->receipt_number == null || $transaction->receipt_number == '') {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Resi belum diisi',
                'transaction' => $dataTransaction,
            ]);
        }

        $curl = curl_init();
        $key = config('services.rajaongkir.key');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "waybill=$id&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Resi tidak ditemukan',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Melacak Nomor Resi',
                'data' => json_decode($response, true),
                'transaction' => $dataTransaction,
            ]);
        }
    }
}
