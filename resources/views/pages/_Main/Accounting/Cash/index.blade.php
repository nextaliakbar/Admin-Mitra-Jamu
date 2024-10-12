@extends('layouts.master')

@section('title')
Arus Kas
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
Arus Kas
@endslot
@endcomponent
{{-- <div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title mb-4">Arus Kas</h4>
      <div class="row">
        <div class="col-md-6">
          <form action="{{ route('admin.cash.index') }}" method="GET">
            <div class="row mb-4">
              <label class="col-sm-4 col-form-label" for="">Tanggal Awal</label>
              <div class="col-sm-8">
                <div class="input-group" id="datepicker2">
                  <input class="form-control" name="start_date" data-date-format="dd M, yyyy" data-date-container='#datepicker2'
                    data-provide="datepicker" data-date-autoclose="true" type="text" placeholder="dd M, yyyy">

                  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                </div><!-- input-group -->
              </div>
            </div>
            <div class="row mb-4">
              <label class="col-sm-4 col-form-label" for="">Tanggal Akhir</label>
              <div class="col-sm-8">
                <div class="input-group" id="datepicker2">
                  <input class="form-control" name="end_date" data-date-format="dd M, yyyy" data-date-container='#datepicker2'
                    data-provide="datepicker" data-date-autoclose="true" type="text" placeholder="dd M, yyyy">

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
                <h5>Pendapatan</h5>
              </label>
              <div class="col-sm-6">
                <div class="input-group">
                  <input class="form-control-lg" name="" type="text" value="Rp. 12.000.000,00" @disabled(true)>
                </div><!-- input-group -->
              </div>
            </div>
            <div class="row mb-4">
              <label class="col-lg-6 col-form-label" for="">
                <h5>Pengeluaran</h5>
              </label>
              <div class="col-sm-6">
                <div class="input-group">
                  <input class="form-control-lg" name="" type="text" value="Rp. 12.000.000,00" @disabled(true)>
                </div><!-- input-group -->
              </div>
            </div>
            <div class="row mb-4">
              <label class="col-lg-6 col-form-label" for="">
                <h5>Saldo</h5>
              </label>
              <div class="col-sm-6">
                <div class="input-group">
                  <input class="form-control-lg" name="" type="text" value="Rp. 12.000.000,00" @disabled(true)>
                </div><!-- input-group -->
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> --}}

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h4>Arus Kas</h4>
          <div class="d-flex justify-content-end">
            {{-- <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
              data-bs-target="#addCashModal" type="button">
              <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah Kas
            </button> --}}
          </div>
        </div>
        <div id="table">
          <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-cash">
            <thead>
              <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Inovoice</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Pendapatan</th>
                <th>Pengeluaran</th>
                <th>Keterangan</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($cashFlow as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                <td>{{ $item->invoice }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->type }}</td>
                @if ($item->type == 'Pemasukan')
                <td>{{ $item->nominal }}</td>
                <td>0</td>
                @else
                <td>0</td>
                <td>{{ $item->nominal }}</td>
                @endif
                <td>{{ $item->description }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div> <!-- end col -->
</div> <!-- end row -->

@include('pages._Main.Accounting.Cash.add')
@endsection
@section('script')
<!-- Required datatable js -->
<script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('js/script.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>

<!-- Datatable init -->
<script>
  $(document).ready(function() {
    $('#tbl-cash').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

</script>
<!-- form advanced init -->
<script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
<script>
  $(document).ready(function(){
      $('#tipe').change(function(){
          value = $(this).val();
          if(value == "pendapatan"){
              $('.kotak-jenis-pemasukan').css({display:"block"});
              $('.kotak-jenis-pengeluaran').css({display:"none"});
              $('#pengeluaran').attr('disabled','disabled');
              $('#pemasukan').removeAttr('disabled');
          }else{
              $('.kotak-jenis-pemasukan').css({display:"none"});
              $('.kotak-jenis-pengeluaran').css({display:"block"});
              $('#pemasukan').attr('disabled','disabled');
              $('#pengeluaran').removeAttr('disabled');
          }
      })
  });
</script>

@endsection
