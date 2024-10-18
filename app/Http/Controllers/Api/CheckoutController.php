<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CashFlow;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        //set middleware
        $this->middleware('auth:api');

        // Set midtrans configuration
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public function getOngkir(Request $request)
    {
        $getOngkir = Http::asForm()->withHeaders([
            'key' => config('services.rajaongkir.key')
        ])->post('https://pro.rajaongkir.com/api/cost', [
            'origin'      => 2218,
            'originType'  => 'subdistrict',
            'destination' => $request->destination,
            'destinationType' => 'subdistrict',
            'weight'      => $request->weight,
            'courier'     => 'pos:sicepat:jne:jnt:anteraja'
        ]);

        if ($getOngkir['rajaongkir']['status']['code'] == 200) {
            return response()->json([
                'success' => true,
                'message' => 'Ongkir',
                'data'    => $getOngkir['rajaongkir']['results']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ongkir',
                'data'    => $getOngkir['rajaongkir']['status']['description']
            ]);
        }
    }

    public function checkout(Request $request)
    {
        $checkout = DB::transaction(function () use ($request) {
            $invoice_number = generateInvoiceNumber('ECM');

            $transaction = Transaction::create([
                'invoice'           => $invoice_number,
                'customer_id'       => auth()->guard('api')->user()->id,
                'payment_method'    => 'online_payment',
                'shipping_method'   => $request->shipping_method,
                'courier'           => explode(' - ', $request->courier)[0],
                'courier_service'   => explode(' - ', $request->courier)[1],
                'courier_cost'      => $request->courier_cost,
                'weight'            => $request->weight,
                'total_price'       => $request->total_price,
                'total_discount'    => $request->total_discount,
                'total_shipping'    => $request->total_shipping,
                'service_fee'       => $request->service_fee,
                'grand_total'       => $request->grand_total,
                'notes'             => $request->notes,
                'status'            => 'Menunggu Pembayaran',
            ]);

            $carts = Cart::where('customer_id', auth()->guard('api')->user()->id)->get();
            foreach ($carts as $cart) {

                $transaction->order()->create([
                    'transaction_id'    => $transaction->id,
                    'product_id'        => $cart->product_id,
                    'quantity'          => $cart->quantity,
                    'price'             => $cart->price,
                ]);

                $product = $cart->product;
                $product->stock = $product->stock - $cart->quantity;
                $product->save();
            }

            $carts->each->delete();

            $address = $transaction->customer->addresses->where('is_default', true)->first();
            $payload = [
                'transaction_details' => [
                    'order_id'      => $transaction->invoice,
                    'gross_amount'  => $transaction->grand_total,
                ],
                'customer_details' => [
                    'first_name'       => auth()->guard('api')->user()->name,
                    'email'            => auth()->guard('api')->user()->email,
                    'phone'            => auth()->guard('api')->user()->phone,
                    'shipping_address' => [
                        'first_name'    => auth()->guard('api')->user()->name,
                        'email'         => auth()->guard('api')->user()->email,
                        'phone'         => auth()->guard('api')->user()->phone,
                        'address'       => $address->address,
                        'city'          => $address->subdistrict->city->name,
                        'postal_code'   => $address->postal_code,
                        'country_code'  => 'IDN'
                    ]
                ]
            ];

            $snapToken = Snap::getSnapToken($payload);

            $transaction->snap_token = $snapToken;
            $transaction->save();

            $token = $transaction->snap_token;

            CashFlow::create([
                'cash_flow_id'  => $transaction->id,
                'invoice'       => $transaction->invoice,
                'type'          => 'Pemasukan',
                'category'      => 'E-Commerce',
                'nominal'       => $transaction->grand_total,
                'description'   => 'Pembelian Produk E-Commerce',
            ]);

            return $token;
        });
        return response()->json([
            'success' => true,
            'message' => 'Checkout Success',
            'data'    => [
                'snap_token' => $checkout
            ]
        ]);
    }
}
