<div class="card-body" id="show_result">
  <div class="card-title mb-4">
    Detail Hasil Forecasting
  </div>

  <div class="d-flex justify-content-end mb-3">
    <table class="table-bordered dt-responsive nowrap">
      <thead>
        <tr>
          <th class="p-2">MSE</th>
          <th class="p-2">MAPE</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center">{{ round($mse, 2) }}</td>
          <td class="text-center">{{ round($mape, 2) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <table class="table-bordered dt-responsive nowrap w-100 table" id="tableResult">
    <thead>
      <tr>
        <th colspan="2">Periode</th>
        <th rowspan="2">Penjualan Aktual</th>
        <th rowspan="2">Hasil Peramalan</th>
        {{-- <th rowspan="2">Erorr</th> --}}
      </tr>
      <tr>
        <th>Tahun</th>
        <th>Bulan</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($dataTable as $key => $item)
        <tr>
          <td>{{ $item['year'] }}</td>
          <td>{{ $item['month'] }}</td>
          <td>{{ $item['actual'] }}</td>
          <td>{{ $item['forecast'] }}</td>
          {{-- <td>{{ $item['error'] }}</td> --}}
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<script>
  $('#tableResult').DataTable({
    'ordering': false,
  });
</script>
