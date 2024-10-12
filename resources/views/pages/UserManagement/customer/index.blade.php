@extends('layouts.master')

@section('title')
  @lang('translation.Customer')
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
      @lang('translation.Customers_List')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>@lang('translation.Customers_List')</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addCustomerModal" type="button">
                <i class="bx bx-user-plus font-size-16 me-2 align-middle"></i> Tambah Pelanggan
              </button>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-customers">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($customers as $customer)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editCustomer" data-bs-toggle="modal"
                        data-bs-target="#editCustomerModal" type="button" onclick="editCustomer('{{ $customer->id }}')">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteCustomer" data-bs-toggle="modal"
                        data-bs-target="#deleteCustomerModal" type="button"
                        onclick="deleteCustomer('{{ $customer->id }}')">
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
  <div class="modal fade" id="deleteCustomerModal" role="dialog" aria-labelledby="deleteCustomerModalLabel"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Anda yakin akan menghapus data pelanggan ini?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteCustomerConfirmBtn" type="button">Hapus</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Batal</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages.UserManagement.customer.add')
  @include('pages.UserManagement.customer.edit')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-customers');
  </script>

  <script>
    $('.addCustomer').click(function(e) {
      loadBtn($(this));

      $.ajax({
        url: "{{ route('admin.customers.store') }}",
        type: "POST",
        data: $('#addCustomerForm').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addCustomerModal').modal('hide');
            $('.addCustomer').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addCustomerForm')[0].reset();

            $('#tbl-customers').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-customers', function() {
              dataTableInit('#tbl-customers');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addCustomer").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const editCustomer = (id) => {
      $.ajax({
        url: `{{ route('admin.customers.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editEmail').val(data.email)
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editCustomerModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update customer
    $('.updateCustomer').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const email = $('#editEmail').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.customers.update', ':id') }}`.replace(':id', id),
        type: "PUT",
        data: {
          name: name,
          email: email,
          _token: _token
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#editCustomerModal').modal('hide');
            $(".updateCustomer").html('Save').removeClass('disabled');
            $('#editCustomerForm')[0].reset();

            $('#tbl-customers').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-customers', function() {
              dataTableInit('#tbl-customers');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateCustomer").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteCustomer = (id) => {
      $('#deleteId').val(id);
    }

    $('.deleteCustomerConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.customers.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteCustomerModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteCustomerConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-customers').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-customers', function() {
              dataTableInit('#tbl-customers');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteCustomerConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection
