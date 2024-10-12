@extends('layouts.master')

@section('title')
@lang('translation.Employment')
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
@lang('translation.Employment')
@endslot
@endcomponent

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <div class="card-title">
          <h4>@lang('translation.Employment')</h4>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
              data-bs-target="#addEmploymentModal" type="button">
              <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Add Employment
            </button>
          </div>
        </div>

        <div id="table">
          <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-employment">
            <thead>
              <tr>
                <th>#</th>
                <th>Employment</th>
                <th>Basic Salary</th>
                <th>Others</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($employments as $employment)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employment->name }}</td>
                <td>{{ @moneyFormat($employment->basic_salary) }}</td>
                <td>{{ $employment->other }}</td>
                <td>{{ $employment->description }}</td>
                <td>
                  <button class="btn btn-warning waves-effect waves-light btn-sm editEmployment" data-bs-toggle="modal"
                    data-bs-target="#editEmploymentModal" type="button"
                    onclick="editEmployment('{{ $employment->id }}')">
                    <i class="bx bx-edit"></i> Edit
                  </button>

                  <button class="btn btn-danger waves-effect waves-light btn-sm deleteEmployment" data-bs-toggle="modal"
                    data-bs-target="#deleteEmploymentModal" type="button"
                    onclick="deleteEmployment('{{ $employment->id }}')">
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
<div class="modal fade" id="deleteEmploymentModal" role="dialog" aria-labelledby="deleteEmploymentModal"
  aria-hidden="true" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h4 class="mt-4">Are you sure want to delete this Employment?</h4>
        <input id="deleteId" type="hidden">
        <div class="d-flex justify-content-center mt-4">
          <button class="btn btn-sm btn-danger deleteEmploymentConfirmBtn" type="button">Delete</button>
          <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

@include('pages._Main.MasterData.Employment.add')
@include('pages._Main.MasterData.Employment.edit')
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

<script>
  //add employment
  $('.addEmployment').click(function (e) {
    loadBtn($(this));

    $.ajax({
      url: "{{ route('admin.employment.store') }}",
      type: "POST",
      data: $('#addEmploymentForm').serialize(),
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      dataType: "json",
      success: function (response) {
        if (response) {
          toastSuccess(response.message);
          $('#addEmploymentModal').modal('hide');
          $('.addEmployment').html(
              `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
            )
            .removeClass('disabled');
          $('#addEmploymentForm')[0].reset();

          $('#tbl-employment').html(
            `@include('components.table-loader')`
          );

          $('#table').load(location.href + ' #tbl-employment', function () {
            dataTableInit('#tbl-employment');
          });
        }
      },
      error: function (error) {
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
        }
        $(".addEmployment").html('Save').removeClass('disabled');
      },
    });
    return false;
  });


  //edit employment
  const editEmployment = (id) => {
    $.ajax({
      url: `{{ route('admin.employment.edit', ':id') }}`.replace(':id', id),
      type: 'GET',
      success: (response) => {
        let data = response.data
        if (response) {
          $('#editName').val(data.name)
          $('#editBasicSalary').val(data.basic_salary)
          $('#editOther').val(data.other)
          $('#editDescription').val(data.description)
          $('#editId').val(data.id)
        }
      },
      error: (error) => {
        $('#editEmploymentModal').modal('dispose')
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
          s
        }
      }
    })
  }

  // update employment
  $('.updateEmployment').click(function (e) {
    loadBtn($(this));
    const name = $('#editName').val();
    const basic_salary = $('#editBasicSalary').val();
    const other = $('#editOther').val();
    const description = $('#editDescription').val();
    const id = $('#editId').val();
    const _token = '{{ csrf_token() }}';
    $.ajax({
      url: `{{ route('admin.employment.update', ':id') }}`.replace(':id', id),
      type: "PUT",
      data: {
        name: name,
        basic_salary: basic_salary,
        other: other,
        description: description,
        _token: _token
      },
      success: function (response) {
        if (response) {
          toastSuccess(response.message);
          $('#editEmploymentModal').modal('hide');
          $(".updateEmployment").html('Save').removeClass('disabled');
          $('#editEmploymentForm')[0].reset();

          $('#tbl-employment').html(
            `@include('components.table-loader')`
          );

          $('#table').load(location.href + ' #tbl-employment', function () {
            dataTableInit('#tbl-employment');
          });

        }
      },
      error: function (error) {
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
        }
        $(".updateEmployment").html('Save').removeClass('disabled');
      },
    });
    return false;
  });

  const deleteEmployment = (id) => {
    $('#deleteId').val(id);
  }

  $('.deleteEmploymentConfirmBtn').on('click', function (e) {
    loadBtn($(this));
    const id = $('#deleteId').val();
    $.ajax({
      url: `{{ route('admin.employment.destroy', ':id') }}`.replace(':id', id),
      type: "DELETE",
      data: {
        "_token": "{{ csrf_token() }}",
      },
      success: function (response) {
        if (response) {
          toastSuccess(response.message);
          $('#deleteEmploymentModal').modal('hide');
          $('#deleteId').val('');
          $('.deleteEmploymentConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
          $('#tbl-employment').html(
            `@include('components.table-loader')`
          );

          $('#table').load(location.href + ' #tbl-employment', function () {
            dataTableInit('#tbl-employment');
          });
        }
      },
      error: function (error) {
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
        }
        $('.deleteEmploymentConfirmBtn').html(
            `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
          )
          .removeClass('disabled');
      }
    });
  });

</script>
@endsection
