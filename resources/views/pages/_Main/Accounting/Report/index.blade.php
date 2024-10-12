@extends('layouts.master')

@section('title')
  Laporan Penjualan
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
      Laporan Penjualan
    @endslot
  @endcomponent
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Laporan Penjualan</h4>
        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('admin.report.index') }}" method="GET">
              <div class="row mb-4">
                <label class="col-sm-4 col-form-label" for="">Tanggal Awal</label>
                <div class="col-sm-8">
                  <div class="input-group" id="datepicker2">
                    <input class="form-control" name="start_date" data-date-format="dd M, yyyy"
                      data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true"
                      type="text" placeholder="dd M, yyyy">

                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                  </div><!-- input-group -->
                </div>
              </div>
              <div class="row mb-4">
                <label class="col-sm-4 col-form-label" for="">Tanggal Akhir</label>
                <div class="col-sm-8">
                  <div class="input-group" id="datepicker2">
                    <input class="form-control" name="end_date" data-date-format="dd M, yyyy"
                      data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true"
                      type="text" placeholder="dd M, yyyy">

                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                  </div><!-- input-group -->
                </div>
              </div>
              <div>
                <button class="btn btn-success w-md" type="submit"><i
                    class="bx bx-search font-size-16 me-2 align-middle"></i>Filter</button>
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <form>
              <div class="row mb-4">
                <label class="col-lg-6 col-form-label" for="">
                  <h5>Total Penjualan</h5>
                </label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <input class="form-control-lg" name="" type="text" value="{{ moneyFormat($total['total_penjualan']) }}"
                      @disabled(true)>
                  </div><!-- input-group -->
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h4>Laporan Penjualan</h4>
          </div>
          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-report">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Inovoice</th>
                  <th>Jenis</th>
                  <th>Pemasukan</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['date'] }}</td>
                    <td>{{ $item['invoice'] }}</td>
                    <td>
                      @if (strpos($item['invoice'], 'CSR') !== false)
                        Kasir
                      @elseif(strpos($item['invoice'], 'ECM') !== false)
                        E-Commerce
                      @elseif(strpos($item['invoice'], 'CUST') !== false)
                        Custom
                      @endif
                    </td>
                    <td>{{ moneyFormat($item['harga_jual']) }}</td>
                  </tr>
                @endforeach
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
   $(document).ready(function() {
    $('#tbl-report').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
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
