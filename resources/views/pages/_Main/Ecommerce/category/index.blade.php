@extends('layouts.master')

@section('title')
  Kategori
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
      Kategori
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>Kategori</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addCategoryModal" type="button">
                <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah Kategori
              </button>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-productCategories">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($productCategories as $productCategory)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $productCategory->name }}</td>
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editCategory" data-bs-toggle="modal"
                        data-bs-target="#editCategoryModal" type="button"
                        onclick="editCategory('{{ $productCategory->id }}')">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteCategory" data-bs-toggle="modal"
                        data-bs-target="#deleteCategoryModal" type="button"
                        onclick="deleteCategory('{{ $productCategory->id }}')">
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
  <div class="modal fade" id="deleteCategoryModal" role="dialog" aria-labelledby="deleteCategoryModalLabel"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Anda yakin akan menghapus kategori prodduk ini?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteCategoryConfirmBtn" type="button">Hapus</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Batal</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages._Main.Ecommerce.category.add')
  @include('pages._Main.Ecommerce.category.edit')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-productCategories');
    $('.select2').select2();
  </script>

  <script>
    $('.addCategory').click(function(e) {
      loadBtn($(this));

      $.ajax({
        url: "{{ route('admin.categories.store') }}",
        type: "POST",
        data: $('#addCategoryForm').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addCategoryModal').modal('hide');
            $('.addCategory').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addCategoryForm')[0].reset();

            $('#tbl-productCategories').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-productCategories', function() {
              dataTableInit('#tbl-productCategories');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addCategory").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const editCategory = (id) => {
      $.ajax({
        url: `{{ route('admin.categories.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editCategoryModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update productCategory
    $('.updateCategory').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const email = $('#editEmail').val();
      const role = $('#editRole').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.categories.update', ':id') }}`.replace(':id', id),
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
            $('#editCategoryModal').modal('hide');
            $(".updateCategory").html('Save').removeClass('disabled');
            $('#editCategoryForm')[0].reset();

            $('#tbl-productCategories').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-productCategories', function() {
              dataTableInit('#tbl-productCategories');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateCategory").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteCategory = (id) => {
      $('#deleteId').val(id);
    }

    $('.deleteCategoryConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.categories.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteCategoryModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteCategoryConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-productCategories').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-productCategories', function() {
              dataTableInit('#tbl-productCategories');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteCategoryConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection
