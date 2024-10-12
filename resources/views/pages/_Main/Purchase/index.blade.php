@extends('layouts.master')

@section('title')
  @lang('translation.Purchases')
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
      @lang('translation.Purchase_List')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="card-title">
            <h4>@lang('translation.Purchase_List')</h4>
            <div class="d-flex justify-content-end">
              <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.purchases.create') }}">
                <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Add Stock
              </a>
            </div>
          </div>

          <div id="table">
            <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-purchases">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Invoice</th>
                  <th>Total Cost</th>
                  <th>Payment Method</th>
                  <th>Payment Status</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($purchases as $purchase)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $purchase->date }}</td>
                    <td>{{ $purchase->invoice }}</td>
                    <td>{{ moneyFormat($purchase->total_cost) }}</td>
                    <td>{{ $purchase->payment_method }}</td>
                    @if ($purchase->payment_status == 'lunas')
                      <td> <span class="badge bg-soft-success text-success">Lunas</span> </td>
                    @elseif ($purchase->payment_status == 'belum')
                      <td> <span class="badge bg-soft-danger text-danger">Belum Lunas</span> </td>
                    @endif
                    <td>
                      <button class="btn btn-primary waves-effect waves-light btn-sm editPurchase" data-bs-toggle="modal"
                        data-bs-target="#editPurchaseModal" type="button" onclick="invoice('{{ $purchase->id }}')">
                        <i class="bx bx-detail"></i> Detail
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
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-purchases');
    $('.select2').select2();
  </script>

  <script>
    $('.select2-supplier').select2({
      placeholder: 'Select Supplier',
      ajax: {
        url: `{{ route('admin.suppliers.getSuppliers') }}`,
        dataType: 'json',
        delay: 250,
        data: function data(params) {
          return {
            q: params.term,
          };
        },
        processResults: function processResults(data, params) {
          return {
            results: data.data,
          };
        },

        cache: true
      },
      templateResult: formatSupplier,
      templateSelection: formatSupplierSelection,
      dropdownParent: $('#addStockModal')
    });

    function formatSupplier(repo) {
      var $container = $("<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src='" + repo.avatar + "' /></div>" +
        "<div class='select2-result-repository__meta'>" + "<div class='select2-result-repository__title'></div>" +
        "<div class='select2-result-repository__address'></div>" +
        "<div class='select2-result-repository__statistics d-flex'>" +
        "<div class='select2-result-repository__status'><i class='bx bx-food-menu'></i> </div>" +
        "<div class='select2-result-repository__type'>&nbsp;&nbsp;<i class='bx bx-shekel'></i> </div>" +
        "</div>");
      $container.find(".select2-result-repository__title").text(repo.name);
      $container.find(".select2-result-repository__address").text(repo.address);
      $container.find(".select2-result-repository__status").append(repo.status);
      $container.find(".select2-result-repository__type").append(repo.type);
      return $container;
    }

    function formatSupplierSelection(repo) {
      return repo.name || repo.text;
    }

    $('.select2-product').select2({
      ajax: {
        url: `{{ route('admin.products.getProducts') }}`,
        dataType: 'json',
        delay: 250,
        minimumInputLength: 1,
        data: function data(params) {
          return {
            q: params.term,
          };
        },
        processResults: function processResults(data, params) {
          return {
            results: data.data,
          };
        },
        cache: true
      },
      placeholder: 'Select Product',
      minimumInputLength: 1,
      templateResult: formatProduct,
      templateSelection: formatProductSelection,
      dropdownParent: $('#addStockModal')
    });

    function formatProduct(repo) {
      var $container = $("<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src='" + repo.thumbnail + "' /></div>" +
        "<div class='select2-result-repository__meta'>" + "<div class='select2-result-repository__title'></div>" +
        "<div class='select2-result-repository__price'></div>" +
        "<div class='select2-result-repository__statistics d-flex'>" +
        "<div class='select2-result-repository__status'><i class='bx bx-food-menu'></i> </div>" +
        "<div class='select2-result-repository__stock'>&nbsp;&nbsp;<i class='bx bx-shekel'></i> Stock </div>" +
        "</div>");
      $container.find(".select2-result-repository__title").text(repo.name);
      $container.find(".select2-result-repository__price").text('Rp. ' + repo.price + ',-');
      $container.find(".select2-result-repository__status").append(repo.status);
      $container.find(".select2-result-repository__stock").append(repo.stock);
      return $container;
    }

    function formatProductSelection(repo) {
      return repo.name || repo.text;
    }

    // on change regency
    $('.select2-product').on('change', function() {
      var productId = $(this).val();
      console.log(productId);
    });
  </script>

  <script>
    $('.addPurchase').click(function(e) {
      loadBtn($(this));

      const name = $('#name').val();
      const phone = $('#phone').val();
      const email = $('#email').val();
      const address = $('#address').val();
      const state = $('#province').find(':selected').text();
      const city = $('#regency').find(':selected').text();
      const status = $('#status').val();
      const type = $('#type').val();

      $.ajax({
        url: "{{ route('admin.purchases.store') }}",
        type: "POST",
        data: {
          name: name,
          phone: phone,
          email: email,
          address: address,
          state: state,
          city: city,
          status: status,
          type: type
        },
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(response) {
          if (response) {
            toastSuccess(response.message);
            $('#addPurchaseModal').modal('hide');
            $('.addPurchase').html(
                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
              )
              .removeClass('disabled');
            $('#addPurchaseForm')[0].reset();

            $('#tbl-purchases').html(
              `@include('components.table-loader')`
            );

            $('#table').load(location.href + ' #tbl-purchases', function() {
              dataTableInit('#tbl-purchases');
            });
          }
        },
        error: function(error) {
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
          $(".addPurchase").html('Save').removeClass('disabled');
        },
      });
      return false;
    });

    const invoice = (id) => {
      $.ajax({
        url: `{{ route('admin.purchases.edit', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: (response) => {
          let data = response.data
          if (response) {
            $('#editName').val(data.name)
            $('#editPhone').val(data.phone)
            $('#editEmail').val(data.email)
            $('#editAddress').val(data.address)
            $('#editProvince').val(data.state).trigger('change')
            $('#editRegency').val(data.city).trigger('change')
            $('#editStatus').val(data.status).trigger('change')
            $('#editType').val(data.type).trigger('change')
            $('#editId').val(data.id)
          }
        },
        error: (error) => {
          $('#editPurchaseModal').modal('dispose')
          if (error.responseJSON.message) {
            toastWarning(error.responseJSON.message);
          } else {
            toastError(error.message);
          }
        }
      })
    }
  </script>
@endsection
