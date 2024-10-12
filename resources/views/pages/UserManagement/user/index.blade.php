@extends('layouts.master')

@section('title')
  @lang('translation.Users')
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
      @lang('translation.Users_List')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>@lang('translation.Users_List')</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addUserModal" type="button">
                <i class="bx bx-user-plus font-size-16 me-2 align-middle"></i> Tambah Pengguna
              </button>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-users">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($users as $user)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    @if ($user->getRoleNames())
                      @foreach ($user->getRoleNames() as $role)
                        <td><span class="badge bg-primary p-2">{{ $role }}</span></td>
                      @endforeach
                    @endif
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editUser" data-bs-toggle="modal"
                        data-bs-target="#editUserModal" type="button" onclick="editUser('{{ $user->id }}')">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteUser" data-bs-toggle="modal"
                        data-bs-target="#deleteUserModal" type="button" onclick="deleteUser('{{ $user->id }}')">
                        <i class="bx bx-trash"></i> Hapus
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
  <div class="modal fade" id="deleteUserModal" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Anda yakin akan menghapus data pengguna ini?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteUserConfirmBtn" type="button">Hapus</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Batal</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages.UserManagement.user.add')
  @include('pages.UserManagement.user.edit')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-users');
    $('.select2').select2();
  </script>

  <script>
    $('.addUser').click(function(e) {
      loadBtn($(this));

      $.ajax({
        url: "{{ route('admin.users.store') }}",
        type: "POST",
        data: $('#addUserForm').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addUserModal').modal('hide');
            $('.addUser').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Simpan`
              )
              .removeClass('disabled');
            $('#addUserForm')[0].reset();

            $('#tbl-users').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-users', function() {
              dataTableInit('#tbl-users');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addUser").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const editUser = (id) => {
      $.ajax({
        url: `{{ route('admin.users.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editEmail').val(data.email)
            $('#editRole').val(response.userRole).trigger('change')
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editUserModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update user
    $('.updateUser').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const email = $('#editEmail').val();
      const role = $('#editRole').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.users.update', ':id') }}`.replace(':id', id),
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
            $('#editUserModal').modal('hide');
            $(".updateUser").html('Save').removeClass('disabled');
            $('#editUserForm')[0].reset();

            $('#tbl-users').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-users', function() {
              dataTableInit('#tbl-users');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateUser").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteUser = (id) => {
      $('#deleteId').val(id);
    }

    $('.deleteUserConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.users.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteUserModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteUserConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-users').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-users', function() {
              dataTableInit('#tbl-users');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteUserConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection
