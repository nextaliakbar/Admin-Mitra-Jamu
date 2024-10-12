<?php

namespace App\Imports;

use App\Models\CashFlow;
use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TransactionImport implements ToModel
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    // skip the first row
    if ($row[0] == 'Email Pelanggan') {
      return null;
    }

    if ($row[0] == '') {
      return null;
    }

    $customers = \App\Models\Customer::where('email', $row[0])->first();
    $product = \App\Models\Product::where('id', $row[1])->first();

    $transactions = \App\Models\Transaction::create([
      'customer_id' => $customers->id,
      'invoice' => generateInvoiceNumber('CUST'),
      'status' => 'custom order',
      'grand_total' => ($product->price - ($product->price * $product->discount / 100)) * $row[2] ?? 0,
      'created_at' => Carbon::createFromFormat('m/d/Y', $row[3]),
      'updated_at' => Carbon::createFromFormat('m/d/Y', $row[3]),
    ]);


    $orders = Order::create([
      'transaction_id' => $transactions->id,
      'product_id' => $row[1],
      'quantity' => $row[2],
      'price' => ($product->price - ($product->price * $product->discount / 100)) * $row[2] ?? 0,
      'created_at' => Carbon::createFromFormat('m/d/Y', $row[3]),
      'updated_at' => Carbon::createFromFormat('m/d/Y', $row[3]),
    ]);

    // add to cashflow
    $cashflow = CashFlow::create([
      'cash_flow_id' => $transactions->id,
      'invoice' => $transactions->invoice,
      'type' => 'Pemasukan',
      'category' => 'Custom Order',
      'nominal' => ($product->price - ($product->price * $product->discount / 100)) * $row[2] ?? 0,
      'description' => 'Pembelian produk ' . $product->name . ' - custom ',
      'created_at' => Carbon::createFromFormat('m/d/Y', $row[3]),
      'updated_at' => Carbon::createFromFormat('m/d/Y', $row[3]),
    ]);

    // return $orders;
    return $orders;
  }
}
