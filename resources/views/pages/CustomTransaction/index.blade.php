@extends('layouts.master')

@section('title')
  Custom Transaction
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
      Manajemen Penjualan
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>Manajemen Penjualan untuk Forecasting</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#importModal"
                type="button">
                <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah Data Penjualan
              </button>
            </div>
          </div>

          {{-- table custom transaction --}}
          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-customTransaction">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Invoice</th>
                  <th>Produk</th>
                  <th>Tanggal</th>
                  <th>Jumlah</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->invoice }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $item->total_quantity }}</td>
                    <td>
                      <button class="btn btn-warning waves-effect waves-light btn-sm editCustomTransaction"
                        data-bs-toggle="modal" data-bs-target="#editCustomTransactionModal" type="button"
                        onclick="editCustomTransaction('{{ $item->id }}')">
                        <i class="bx bx-edit"></i> Edit
                      </button>

                      <button class="btn btn-danger waves-effect waves-light btn-sm deleteCustomTransaction"
                        data-bs-toggle="modal" data-bs-target="#deleteCustomTransactionModal" type="button"
                        onclick="deleteCustomTransaction('{{ $item->id }}')">
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

  <div class="modal fade" id="importModal" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importModalLabel">Import Data Penjualan</h5>
          <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <div class="d-flex justify-content-between">
                <label for="importExcel">File (.xlsx .xls .csv)</label>
                <a href="{{ asset('template/template.xlsx') }}" class="btn btn-primary btn-sm mb-2" download="">
                  <i class="bx bx-download mr-2 text-white"></i>
                  Download template
                </a>
                </a>
              </div>
              <input id="path" name="path" type="hidden">
              <input name="importExcel" type="file">
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-sm" id="importData">Tambah Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Delete -->
  <div class="modal fade" id="deleteCustomTransactionModal" role="dialog" aria-labelledby="deleteCustomTransactionModal"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Anda yakin akan menghapus data penjualan ini?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-danger deleteCustomTransactionConfirmBtn" type="button">Hapus</button>
            <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Batal</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('pages.CustomTransaction.edit')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
  <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js">
  </script>
  <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-customTransaction');
  </script>

  <script>
    const importExcel = document.querySelector('input[name="importExcel"]');
    const importExcelPond = FilePond.create(importExcel, {
      // acceptedFileTypes: excel, csv file
      acceptedFileTypes: [
        "application/vnd.ms-excel",
        "text/csv",
        "application/csv",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
      ],
      allowImagePreview: true,
      imagePreviewHeight: 170,
      // Add server url
      server: {
        process: {
          url: "{{ route('filepond.upload') }}",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
        },
        revert: {
          url: "{{ route('filepond.revert') }}",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
        },
      },
    });

    importExcelPond.on("processfile", (error, file) => {
      if (error) {
        console.log("Oh no");
        return;
      }

      const data = JSON.parse(file.serverId);
      document.getElementById("path").value = data.path;
    });

    importExcelPond.on("removefile", (error, file) => {
      if (error) {
        console.log("Oh no");
        return;
      }

      const data = JSON.parse(file.serverId);
      document.getElementById("path").value = "";
    });
  </script>

  <script>
    const importData = document.getElementById("importData");
    importData.addEventListener("click", function(e) {
      e.preventDefault();
      loadBtn(importData)
      const path = document.getElementById("path").value;
      if (path == "") {
        alert("Please upload file first!");
      } else {
        $.ajax({
          url: "{{ route('admin.custom-transaction.store') }}",
          type: "POST",
          data: {
            path: path,
            _token: "{{ csrf_token() }}"
          },
          success: function(data) {
            if (data.status == "success") {
              toastSuccess(data.message);
              setTimeout(function() {
                window.location.reload();
              }, 2000);
            } else {
              toastError(data.message);
              importData.innerHTML = "Import Data";
            }
          },
          error: function(data) {
            if (data.status == 422) {
              toastError(data.responseJSON.message);
              importData.innerHTML = "Import Data";
            } else {
              toastError("Something went wrong!");
              importData.innerHTML = "Import Data";
            }
          }
        });
      }
    });
  </script>

  <script>
    const editCustomTransaction = (id) => {
      $.ajax({
        url: `{{ route('admin.custom-transaction.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editQuantity').val(data)
            $('#editId').val(id)
          }
        },
        error: (error) => {
          $('#editCustomTransactionModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }

    // update voucher
    $('.updateCustomTransaction').click(function(e) {
      loadBtn($(this));
      const quantity = $('#editQuantity').val();
      const id = $('#editId').val();
      console.log(quantity, id);
      const _token = '{{ csrf_token() }}';
      $.ajax({
        url: `{{ route('admin.custom-transaction.update', ':id') }}`.replace(':id', id),
        type: "PUT",
        data: {
          quantity: quantity,
          _token: _token
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#editCustomTransactionModal').modal('hide');
            $(".updateCustomTransaction").html('Save').removeClass('disabled');
            $('#editCustomTransactionForm')[0].reset();

            $('#tbl-customTransaction').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-customTransaction', function() {
              dataTableInit('#tbl-customTransaction');
            });

          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".updateCustomTransaction").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const deleteCustomTransaction = (id) => {
      $('#deleteId').val(id);
    }

    $('.deleteCustomTransactionConfirmBtn').on('click', function(e) {
      loadBtn($(this));
      const id = $('#deleteId').val();
      $.ajax({
        type: "DELETE",
        url: `{{ route('admin.custom-transaction.destroy', ':id') }}`.replace(':id', id),
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#deleteCustomTransactionModal').modal('hide');
            $('#deleteId').val('');
            $('.deleteCustomTransactionConfirmBtn').html(
                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
              )
              .removeClass('disabled');
            $('#tbl-customTransaction').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-customTransaction', function() {
              dataTableInit('#tbl-customTransaction');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $('.deleteCustomTransactionConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
        }
      });
    });
  </script>
@endsection

@section('bottom-css')
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
    rel="stylesheet" />
@endsection
