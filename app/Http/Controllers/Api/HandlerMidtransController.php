<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HandlerMidtransController extends Controller
{
    public function index(Request $request)
    {
        $payload      = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $transaction  = $notification->transaction_status;
        $type         = $notification->payment_type;
        $orderId      = $notification->order_id;

        //data tranaction
        $data_transaction = Transaction::where('invoice', $orderId)->first();

        if ($transaction == 'capture') {

            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
            }
        } elseif ($transaction == 'settlement') {

            /**
             *   update invoice to success
             */
            $data_transaction->update([
                'status' => 'Sedang Diproses',
                'payment_status' => 'Lunas',
                'payment_method' => 'Online Payment'
            ]);

            //update stock product 
            // foreach ($data_transaction->order()->get() as $order) {

            //     $product = Product::where('id', $order->product_id)->first();

            //     $product->update([
            //         'stock' => $product->stock - $order->quantity
            //     ]);
            // }
        } elseif ($transaction == 'pending') {


            /**
             *   update invoice to pending
             */
            $data_transaction->update([
                'status' => 'Menunggu Pembayaran'
            ]);
        } elseif ($transaction == 'deny') {


            /**
             *   update invoice to failed
             */
            $data_transaction->update([
                'status' => 'Gagal'
            ]);

            //update stock product
            foreach ($data_transaction->order()->get() as $order) {

                $product = Product::where('id', $order->product_id)->first();

                $product->update([
                    'stock' => $product->stock + $order->quantity
                ]);
            }
        } elseif ($transaction == 'expire') {


            /**
             *   update invoice to expired
             */
            $data_transaction->update([
                'status' => 'Gagal'
            ]);

            //update stock product
            foreach ($data_transaction->order()->get() as $order) {

                $product = Product::where('id', $order->product_id)->first();

                $product->update([
                    'stock' => $product->stock + $order->quantity
                ]);
            }
        } elseif ($transaction == 'cancel') {

            /**
             *   update invoice to failed
             */
            $data_transaction->update([
                'status' => 'Gagal'
            ]);

            //update stock product
            foreach ($data_transaction->order()->get() as $order) {

                $product = Product::where('id', $order->product_id)->first();

                $product->update([
                    'stock' => $product->stock + $order->quantity
                ]);
            }
        }
    }
}
