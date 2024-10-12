@extends('layouts.master')

@section('title')
  @lang('translation.Cashier')
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
      @lang('translation.Cashier')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h4>@lang('translation.Cashier') Register</h4>
          </div>
        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->
  <div class="row">
    <div class="col-7">
      <div class="alert alert-primary" role="alert">
        Anda dapat membuka aplikasi kasir dengan mengisi POS register terlebih dahulu.
        <br />
        <b>Isi total jumlah uang sesuai dengan nominal yang tersedia</b>
        <br />
        (Klik pada nominal uang untuk mengisi jumlah uang / isi dengan angka 0 apabila tidak ada nominal uang yang
        tersedia)
      </div>
    </div>
    <div class="col-5">
      <div class="card border-primary border">
        <div class="card-body">
          <h4 class="text-center">Saldo Awal Kasir</h4>
          <h1 class="text-primary text-center" id="total" data-total="0">Rp. 0</h1>
        </div>
      </div>
    </div>
  </div> <!-- end row -->
  <form class="needs-validation" id="registerPosForm" action="{{ route('admin.pos.register') }}" method="POST"
    novalidate>
    @csrf
    <div class="row">
      <div class="col-lg-6 col-12">
        <div class="card border-primary border">
          <div class="card-body">
            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(100000) }}</i></span>
                  <input class="form-control" id="nominal100" name="nominal100" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal100" data-val="0" type="text" readonly>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(50000) }}</i></span>
                  <input class="form-control" id="nominal50" name="nominal50" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal50" data-val="0" type="text" readonly>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(20000) }}</i></span>
                  <input class="form-control" id="nominal20" name="nominal20" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal20" data-val="0" type="text" readonly>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(10000) }}</i></span>
                  <input class="form-control" id="nominal10" name="nominal10" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal10" data-val="0" type="text" readonly>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(5000) }}</i></span>
                  <input class="form-control" id="nominal5" name="nominal5" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal5" data-val="0" type="text" readonly>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-12">
        <div class="card border-primary border">
          <div class="card-body">
            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(2000) }}</i></span>
                  <input class="form-control" id="nominal2" name="nominal2" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal2" data-val="0" type="text" readonly>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(1000) }}</i></span>
                  <input class="form-control" id="nominal1" name="nominal1" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal1" data-val="0" type="text" readonly>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(500) }}</i></span>
                  <input class="form-control" id="nominal05" name="nominal05" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal05" data-val="0" type="text" readonly>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(200) }}</i></span>
                  <input class="form-control" id="nominal02" name="nominal02" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal02" data-val="0" type="text" readonly>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-5 mb-3">
                <div class="input-group">
                  <span class="input-group-text" style="size: 70%;">{{ @moneyFormat(100) }}</i></span>
                  <input class="form-control" id="nominal01" name="nominal01" type="number" value="0"
                    placeholder="0">
                </div>
              </div>
              <div class="form-group col-7 mb-3">
                <input class="form-control" id="valNominal01" data-val="0" type="text" readonly>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </form>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="text-center">
            <button class="btn btn-primary" id="saveRegisterPos" name="saveRegisterPos">
              Simpan
            </button>
            <button class="btn btn-secondary" id="cancelRegisterPos" name="cancelRegisterPos">
              Kembali
            </button>
          </div>
        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->
@endsection
@section('bottom-css')
  <style>
  </style>
