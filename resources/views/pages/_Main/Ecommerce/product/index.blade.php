@extends('layouts.master')

@section('title')
  @lang('translation.Products')
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
      @lang('translation.Products')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>@lang('translation.Product_List')</h4>
            <div class="d-flex justify-content-end">
              <a class="btn btn-primary waves-effect waves-light" type="button"
                href="{{ route('admin.products.create') }}">
                <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah Produk
              </a>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-products">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kode</th>
                  <th>Nama</th>
{{--                  <th>Gambar</th>--}}
                  <th>Harga</th>
                  <th>Stok</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($products as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
{{--                    <td>--}}
{{--                      <button class="btn btn-sm btn-primary" type="button">--}}
{{--                        Lihat thumbnail--}}
{{--                      </button>--}}
{{--                      <button class="btn btn-sm btn-primary" type="button">--}}
{{--                        Lihat Gambar Produk--}}
{{--                      </button>--}}
{{--                    </td>--}}
                    <td>
                      {{ moneyFormat($item->price) }}
                    </td>
                    <td>
                      {{ $item->stock }}
                    </td>
                    <td>
                      {{ $item->status }}
                    </td>
                    <td>
                      <a class="btn btn-primary waves-effect waves-light btn-sm detailProduct" type="button"
                        href="{{ route('admin.products.show', $item->slug) }}">
                        <i class="bx bx-detail"></i> Detail
                      </a>

                      <a class="btn btn-warning waves-effect waves-light btn-sm editProduct"
                        href="{{ route('admin.products.edit', $item->id) }}">
                        <i class="bx bx-edit"></i> Edit
                      </a>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteProduct"
                        onclick="deleteProduct('{{ $item->id }}')">
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
  <div class="modal fade" id="deleteProductModal" role="dialog" aria-labelledby="deleteProductModalProduct"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Anda yakin akan menghapus produk ini?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteProductConfirmBtn" type="button">Hapus</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Batal</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- @include('pages._Main.Ecommerce.product.add') --}}
  {{-- @include('pages._Main.Ecommerce.product.edit') --}}
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-products');
    $('.select2').select2();
  </script>

  <script>
    var message = getCookie('successMessage');
    console.log(message);
    if (message) {
      toastSuccess(message);
      document.cookie = "successMessage=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/admin/products";
    }

    // success message update
    // var messageUpdate = getCookie('successMessageUpdate');
    // console.log(messageUpdate);
    // if (messageUpdate) {
    //   toastSuccess(messageUpdate);
    //   document.cookie = "successMessageUpdate=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/admin/products";
    // }

    function getCookie(name) {
      var value = "; " + document.cookie;
      var parts = value.split("; " + name + "=");
      if (parts.length == 2) {
        return parts.pop().split(";").shift();
      }
    }
  </script>

  <script>
    $('.addProduct').click(function(e) {
      loadBtn($(this));

      $.ajax({
        url: "{{ route('admin.products.store') }}",
        type: "POST",
        data: $('#addProductForm').serialize(),
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addProductModal').modal('hide');
            $('.addProduct').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addProductForm')[0].reset();

            $('#tbl-products').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-products', function() {
              dataTableInit('#tbl-products');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addProduct").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const editProduct = (id) => {
      $.ajax({
        url: `{{ route('admin.products.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editProductModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update product
    $('.updateProduct').click(function(e) {
      loadBtn($(this));
      const name = $('#editName').val();
      const email = $('#editEmail').val();
      const role = $('#editRole').val();
      const id = $('#editId').val();
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.products.update', ':id') }}`.replace(':id', id),
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
            $('#editProductModal').modal('hide');
            $(".updateProduct").html('Save').removeClass('disabled');
            $('#editProductForm')[0].reset();

            $('#tbl-products').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-products', function() {
              dataTableInit('#tbl-products');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateProduct").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteProduct = (id) => {
      $('#deleteProductModal').modal('show');
      $('#deleteId').val(id);
    }

    $('.deleteProductConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.products.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteProductModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteProductConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-products').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-products', function() {
              dataTableInit('#tbl-products');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteProductConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection
