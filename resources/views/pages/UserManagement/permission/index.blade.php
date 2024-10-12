@extends('layouts.master')

@section('title')
  @lang('translation.Permission')
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
      @lang('translation.Permissions_List')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>@lang('translation.Permissions_List')</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addPermissionModal" type="button">
                <i class="bx bx-user-plus font-size-16 me-2 align-middle"></i> Add Permission
              </button>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-permissions">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($permissions as $permission)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editPermission"
                        data-bs-toggle="modal" data-bs-target="#editPermissionModal" type="button"
                        onclick="editPermission({{ $permission->id }})">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deletePermission"
                        data-bs-toggle="modal" data-bs-target="#deletePermissionModal" type="button"
                        onclick="deletePermission({{ $permission->id }})">
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
  <div class="modal fade" id="deletePermissionModal" role="dialog" aria-labelledby="deletePermissionModalLabel"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Are you sure want to delete this permission?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deletePermissionConfirmBtn" type="button">Delete</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages.UserManagement.permission.add')
  @include('pages.UserManagement.permission.edit')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-permissions');
  </script>

  <script>
    $('.addPermission').click(function(e) {
      loadBtn($(this));

      $.ajax({
        url: "{{ route('admin.permissions.store') }}",
        type: "POST",
        data: $('#addPermissionForm').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addPermissionModal').modal('hide');
            $('.addPermission').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addPermissionForm')[0].reset();

            $('#tbl-permissions').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-permissions', function() {
              dataTableInit('#tbl-permissions');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addPermission").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const editPermission = (id) => {
      $.ajax({
        url: `{{ route('admin.permissions.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editPermissionModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update permission
    $('.updatePermission').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.permissions.update', ':id') }}`.replace(':id', id),
        type: "PUT",
        data: {
          name: name,
          _token: _token
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#editPermissionModal').modal('hide');
            $(".updatePermission").html('Save').removeClass('disabled');
            $('#editPermissionForm')[0].reset();

            $('#tbl-permissions').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-permissions', function() {
              dataTableInit('#tbl-permissions');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updatePermission").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deletePermission = (id) => {
      $('#deleteId').val(id);
    }

    $('.deletePermissionConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.permissions.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deletePermissionModal').modal('hide');
            $('#deleteId').val('');
            $('.deletePermissionConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-permissions').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-permissions', function() {
              dataTableInit('#tbl-permissions');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deletePermissionConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection
