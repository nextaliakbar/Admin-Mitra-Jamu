@extends('layouts.master')

@section('title')
  @lang('translation.Dashboards')
@endsection

@section('css')
  <!-- DataTables -->
  <link type="text/css" href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Dashboards
    @endslot
    @slot('title')
      Forecasting
    @endslot
  @endcomponent

  <!--  Forecast description -->
  <div class="offcanvas offcanvas-end" id="offcanvasWithBothOptions" data-bs-scroll="true"
    aria-labelledby="offcanvasWithBothOptionsLabel" tabindex="-1">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Forecasting (Peramalan)</h5>
      <button class="btn-close text-reset" data-bs-dismiss="offcanvas" type="button" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="bg-secondary bg-soft rounded p-2">
        <p class="fw-bold">Fitur Forecasting akan menampilkan hasil peramalan dari produk <strong>Baglog</strong>
          pada awal pembukaan aplikasi</p>
      </div>

      <div class="bg-secondary bg-soft rounded p-2 mt-2">
        <p class="fw-bold mb-1">Tujuan Fitur Forecasting</p>
        <p>Fitur forecasting dapat <span class="fw-bold">memberikan acuan jumlah produksi</span> untuk periode berikutnya
          kepada perusahaan dengan
          memproses data
          penjualan sebelumnya kedalam perhitungan forecasting menggunakan metode Triple Exponential Smoothing</p>
        <p>
      </div>


      <div class="bg-secondary bg-soft rounded p-2 my-2">
        <p class="fw-bold mb-1">Ingin melakukan permalan untuk produk lainnya?</p>
        <p class="m-0">
          <i class="mdi mdi-numeric-1-box-multiple"></i>
          Pilih produk yang akan di forecast
        </p>
        <p class="m-0"> <i class="mdi mdi-numeric-2-box-multiple"></i> &alpha; (Alpha), &beta; (Beta) dan &gamma;
          (Gamma)
          akan diset default dari sistem sebagai komponen penghalusan proses analisis</p>
        <p class="m-0"> <i class="mdi mdi-numeric-3-box-multiple"></i> Anda dapat merubah komponen penghalusan atau
          hiraukan</p>
        <p class="m-0"> <i class="mdi mdi-numeric-4-box-multiple"></i> Tentukan periode yang akan diramalkan</p>
        <p class="m-0"> <i class="mdi mdi-numeric-5-box-multiple"></i> Tekan tombol Hitung untuk melakukan proses
          peramalan</p>
        <p class="m-0"> <i class="mdi mdi-numeric-6-box-multiple"></i> Hasil forecast akan ditampilkan pada Grafik dan
          table untuk hasil detailnya</p>
      </div>

      {{-- Forecasting adalah proses peramalan atau prediksi yang dilakukan untuk mengetahui stok barang yang akan
      dibutuhkan pada periode selanjutnya. Proses ini dilakukan untuk mengantisipasi kekurangan stok barang yang
      akan terjadi pada periode selanjutnya. Proses ini dilakukan dengan menggunakan metode peramalan
      <strong><i>Triple Exponential Smoothing (Holts Winter).</i></strong>
      </p> --}}
      <p>
        Metode <strong><i>Triple Exponential Smoothing</i></strong> merupakan metode peramalan yang menggunakan 3 komponen
        yaitu <strong>Level</strong>,
        <strong>Trend</strong>, dan <strong>Seasonality</strong>.
        Metode ini menggunakan 3 komponen tersebut untuk melakukan penghalusan peramalan pada data yang diberikan.
      </p>

      <h5>Level &alpha; (Alpha)</h5>
      <p>
        Level merupakan komponen yang digunakan untuk menghaluskan fluktuasi level dari data yang diberikan.
      </p>

      <h5>Trend &beta; (Beta)</h5>
      <p>
        Trend merupakan komponen yang digunakan untuk menghaluskan fluktuasi tren dari data yang diberikan.
      </p>

      <h5>Seasonality &gamma; (Gamma)</h5>
      <p>
        Seasonality merupakan komponen yang digunakan untuk menghaluskan fluktuasi musiman dari data yang diberikan.
      </p>
    </div>
  </div>
  {{-- End of Forecast description  --}}

  <div class="d-flex justify-content-between align-items-center my-4">
    <div class="left d-flex align-items-center">
      <h4 class="me-2">Forecasting</h4>
      <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
        data-toggle="tooltip" data-placement="left" type="button" title="Apa itu Forecasting?"
        aria-controls="offcanvasWithBothOptions">

        <svg class="bi bi-question" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
          viewBox="0 0 16 16">
          <path
            d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
        </svg>
      </button>
    </div>
    {{-- <div class="right">
      <a class="btn btn-primary" href="custom-transaction">
        Manajemen Transaksi
      </a>
    </div> --}}
  </div>
  <div class="row">
    <div class="col-xl-4">
      <div class="card overflow-hidden">
        <div class="bg-primary bg-soft">
          <div class="row">
            <div class="col-7">
              <div class="text-primary p-3">
                <h5 class="text-primary">Forecasting</h5>
                <p>Solusi inovatif untuk bisnis Anda</p>
              </div>
            </div>
            <div class="col-5 align-self-end">
              <img class="img-fluid" src="{{ URL::asset('/assets/images/crypto/features-img/img-2.png') }}"
                alt="">
            </div>
          </div>
        </div>
        <div class="card-body py-3">
          <p class="text-mute">Grafik pertama menampilkan data dari produk <strong>Baglog</strong>, Anda
            dapat memperkirakan data produk lainnya dengan filter di bawah teks berikut.
          </p>
          <div class="d-grid">
            <a class="btn btn-primary waves-effect waves-light btn-sm" href="#filter">Klik!<i
                class="mdi mdi-arrow-down ms-1"></i></a>
          </div>
        </div>
      </div>
      <div class="card" id="filter">
        <div class="card-body">
          <form class="needs-validation" id="formForecast" novalidate>
            <div class="mb-2">
              <h5>Filter Produk</h5>
            </div>
            <div class="mb-1">
              <label fclass="form-label">Produk</label>
              <select class="form-control select2" id="product_id" name="product_id" required>
                @foreach ($productsByCategory as $category => $products)
                  <optgroup label="{{ $category }}">
                    @foreach ($products as $product)
                      <option value="{{ $product->id }}" {{ $product->id == $product_id ? 'selected' : '' }}>
                        {{ $product->product }}</option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>

            <div class="mb-1">
              <label class="col-form-label" for="period">Panjang Peramalan</label>
              <input class="form-control" id="period" name="period" type="number" value="5" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>

            <div class="mb-1">
              <label class="col-form-label" for="alpha">Alpha (&alpha;)</label>
              <input class="form-control" id="alpha" name="alpha" type="number" value="0.761" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>

            <div class="mb-1">
              <label class="col-form-label" for="beta">Beta (&beta;)</label>
              <input class="form-control" id="beta" name="beta" type="number" value="0" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>

            <div class="mb-3">
              <label class="col-form-label" for="gamma">Gamma (&gamma;)</label>
              <input class="form-control" id="gamma" name="gamma" type="number" value="1" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="d-grid">
              <button class="btn btn-primary" id="submitForecast" type="submit">Hitung</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-xl-8">
      <div class="row">
        <div class="col-md-12">
          <div class="card mini-stats-wid">
            <div class="card-body">
              <div class="d-flex">
                <div class="flex-grow-1">
                  <p class="text-muted fw-medium" id="productName">{{ $productName }} Terjual</p>
                  <h4 class="mb-0" id="countOrder">{{ $countOrder }}</h4>
                </div>
                <div class="align-self-center flex-shrink-0">
                  <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                    <span class="avatar-title">
                      <i class="bx bx-copy-alt font-size-24"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card mini-stats-wid">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon me-2">
                  <span class="avatar-title rounded-circle bg-primary">
                    <i class="mdi mdi-map-marker font-size-24"></i>
                  </span>
                </div>
                <p class="text-muted fw-medium m-0" id="productName2">Daerah dengan penjualan {{ $productName }}
                  terbanyak</p>
              </div>
              <div class="table-responsive mt-3">
                <table class="table-nowrap table align-middle">
                  <tbody id="countCity">
                    @foreach ($countCity as $data)
                      <tr>
                        <td style="width: 30%">
                          <p class="mb-0">{{ $data->name }}</p>
                        </td>
                        <td style="width: 25%">
                          <h5 class="mb-0">{{ $data->total }}</h5>
                        </td>
                        <td>
                          <div class="progress progress-sm bg-transparent">
                            <div class="progress-bar bg-primary rounded" role="progressbar"
                              aria-valuenow="{{ $data->percentage }}" aria-valuemin="0" aria-valuemax="100"
                              style="width: {{ $data->percentage }}%">
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div id="forecast_chart">
            <div class="apex-charts h-auto py-4" id="show_chart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card" id="forecast_result">
    <div class="card-body">
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
  </div>

  <div id="data">

  </div>
