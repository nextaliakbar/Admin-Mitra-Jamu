@extends('layouts.master')

@section('title')
  Label
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
     Label
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>Daftar Label</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addLabelModal" type="button">
                <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah Label
              </button>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-productLabels">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($productLabels as $productLabel)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $productLabel->name }}</td>
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editLabel" data-bs-toggle="modal"
                        data-bs-target="#editLabelModal" type="button" onclick="editLabel('{{ $productLabel->id }}')">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteLabel" data-bs-toggle="modal"
                        data-bs-target="#deleteLabelModal" type="button"
                        onclick="deleteLabel('{{ $productLabel->id }}')">
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
  <div class="modal fade" id="deleteLabelModal" role="dialog" aria-labelledby="deleteLabelModalLabel" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Are you sure want to delete this product label?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteLabelConfirmBtn" type="button">Delete</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages._Main.Ecommerce.label.add')
  @include('pages._Main.Ecommerce.label.edit')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-productLabels');
    $('.select2').select2();
  </script>

  <script>
    $('.addLabel').click(function(e) {
      loadBtn($(this));

      $.ajax({
        url: "{{ route('admin.labels.store') }}",
        type: "POST",
        data: $('#addLabelForm').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addLabelModal').modal('hide');
            $('.addLabel').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addLabelForm')[0].reset();

            $('#tbl-productLabels').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-productLabels', function() {
              dataTableInit('#tbl-productLabels');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addLabel").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const editLabel = (id) => {
      $.ajax({
        url: `{{ route('admin.labels.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editLabelModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update productLabel
    $('.updateLabel').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const email = $('#editEmail').val();
      const role = $('#editRole').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.labels.update', ':id') }}`.replace(':id', id),
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
            $('#editLabelModal').modal('hide');
            $(".updateLabel").html('Save').removeClass('disabled');
            $('#editLabelForm')[0].reset();

            $('#tbl-productLabels').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-productLabels', function() {
              dataTableInit('#tbl-productLabels');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateLabel").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteLabel = (id) => {
      $('#deleteId').val(id);
    }

    $('.deleteLabelConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.labels.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteLabelModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteLabelConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-productLabels').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-productLabels', function() {
              dataTableInit('#tbl-productLabels');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteLabelConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection
