@extends('layouts.master')

@section('title')
  @lang('translation.Suppliers')
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
      @lang('translation.Supplier_List')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>@lang('translation.Supplier_List')</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addSupplierModal" type="button">
                <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Add Supplier
              </button>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-suppliers">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($suppliers as $supplier)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->address }}</td>
                    @if ($supplier->type == 'internal')
                      <td> <span class="badge bg-soft-success text-success">Internal</span> </td>
                    @elseif ($supplier->type == 'company')
                      <td> <span class="badge bg-soft-warning text-warning">Company</span> </td>
                    @elseif ($supplier->type == 'individual')
                      <td> <span class="badge bg-soft-primary text-primary">Individual</span> </td>
                    @endif
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editSupplier" data-bs-toggle="modal"
                        data-bs-target="#editSupplierModal" type="button" onclick="editSupplier('{{ $supplier->id }}')">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteSupplier" data-bs-toggle="modal"
                        data-bs-target="#deleteSupplierModal" type="button"
                        onclick="deleteSupplier('{{ $supplier->id }}')">
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
  <div class="modal fade" id="deleteSupplierModal" role="dialog" aria-labelledby="deleteSupplierModalLabel"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Are you sure want to delete this Supplier?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteSupplierConfirmBtn" type="button">Delete</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages._Main.Supplier.add')
  @include('pages._Main.Supplier.edit')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    // document ready
    $(document).ready(function() {
      // init datatable
      dataTableInit('#tbl-suppliers');
      $('.select2').select2();
    });
  </script>

  <script>
    $('.addSupplier').click(function(e) {
      loadBtn($(this));

      const name = $('#name').val();
      const phone = $('#phone').val();
      const email = $('#email').val();
      const address = $('#address').val();
      const status = $('#status').val();
      const type = $('#type').val();

      $.ajax({
        url: "{{ route('admin.suppliers.store') }}",
        type: "POST",
        data: {
          name: name,
          phone: phone,
          email: email,
          address: address,
          status: status,
          type: type
        },
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addSupplierModal').modal('hide');
            $('.addSupplier').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addSupplierForm')[0].reset();

            $('#tbl-suppliers').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-suppliers', function() {
              dataTableInit('#tbl-suppliers');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addSupplier").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const editSupplier = (id) => {
      $.ajax({
        url: `{{ route('admin.suppliers.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editPhone').val(data.phone)
            $('#editEmail').val(data.email)
            $('#editAddress').val(data.address)
            $('#editStatus').val(data.status).trigger('change')
            $('#editType').val(data.type).trigger('change')
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editSupplierModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update productSupplier
    $('.updateSupplier').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const email = $('#editEmail').val();
      const phone = $('#editPhone').val();
      const address = $('#editAddress').val();
      const status = $('#editStatus').val();
      const type = $('#editType').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.suppliers.update', ':id') }}`.replace(':id', id),
        type: "PUT",
        data: {
          name: name,
          email: email,
          phone: phone,
          address: address,
          status: status,
          type: type,
          _token: _token
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#editSupplierModal').modal('hide');
            $(".updateSupplier").html('Save').removeClass('disabled');
            $('#editSupplierForm')[0].reset();

            $('#tbl-suppliers').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-suppliers', function() {
              dataTableInit('#tbl-suppliers');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateSupplier").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteSupplier = (id) => {
      $('#deleteId').val(id);
    }

    $('.deleteSupplierConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.suppliers.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteSupplierModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteSupplierConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-suppliers').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-suppliers', function() {
              dataTableInit('#tbl-suppliers');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteSupplierConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection
