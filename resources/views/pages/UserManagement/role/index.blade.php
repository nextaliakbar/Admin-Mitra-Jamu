@extends('layouts.master')

@section('title')
  @lang('translation.Role')
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
      @lang('translation.Roles_List')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>@lang('translation.Roles_List')</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addRoleModal" type="button">
                <i class="bx bx-user-plus font-size-16 me-2 align-middle"></i> Add Role
              </button>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-roles">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Role Name</th>
                  <th>Permissions</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($roles as $role)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                      @if ($role->permissions)
                        @foreach ($role->permissions as $permission)
                          <span class="badge bg-primary my-1 p-2">{{ $permission->name }}</span>
                        @endforeach
                      @else
                        <span class="badge bg-danger my-1 p-2">No Permission</span>
                      @endif
                    </td>
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editRole" data-bs-toggle="modal"
                        data-bs-target="#editRoleModal" type="button" onclick="editRole({{ $role->id }})">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteRole" data-bs-toggle="modal"
                        data-bs-target="#deleteRoleModal" type="button" onclick="deleteRole({{ $role->id }})">
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
  <div class="modal fade" id="deleteRoleModal" role="dialog" aria-labelledby="deleteRoleModalLabel" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Are you sure want to delete this role?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteRoleConfirmBtn" type="button">Delete</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages.UserManagement.role.add')
  @include('pages.UserManagement.role.edit')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>

  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('/js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-roles');
    $('.select2').select2();
  </script>

  <script>
    $('.addRole').click(function(e) {
      loadBtn($(this));

      $.ajax({
        url: "{{ route('admin.roles.store') }}",
        type: "POST",
        data: $('#addRoleForm').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addRoleModal').modal('hide');
            $('.addRole').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addRoleForm')[0].reset();
            $('.select2').val(null).trigger('change');
            $('#tbl-roles').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-roles', function() {
              dataTableInit('#tbl-roles');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addRole").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const editRole = (id) => {
      $.ajax({
        url: `{{ route('admin.roles.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          const permissions = response.permissions.map((item) => {
            return item.name;
          });
          if (response) {
            $('#editName').val(data.name)
            $('#editPermissions').val(permissions).trigger('change');
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editRoleModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update role
    $('.updateRole').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const permissions = $('#editPermissions').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.roles.update', ':id') }}`.replace(':id', id),
        type: "PUT",
        data: {
          name: name,
          permissions: permissions,
          _token: _token
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#editRoleModal').modal('hide');
            $(".updateRole").html('Save').removeClass('disabled');
            $('#editRoleForm')[0].reset();

            $('#tbl-roles').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-roles', function() {
              dataTableInit('#tbl-roles');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateRole").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteRole = (id) => {
      $('#deleteId').val(id);
    }

    $('.deleteRoleConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.roles.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteRoleModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteRoleConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-roles').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-roles', function() {
              dataTableInit('#tbl-roles');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteRoleConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection
