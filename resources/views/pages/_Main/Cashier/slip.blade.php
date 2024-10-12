<html>

<head>
  <title>Faktur Pembayaran</title>
  <style>
    #tabel {
      font-size: 15px;
      border-collapse: collapse;
    }

    #tabel td {
      padding-left: 5px;
      border: 1px solid black;
    }
  </style>
</head>

<body style='font-family:tahoma; font-size:8pt;'>
  {{-- @foreach ($data['product'] as $test)
    {{ dd($test['product_name']) }}
    @foreach ($test as $t)
    @endforeach
  @endforeach --}}
  <center>
    <table style='width:350px; font-size:16pt; font-family:calibri; border-collapse: collapse;' border='0'>
      <td width='70%' align='CENTER' vertical-align:top'><span style='color:black;'>
          <b>PT Mitra Jamur Indonesia</b></span></br>
        <span style='font-size:12pt'>Jl. Merak no 64 Kelurahan Gebang
          Kecamatan Patrang Kabupaten Jember
        </span></br></br>
        <span style='font-size:12pt'>
          Invoice: {{ $data['transaction_invoice'] }} <br />
          Kasir: {{ $data['cashier_name'] }} <br />
          Tanggal: {{ $data['transaction_date'] }}</span></br></br>
      </td>
    </table>
    <style>
      hr {
        display: block;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
        margin-left: auto;
        margin-right: auto;
        border-style: inset;
        border-width: 1px;
      }
    </style>
    <table style='width:350px; font-size:12pt; font-family:calibri;  border-collapse: collapse;' cellspacing='0'
      cellpadding='0' border='0'>
      <tr align='center'>
        <th width='40%'>Item</th>
        <th width='20%'>Price</th>
        <th width='10%'>Qty</th>
        <th width='30%'>Total</th>
      <tr>
        <td colspan='4'>
          <hr>
        </td>
      </tr>
      </tr>
      @foreach ($data['product'] as $product)
        <tr>
          <td style='vertical-align:top'>{{ $product['product_name'] }}</td>
          <td style='vertical-align:top; text-align:right; padding-right:10px'>{{ $product['product_price'] }}</td>
          <td style='vertical-align:top; text-align:right; padding-right:10px'>{{ $product['product_quantity'] }}</td>
          <td style='text-align:right; vertical-align:top'>{{ $product['total_product_price'] }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan='4'>
          <hr>
        </td>
      </tr>
      <tr>
        <td colspan='3'>
          <div style='text-align:right; color:black'>Total : </div>
        </td>
        <td style='text-align:right; font-size:14pt; color:black'>{{ $data['grand_total'] }}</td>
      </tr>
      <tr>
        <td colspan='3'>
          <div style='text-align:right; color:black'>Cash : </div>
        </td>
        <td style='text-align:right; font-size:14pt; color:black'>{{ $data['paid'] }}</td>
      </tr>
      <tr>
        <td colspan='3'>
          <div style='text-align:right; color:black'>Kembali : </div>
        </td>
        <td style='text-align:right; font-size:14pt; color:black'>{{ $data['change'] }}</td>
      </tr>
    </table>
    <table style='width:350; font-size:12pt;' cellspacing='2'>
      <tr></br>
        <td align='center'>****** TERIMAKASIH ******</br></td>
      </tr>
    </table>
  </center>
</body>

<script>
  window.print();
</script>

</html>
