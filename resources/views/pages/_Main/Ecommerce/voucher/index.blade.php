@extends('layouts.master')

@section('title')
  @lang('translation.Vouchers')
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
      @lang('translation.Vouchers_List')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>@lang('translation.Vouchers_List')</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addVoucherModal" type="button">
                <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Add Voucher
              </button>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-vouchers">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($vouchers as $voucher)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $voucher->name }}</td>
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editVoucher" data-bs-toggle="modal"
                        data-bs-target="#editVoucherModal" type="button" onclick="editVoucher('{{ $voucher->id }}')">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteVoucher" data-bs-toggle="modal"
                        data-bs-target="#deleteVoucherModal" type="button"
                        onclick="deleteVoucher('{{ $voucher->id }}')">
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
  <div class="modal fade" id="deleteVoucherModal" role="dialog" aria-labelledby="deleteVoucherModal" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Are you sure want to delete this product voucher?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteVoucherConfirmBtn" type="button">Delete</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages._Main.Ecommerce.voucher.add')
  @include('pages._Main.Ecommerce.voucher.edit')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-vouchers');
    $('.select2').select2();
  </script>

  <script>
    $('.addVoucher').click(function(e) {
      loadBtn($(this));

      $.ajax({
        url: "{{ route('admin.vouchers.store') }}",
        type: "POST",
        data: $('#addVoucherForm').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addVoucherModal').modal('hide');
            $('.addVoucher').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addVoucherForm')[0].reset();

            $('#tbl-vouchers').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-vouchers', function() {
              dataTableInit('#tbl-vouchers');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addVoucher").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const editVoucher = (id) => {
      $.ajax({
        url: `{{ route('admin.vouchers.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editVoucherModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update voucher
    $('.updateVoucher').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const email = $('#editEmail').val();
      const role = $('#editRole').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.vouchers.update', ':id') }}`.replace(':id', id),
        type: "PUT",
        data: {
          name: name,
          email: email,
          role: role,
          _token: _token
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#editVoucherModal').modal('hide');
            $(".updateVoucher").html('Save').removeClass('disabled');
            $('#editVoucherForm')[0].reset();

            $('#tbl-vouchers').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-vouchers', function() {
              dataTableInit('#tbl-vouchers');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateVoucher").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteVoucher = (id) => {
      $('#deleteId').val(id);
    }

    $('.deleteVoucherConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.vouchers.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteVoucherModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteVoucherConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-vouchers').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-vouchers', function() {
              dataTableInit('#tbl-vouchers');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteVoucherConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection
