@extends('layouts.master')

@section('title')
  Neraca
@endsection

@section('css')
  <link type="text/css" href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Dashboard
    @endslot
    @slot('title')
      Neraca
    @endslot
  @endcomponent
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Neraca</h4>
        {{-- <div class="row">
        <div class="col-md-6">
          <form>
            <div class="row mb-4">
              <label for="" class="col-sm-3 col-form-label">Pilih Tahun</label>
              <div class="col-sm-6">
                <select class="form-select">
                  <option>Select</option>
                  <option>2015</option>
                  <option>2016</option>
                  <option>2017</option>
                  <option>2018</option>
                  <option>2019</option>
                  <option>2020</option>
                  <option>2021</option>
                  <option>2022</option>
                </select>
              </div>
              <div class="col-sm-3">
                <button type="submit" class="btn btn-success w-md"><i
                    class="bx bx-search font-size-16 me-2 align-middle"></i>Filter</button>
              </div>
            </div>
          </form>
        </div>
      </div> --}}
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addCasheModal" type="button">
                <i class="bx bx-printer font-size-16 me-2 align-middle"></i> Cetak
              </button>
            </div>
          </div>
          <h4 style="text-align:center"><b>Laporan Posisi Keuangan (Neraca)</b></h4>
          <div id="table">
            <table class="table-hover dt-responsive mb-0 table table">
              <thead>
                <tr>
                  <th class="balancesheet-header" colspan=" 2">AKTIVA TETAP / FIXED ASSET</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data['assetFixed'] as $item)
                  <tr>
                    <td>{{ $item['nama'] }}</td>
                    <td style="text-align:right">{{ moneyFormat($item['price']) }}</td>
                  </tr>
                @endforeach
                <tr>
                  <td>Akumulasi Penyusutan Peralatan</td>
                  <td style="text-align:right">{{ moneyFormat($data['depresiation']) }}</td>
                </tr>
                <tr class="balancesheet-row">
                  <td><i>Total Aktiva Tetap </i></td>
                  <td style=" text-align:right;"><i>{{ moneyFormat($data['totalAssetFixed']) }}</i></td>
                </tr>
              </tbody>
            </table>
            <table class="table-hover dt-responsive mb-0 table table">
              <thead>
                <tr>
                  <th class="balancesheet-header" colspan=" 2">AKTIVA LANCAR / CURRENT ASSET</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style=text-align:left;>Piutang Usaha</td>
                  <td style="text-align:right">{{ moneyFormat($data['piutang_usaha']) }}</td>
                </tr>
                <tr>
                  <td style=text-align:left;>Persediaan Barang Dagang</td>
                  <td style="text-align:right">{{ moneyFormat($data['persediaan_barang']) }}</td>
                </tr>
                <tr class="balancesheet-row">
                  <td><i>Total Aktiva Lancar </i></td>
                  <td style=" text-align:right;"><i>{{ moneyFormat($data['totalAssetCurrent']) }}</i></td>
                </tr>
              </tbody>
            </table>
            <table class="table-hover dt-responsive mb-0 table table">
              <tbody>
                <tr class="balancesheet-row">
                  <td><b><i>Total Aset / Aktiva </i></b></td>
                  <td style=" text-align:right;"><b><i>{{ moneyFormat($data['totalAsset']) }}</i></b></td>
                </tr>
              </tbody>
            </table>
            <table class="table-hover dt-responsive mb-0 table table">
              <thead>
                <tr>
                  <th class="balancesheet-header" colspan=" 2">KEWAJIBAN / LIABILITY</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Hutang Usaha
                  <td>
                  <td style="text-align:right">{{ moneyFormat($data['hutang_usaha']) }}</td>
                </tr>
                <tr>
                  <td>Penggajian</td>
                  <td style="text-align:right">{{ moneyFormat($data['gaji']) }}</td>
                </tr>
              </tbody>
            </table>
            <table class="table-hover dt-responsive mb-0 table table">
              <tbody>
                <tr class="balancesheet-row">
                  <td><b><i>Total Kewajiban</i></b></td>
                  <td style=" text-align:right;"><b><i>{{ moneyFormat($data['totalKewajiban']) }}</i></b></td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-receivable');
    $('.select2').select2();
  </script>

  <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>

  <!-- form advanced init -->
  <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
@endsection
