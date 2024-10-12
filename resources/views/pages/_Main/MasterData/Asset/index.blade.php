@extends('layouts.master')

@section('title')
  Asset
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
      Asset
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>Asset</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addAssetModal" type="button">
                <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah Asset
              </button>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-asset">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Asset</th>
                  <th>Tanggal</th>
                  <th>Unit</th>
                  <th>Tipe</th>
                  <th>Umur Manfaat (Bulan)</th>
                  <th>Harga Asset</th>
                  <th>Akumulasi Penyusutan (Bulan)</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($assets as $asset)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->date }}</td>
                    <td>{{ $asset->unit }}</td>
                    <td>{{ $asset->type }}</td>
                    <td>{{ $asset->useful_life }}</td>
                    <td>{{ @moneyFormat($asset->assets_price) }}</td>
                    <td>{{ @moneyFormat($asset->monthly_depreciation) }}</td>
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editAsset" data-bs-toggle="modal"
                        data-bs-target="#editAssetModal" type="button" onclick="editAsset('{{ $asset->id }}')">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteAsset" data-bs-toggle="modal"
                        data-bs-target="#deleteAssetModal" type="button" onclick="deleteAsset('{{ $asset->id }}')">
                        <i class="bx bx-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->

  <!-- Modal Delete -->
  <div class="modal fade" id="deleteAssetModal" role="dialog" aria-labelledby="deleteAssetModal" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Are you sure want to delete this Asset?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteAssetConfirmBtn" type="button">Delete</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages._Main.MasterData.Asset.add')
  @include('pages._Main.MasterData.Asset.edit')
@endsection

@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-asset');
    $('.select2').select2();
  </script>

  <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>

  <script>
    //add asset
    $('.addAsset').click(function(e) {
      loadBtn($(this));

      $.ajax({
        url: "{{ route('admin.asset.store') }}",
        type: "POST",
        data: $('#addAssetForm').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addAssetModal').modal('hide');
            $('.addAsset').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addAssetForm')[0].reset();

            $('#tbl-asset').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-asset', function() {
              dataTableInit('#tbl-asset');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addAsset").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    // #productDiscount input on keyup then write to #discountPrice and actualPrice / discountPrice * 100
    $('#MonthlyDepreciation').keyup(function() {
      if ($('#UsefulLife').val() == '' || $('#UsefulLife').val() == 0) {
        $('#AssetPrice').html('Rp ' + $(this).val());
      } else {
        $('#AssetPrice').html('Rp ' + ($(this).val() / $('#UsefulLife').val()));
      }
    });

    //edit asset
    const editAsset = (id) => {
      $.ajax({
        url: `{{ route('admin.asset.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editDate').val(data.date)
            $('#editUnit').val(data.unit)
            $('#editType').val(data.type)
            $('#editUsefulLife').val(data.useful_life)
            $('#editAssetPrice').val(data.assets_price)
            $('#editMonthlyDepreciation').val(data.monthly_depreciation)
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editAssetModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
            s
          }
        }
      })
    }

    // update asset
    $('.updateAsset').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const date = $('#editDate').val();
      const unit = $('#editUnit').val();
      const type = $('#editType').val();
      const useful_life = $('#editUsefulLife').val();
      const assets_price = $('#editAssetPrice').val();
      const monthly_depreciation = $('#editMonthlyDepreciation').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.asset.update', ':id') }}`.replace(':id', id),
        type: "PUT",
        data: {
          name: name,
          date: date,
          unit: unit,
          type: type,
          useful_life: useful_life,
          assets_price: assets_price,
          monthly_depreciation: monthly_depreciation,
          _token: _token
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#editAssetModal').modal('hide');
            $(".updateAsset").html('Save').removeClass('disabled');
            $('#editAssetForm')[0].reset();

            $('#tbl-asset').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-asset', function() {
              dataTableInit('#tbl-asset');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateAsset").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteAsset = (id) => {
      $('#deleteId').val(id);
    }

    $('.deleteAssetConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        url: `{{ route('admin.asset.destroy', ':id') }}`.replace(':id', id),
        type: "DELETE",
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteAssetModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteAssetConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-asset').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-asset', function() {
              dataTableInit('#tbl-asset');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteAssetConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>

  <script>
    $('#unit').keyup(function() {
      if ($('#UsefulLife').val() == '' || $('#UsefulLife').val() == 0) {
        $('#UsefulLife').val(0);
        $('#AssetPrice').val(0);
        $('#MonthlyDepreciation').val(0);
      }
      if ($('#AssetPrice').val() == '' || $('#AssetPrice').val() == 0) {
        $('#AssetPrice').val(0);
        $('#MonthlyDepreciation').val(0);
      }
      if ($('#MonthlyDepreciation').val() == '' || $('#MonthlyDepreciation').val() == 0) {
        $('#MonthlyDepreciation').val(0);
      }
      // unit * asset price / useful life
      $('#MonthlyDepreciation').val(
        $('#unit').val() * $('#AssetPrice').val() / $('#UsefulLife').val()
      );
    });

    $('#UsefulLife').keyup(function() {
      if ($('#unit').val() == '' || $('#unit').val() == 0) {
        $('#unit').val(0);
        $('#AssetPrice').val(0);
        $('#MonthlyDepreciation').val(0);
      }
      if ($('#AssetPrice').val() == '' || $('#AssetPrice').val() == 0) {
        $('#AssetPrice').val(0);
        $('#MonthlyDepreciation').val(0);
      }
      if ($('#MonthlyDepreciation').val() == '' || $('#MonthlyDepreciation').val() == 0) {
        $('#MonthlyDepreciation').val(0);
      }
      // unit * asset price / useful life
      $('#MonthlyDepreciation').val(
        $('#unit').val() * $('#AssetPrice').val() / $('#UsefulLife').val()
      );
    });

    $('#AssetPrice').keyup(function() {
      if ($('#unit').val() == '' || $('#unit').val() == 0) {
        $('#unit').val(0);
        $('#UsefulLife').val(0);
        $('#MonthlyDepreciation').val(0);
      }
      if ($('#UsefulLife').val() == '' || $('#UsefulLife').val() == 0) {
        $('#UsefulLife').val(0);
        $('#MonthlyDepreciation').val(0);
      }
      if ($('#MonthlyDepreciation').val() == '' || $('#MonthlyDepreciation').val() == 0) {
        $('#MonthlyDepreciation').val(0);
      }
      // unit * asset price / useful life
      $('#MonthlyDepreciation').val(
        $('#unit').val() * $('#AssetPrice').val() / $('#UsefulLife').val()
      );
    });
  </script>
@endsection