@endsection
@section('script')
  <script>
    $(document).ready(function() {

    });
  </script>

  <script>
    function moneyFormat(n) {
      return "Rp. " + n.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    }

    function total() {
      var valNominal100 = $('#valNominal100').attr('data-val');
      var valNominal50 = $('#valNominal50').attr('data-val');
      var valNominal20 = $('#valNominal20').attr('data-val');
      var valNominal10 = $('#valNominal10').attr('data-val');
      var valNominal5 = $('#valNominal5').attr('data-val');
      var valNominal2 = $('#valNominal2').attr('data-val');
      var valNominal1 = $('#valNominal1').attr('data-val');
      var valNominal05 = $('#valNominal05').attr('data-val');
      var valNominal02 = $('#valNominal02').attr('data-val');
      var valNominal01 = $('#valNominal01').attr('data-val');

      var total = parseInt(valNominal100) + parseInt(valNominal50) + parseInt(valNominal20) + parseInt(valNominal10) +
        parseInt(valNominal5) + parseInt(valNominal2) + parseInt(valNominal1) + parseInt(valNominal05) +
        parseInt(valNominal02) + parseInt(valNominal01);

      $('#total').attr('data-total', total);
      $('#total').html(moneyFormat(total));
    }
  </script>

  <script>
    $('#nominal100').on('keyup', function() {
      var nominal100 = $('#nominal100').val();
      var valNominal100 = nominal100 * 100000;
      var valueNominal100 = moneyFormat(valNominal100);
      $('#valNominal100').attr('data-val', valNominal100);
      $('#valNominal100').val(valueNominal100);
      total();
    });

    $('#nominal50').on('keyup', function() {
      var nominal50 = $('#nominal50').val();
      var valNominal50 = nominal50 * 50000;
      var valueNominal50 = moneyFormat(valNominal50);
      $('#valNominal50').attr('data-val', valNominal50);
      $('#valNominal50').val(valueNominal50);
      total();
    });

    $('#nominal20').on('keyup', function() {
      var nominal20 = $('#nominal20').val();
      var valNominal20 = nominal20 * 20000;
      var valueNominal20 = moneyFormat(valNominal20);
      $('#valNominal20').attr('data-val', valNominal20);
      $('#valNominal20').val(valueNominal20);
      total();
    });

    $('#nominal10').on('keyup', function() {
      var nominal10 = $('#nominal10').val();
      var valNominal10 = nominal10 * 10000;
      var valueNominal10 = moneyFormat(valNominal10);
      $('#valNominal10').attr('data-val', valNominal10);
      $('#valNominal10').val(valueNominal10);
      total();
    });

    $('#nominal5').on('keyup', function() {
      var nominal5 = $('#nominal5').val();
      var valNominal5 = nominal5 * 5000;
      var valueNominal5 = moneyFormat(valNominal5);
      $('#valNominal5').attr('data-val', valNominal5);
      $('#valNominal5').val(valueNominal5);
      total();
    });

    $('#nominal2').on('keyup', function() {
      var nominal2 = $('#nominal2').val();
      var valNominal2 = nominal2 * 2000;
      var valueNominal2 = moneyFormat(valNominal2);
      $('#valNominal2').attr('data-val', valNominal2);
      $('#valNominal2').val(valueNominal2);
      total();
    });

    $('#nominal1').on('keyup', function() {
      var nominal1 = $('#nominal1').val();
      var valNominal1 = nominal1 * 1000;
      var valueNominal1 = moneyFormat(valNominal1);
      $('#valNominal1').attr('data-val', valNominal1);
      $('#valNominal1').val(valueNominal1);
      total();
    });

    $('#nominal05').on('keyup', function() {
      var nominal05 = $('#nominal05').val();
      var valNominal05 = nominal05 * 500;
      var valueNominal05 = moneyFormat(valNominal05);
      $('#valNominal05').attr('data-val', valNominal05);
      $('#valNominal05').val(valueNominal05);
      total();
    });

    $('#nominal02').on('keyup', function() {
      var nominal02 = $('#nominal02').val();
      var valNominal02 = nominal02 * 200;
      var valueNominal02 = moneyFormat(valNominal02);
      $('#valNominal02').attr('data-val', valNominal02);
      $('#valNominal02').val(valueNominal02);
      total();
    });

    $('#nominal01').on('keyup', function() {
      var nominal01 = $('#nominal01').val();
      var valNominal01 = nominal01 * 100;
      var valueNominal01 = moneyFormat(valNominal01);
      $('#valNominal01').attr('data-val', valNominal01);
      $('#valNominal01').val(valueNominal01);
      total();
    });
  </script>

  <script>
    $('#saveRegisterPos').on('click', function() {
      var total = $('#total').attr('data-total');
      if (total == 0) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Total saldo awal kasir tidak boleh 0!',
        })
      } else {
        $('#registerPosForm').submit();
      }
    });

    $('#cancelRegisterPos').on('click', function() {
      window.location.href = "{{ route('root') }}";
    });
  </script>
@endsection