@endsection
@section('script')
  {{-- select 2 --}}
  <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
  {{-- <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script> --}}

  <!-- form validation -->
  <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
  <!-- Datatable init js -->
  <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

  <!-- apexcharts -->
  <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>

  <script>
    $('#tableResult').DataTable({
      // disable ordering on all columns
      "ordering": false,
    });
  </script>

  <script>
    function chart() {
      var dataActual = {{ $dataActual }};
      var dataForecast = {{ $dataForecast }};
      var dataMonth = JSON.parse('{!! $dataMonth !!}');
      var options = {
        chart: {
          height: 350,
          type: 'line',
          stacked: false,
          zoom: {
            enabled: false
          },
          stroke: {
            width: [0, 2, 4],
            curve: 'smooth'
          },
          toolbar: {
            show: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [3, 3, 4],
          curve: 'straight',
          dashArray: [0, 8, 5]
        },
        series: [{
            name: "Penjualan Aktual",
            type: "area",
            data: dataActual
          },
          {
            name: "Hasil Peramalan",
            type: "line",
            data: dataForecast
          },
        ],
        fill: {
          type: 'gradient',
          opacity: [0.85, 0.25, 1],
          gradient: {
            inverseColors: false,
            shade: 'light',
            type: "vertical",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100]
          }
        },
        title: {
          text: 'Hasil Forecasting {{ $productName }}',
          align: 'center',
          style: {
            fontSize: '16px',
            fontWeight: 'bold',
            fontFamily: undefined,
            color: '#1a1a1a'
          },
        },
        markers: {
          size: 0,
          hover: {
            sizeOffset: 6
          }
        },
        xaxis: {
          categories: dataMonth,
        },
        tooltip: {
          y: [{
            title: {
              formatter: function(val) {
                return val + " (Penjualan Aktual)"
              }
            }
          }, {
            title: {
              formatter: function(val) {
                return val + " (Hasil Peramalan)"
              }
            }
          }]
        },
        grid: {
          borderColor: '#f1f1f1',
        }
      }

      var chart = new ApexCharts(
        document.querySelector("#show_chart"),
        options
      );

      chart.render();
    }

    var initialChart = chart();

    $('#submitForecast').on('click', function(e) {
      e.preventDefault();
      $('#forecast_result').html('');
      $('#forecast_chart').html('');

      var loading = `@include('components.table-loader')`;
      $('#forecast_result').html(loading);
      $('#forecast_chart').html(loading);

      $.ajax({
        url: "{{ route('admin.forecasting.chart') }}",
        type: "POST",
        data: $('#formForecast').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
          $('#forecast_chart').html('');
          $('#forecast_chart').html(response);
          toastSuccess('Berhasil! Data berhasil di forecast');

        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError('Terjadi kesalahan');
          }
          $('#forecast_chart').html('');

        }
      });

      $.ajax({
        url: "{{ route('admin.forecasting.table') }}",
        type: "POST",
        data: $('#formForecast').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
          $('#forecast_result').html('');
          $('#forecast_result').html(response);

          // toastSuccess('Berhasil! Data berhasil di forecast');
        },
        error: function(error) {
          if (error.responseJSON.message) {
            // toastWarning(error.responseJSON.message);
          } else {
            // toastError('Terjadi kesalahan');
          }
          $('#forecast_result').html('');

        }
      })

      $.ajax({
        url: "{{ route('admin.forecasting.count') }}",
        type: "POST",
        data: $('#formForecast').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
          $('#countCity').html('');
          var data = Object.values(response.countCity);

          var countCity = data.sort(function(a, b) {
            return b.total - a.total;
          });
          $.each(countCity, function(index, value) {
            $('#countCity').append(
              `
              <tr>
                <td style="width: 30%">
                  <p class="mb-0">${value.name}</p>
                </td>
                <td style="width: 25%">
                  <h5 class="mb-0">${value.total}</h5>
                </td>
                <td>
                  <div class="progress progress-sm bg-transparent">
                    <div class="progress-bar bg-primary rounded" role="progressbar"
                      aria-valuenow="${value.percentage}" aria-valuemin="0" aria-valuemax="100"
                      style="width: ${value.percentage}%">
                    </div>
                  </div>
                </td>
              </tr>
              `
            );
          });

          $('#countOrder').html(response.countOrder);

          $('#productName').html(response.productName + ' Terjual ');
          $('#productName2').html(`Daerah dengan penjualan ${response.productName} terbanyak`);

        },
        error: function(error) {
          if (error.responseJSON.message) {
            // toastWarning(error.responseJSON.message);
          } else {
            // toastError('Terjadi kesalahan');
          }
          $('#forecast_result').html('');

        }
      })
    });
  </script>
@endsection
