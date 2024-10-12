@extends('layouts.master')

@section('title')
@lang('translation.Employees')
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
@lang('translation.Employees')
@endslot
@endcomponent

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <div class="card-title">
          <h4>@lang('translation.Employees')</h4>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
              data-bs-target="#addEmployeeModal" type="button">
              <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Add Employee
            </button>
          </div>
        </div>

        <div id="table">
          <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-employee">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Employment</th>
                <th>Departement</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($employees as $employee)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ $employee->employment->name }}</td>
                <td>{{ $employee->department }}</td>
                <td>{{ $employee->address }}</td>
                <td>
                  @if ($employee->status == 1)
                  <span class="badge bg-success">Aktif</span>
                  @else
                  <span class="badge bg-danger">Resign</span>
                  @endif
                </td>
                <td>
                  <button class="btn btn-warning waves-effect waves-light btn-sm editEmployee" data-bs-toggle="modal"
                    data-bs-target="#editEmployeeModal" type="button"
                    onclick="editEmployee('{{ $employee->id }}')">
                    <i class="bx bx-edit"></i> Edit
                  </button>

                  <button class="btn btn-danger waves-effect waves-light btn-sm deleteEmployee" data-bs-toggle="modal"
                    data-bs-target="#deleteEmployeeModal" type="button"
                    onclick="deleteEmployee('{{ $employee->id }}')">
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
<div class="modal fade" id="deleteEmployeeModal" role="dialog" aria-labelledby="deleteEmployeeModal"
  aria-hidden="true" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h4 class="mt-4">Are you sure want to delete this Employee?</h4>
        <input id="deleteId" type="hidden">
        <div class="d-flex justify-content-center mt-4">
          <button class="btn btn-sm btn-danger deleteEmployeeConfirmBtn" type="button">Delete</button>
          <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

@include('pages._Main.MasterData.Employee.add')
@include('pages._Main.MasterData.Employee.edit')
@endsection

@section('script')
<!-- Required datatable js -->
<script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

<script src="{{ URL::asset('js/script.js') }}"></script>
<!-- Datatable init -->
<script>
  dataTableInit('#tbl-employee');
  $('.select2').select2();

</script>

<script>
  //add employee
  $('.addEmployee').click(function (e) {
    loadBtn($(this));

    $.ajax({
      url: "{{ route('admin.employee.store') }}",
      type: "POST",
      data: $('#addEmployeeForm').serialize(),
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      dataType: "json",
      success: function (response) {
        if (response) {
          toastSuccess(response.message);
          $('#addEmployeeModal').modal('hide');
          $('.addEmployee').html(
              `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
            )
            .removeClass('disabled');
          $('#addEmployeeForm')[0].reset();

          $('#tbl-employee').html(
            `@include('components.table-loader')`
          );

          $('#table').load(location.href + ' #tbl-employee', function () {
            dataTableInit('#tbl-employee');
          });
        }
      },
      error: function (error) {
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
        }
        $(".addEmployee").html('Save').removeClass('disabled');
      },
    });
    return false;
  });


  //edit employee
  const editEmployee = (id) => {
    $.ajax({
      url: `{{ route('admin.employee.edit', ':id') }}`.replace(':id', id),
      type: 'GET',
      success: (response) => {
        let data = response.data
        if (response) {
          $('#editName').val(data.name)
          $('#editEmail').val(data.email)
          $('#editPhone').val(data.phone)
          $('#editAddress').val(data.address)
          $('#editEmployement').val(data.employment_id)
          $('#editDepartment').val(data.department)
          $('#editStatus').val(data.status)
          $('#editId').val(data.id)
        }
      },
      error: (error) => {
        $('#editEmployeeModal').modal('dispose')
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
          s
        }
      }
    })
  }

  // update employee
  $('.updateEmployee').click(function (e) {
    loadBtn($(this));
    const name = $('#editName').val();
    const email = $('#editEmail').val();
    const phone = $('#editPhone').val();
    const address = $('#editAddress').val();
    const employment_id = $('#editEmployement').val();
    const department = $('#editDepartment').val();
    const status = $('#editStatus').val();
    const id = $('#editId').val();
    const _token = '{{ csrf_token() }}';
    $.ajax({
      url: `{{ route('admin.employee.update', ':id') }}`.replace(':id', id),
      type: "PUT",
      data: {
        name: name,
        email: email,
        phone: phone,
        address: address,
        employment_id: employment_id,
        department: department,
        status: status,
        _token: _token
      },
      success: function (response) {
        if (response) {
          toastSuccess(response.message);
          $('#editEmployeeModal').modal('hide');
          $(".updateEmployee").html('Save').removeClass('disabled');
          $('#editEmployeeForm')[0].reset();

          $('#tbl-employee').html(
            `@include('components.table-loader')`
          );

          $('#table').load(location.href + ' #tbl-employee', function () {
            dataTableInit('#tbl-employee');
          });

        }
      },
      error: function (error) {
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
        }
        $(".updateEmployee").html('Save').removeClass('disabled');
      },
    });
    return false;
  });

  const deleteEmployee = (id) => {
    $('#deleteId').val(id);
  }

  $('.deleteEmployeeConfirmBtn').on('click', function (e) {
    loadBtn($(this));
    const id = $('#deleteId').val();
    $.ajax({
      url: `{{ route('admin.employee.destroy', ':id') }}`.replace(':id', id),
      type: "DELETE",
      data: {
        "_token": "{{ csrf_token() }}",
      },
      success: function (response) {
        if (response) {
          toastSuccess(response.message);
          $('#deleteEmployeeModal').modal('hide');
          $('#deleteId').val('');
          $('.deleteEmployeeConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
          $('#tbl-employee').html(
            `@include('components.table-loader')`
          );

          $('#table').load(location.href + ' #tbl-employee', function () {
            dataTableInit('#tbl-employee');
          });
        }
      },
      error: function (error) {
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
        }
        $('.deleteEmployeeConfirmBtn').html(
            `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
          )
          .removeClass('disabled');
      }
    });
  });

</script>
@endsection
