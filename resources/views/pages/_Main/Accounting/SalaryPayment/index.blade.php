@extends('layouts.master')

@section('title')
  @lang('translation.Salary-Payment')
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
      @lang('translation.Salary-Payment')
    @endslot
  @endcomponent
  {{-- <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">@lang('translation.Salary-Payment')</h4>
        <div class="row">
          <div class="col-md-6">
            <form>
              <div class="row mb-4">
                <label class="col-sm-4 col-form-label" for="">Tanggal Awal</label>
                <div class="col-sm-8">
                  <div class="input-group" id="datepicker2">
                    <input class="form-control" name="" data-date-format="dd M, yyyy"
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
                    <input class="form-control" name="" data-date-format="dd M, yyyy"
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
                  <h5>Total Pembayaran Gaji</h5>
                </label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <input class="form-control-lg" name="" type="text" value="Rp. 12.000.000,00"
                      @disabled(true)>
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
            <h4>@lang('translation.Salary-Payment')</h4>
            <div class="d-flex justify-content-end">
              <a class="btn btn-primary waves-effect waves-light" type="button"
                href="{{ route('admin.salary-payment.create') }}">
                <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah Pembayaran Gaji
              </a>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-employment">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Gaji Bulan</th>
                  <th>Tanggal</th>
                  <th>Invoice</th>
                  <th>Gaji Pokok</th>
                  <th>Potongan Gaji</th>
                  <th>Gaji Diterima</th>
                  {{-- <th>Action</th> --}}
                </tr>
              <tbody>
                @foreach ($salary_payment as $salary_payment)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $salary_payment->employee->name }}</td>
                    <td>
                      {{\Carbon\Carbon::parse($salary_payment->date_salary)->locale('id')->isoFormat('MMMM') }}
                    </td>
                    <td>{{ $salary_payment->created_at }}</td>
                    <td>{{ $salary_payment->invoice }}</td>
                    <td>{{ @moneyFormat($salary_payment->basic_salary) }}</td>
                    <td>{{ @moneyFormat($salary_payment->salary_reduction) }}</td>
                    <td>{{ @moneyFormat($salary_payment->net_salary) }}</td>
                  </tr>
                @endforeach
              </tbody>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->

  <!-- Modal Delete -->
  <div class="modal fade" id="deleteVoucherModal" role="dialog" aria-labelledby="deleteVoucherModal" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Are you sure want to delete this Employment?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteVoucherConfirmBtn" type="button">Delete</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-employment');
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

  <script>
    var message = getCookie('successMessage');
    if (message) {
      toastSuccess(message);
      document.cookie = "successMessage=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/admin/products";
    }


    function getCookie(name) {
      var value = "; " + document.cookie;
      var parts = value.split("; " + name + "=");
      if (parts.length == 2) {
        return parts.pop().split(";").shift();
      }
    }
  </script>
@endsection
