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
@lang('translation.Cashier')
@endslot
@endcomponent

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h4>@lang('translation.Cashier')</h4>
        </div>
      </div>
    </div>
  </div> <!-- end col -->
</div> <!-- end row -->

<form class="needs-validation" id="addStockForm" novalidate>
  <div class="row">
    <div class="col-lg-3 col-12">
      <div class="card border-primary border">
        <div class="card-body">
          <div class="form-group mb-3">
            <label for="name">Date</label>
            <input class="form-control" id="date" name="date" type="text" value="{{ date('Y-m-d H:i:s') }}" readonly>
          </div>

          <div class="form-group mb-3">
            <label for="supplier">Cashier</label>
            <input class="form-control" id="invoice" name="invoice" type="text" value="" readonly>
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="product">Invoice</label>
            <input class="form-control" id="invoice" name="invoice" type="text" value="" readonly>
            </select>
          </div>

        </div>
      </div>
    </div>

    <div class="col-lg-5 col-12">
      <div class="card border-primary border">
        <div class="card-body">

          <div class="form-group mb-3">
            <label class="form-label" for="code_barang">Name</label>
            <div class="input-group">
              <input class="form-control" id="id_employee" name="id_employee" type="hidden" readonly>
              <input class="form-control" id="name" name="name" type="text" readonly placeholder="Employee">
              <span class="input-group-text showModal"><i class='bx bxs-user-rectangle'
                  style="cursor: pointer;"></i></span>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="unit_cost">Product</label>
                <input class="form-control" id="unit_cost" name="unit_cost" type="number" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label" for="last_paids">Harga</label>
                <input class="form-control" id="last_paids" name="last_paids" type="text" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="unit_cost">Unit</label>
                <input class="form-control" id="unit_cost" name="unit" type="text" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label" for="quantity">Quantity</label>
                <input class="form-control" id="quantity" name="quantity" type="number">
              </div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label class="text-white">&nbsp;</label>
            <button class="form-control btn btn-primary" id="addStock" name="addStock" style="width: 100%;">
              Add Product
            </button>
          </div>

        </div>
      </div>
    </div>

    <div class="col-lg-4 col-12">
      <div class="card border-primary border">
        <div class="card-body">
          <h4 class="text-center">Belanja</h4>
          <h1 class="text-primary text-center" id="total_unit_cost">Rp. 0</h1>
        </div>
      </div>

      <div class="card border-primary border">
        <div class="card-body">
          <h4 class="text-center">Total Belanja</h4>
          <h1 class="text-primary text-center" id="total_cost">Rp. 0</h1>
        </div>
      </div>
    </div>
  </div>
</form>

<div class="card">
  <div class="card-body">
    <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-purchases">
      <thead>
        <tr>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Harga Beli Satuan</th>
          <th>Quantity</th>
          <th>Subtotal</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    {{-- button simpan dan kembali --}}
    {{-- <div class="row">
      <div class="col-12">
        <div class="text-center">
          <button class="btn btn-primary" id="savePurchase" name="savePurchase">
            Simpan
          </button>
          <button class="btn btn-secondary" id="cancelPurchase" name="cancelPurchase">
            Kembali
          </button>
        </div>
      </div>
    </div> --}}
  </div>
</div>
<div class="row">
  <div class="col-lg-4 col-12">
    <div class="card border-primary border">
      <div class="card-body">

        <div class="form-group mb-3">
          <label for="supplier">Subtotal</label>
          <input class="form-control" id="invoice" name="invoice" type="text" value="" readonly>
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="product">Diskon</label>
          <input class="form-control" id="invoice" name="invoice" type="text" value="" readonly>
          </select>
        </div>

      </div>
    </div>
  </div>

  <div class="col-lg-4 col-12">
    <div class="card border-primary border">
      <div class="card-body">

        <div class="form-group mb-3">
          <label class="form-label" for="code_barang">Name</label>
          <div class="input-group">
            <input class="form-control" id="id_employee" name="id_employee" type="hidden" readonly>
            <input class="form-control" id="name" name="name" type="text" readonly placeholder="Employee">
            <span class="input-group-text showModal"><i class='bx bxs-user-rectangle'
                style="cursor: pointer;"></i></span>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="unit_cost">Dibayar</label>
              <input class="form-control" id="unit_cost" name="unit_cost" type="number" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <button class="btn btn-secondary btn-uang-pass">Uang Pas [F7]</button>
              <button class="btn btn-secondary mt-2 btn-kosongkan">Kosongkan [F8]</button>
            </div>
          </div>
        </div>
        <div class="form-group mb-3">
          <label class="form-label" for="code_barang">Kembali</label>
          <input class="form-control" id="id_employee" name="id_employee" type="text" readonly>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-12">
    <div class="card border-primary border">
      <div class="card-body">
        <h4 class="text-center">Total di Bayar</h4>
        <h1 class="text-primary text-center" id="total_unit_cost">Rp. 0</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <button class="btn btn-warning btn-cancel"><i class="fa fa-refresh"></i> Cancel</button>
      </div>
      <div class="col-md-12 mt-2">
        <button class="btn btn-success btn-proses">
          <i class="fa fa-spinner fa-spin pull-left" style="display: none"></i>
          <i class="fa fa-location-arrow"></i>
          Proses
          Pembayaran</button>
      </div>
    </div>
  </div>
</div>
</form>
{{-- modal savePurchase, in modal add select input to set payment status --}}
<div class="modal fade" id="modal-savePurchase" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Simpan Pembelian</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="form-savePurchase" novalidate>
          <div class="form-group mb-3">
            <label for="paymentStatus">Status Pembayaran</label>
            <select class="form-control" id="paymentStatus" name="paymentStatus">
              <option value="lunas">Lunas</option>
              <option value="belum">Belum Lunas</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="paymentMethod">Metode Pembayaran</label>
            <select class="form-control" id="paymentMethod" name="paymentMethod">
              <option value="cash">Cash</option>
              <option value="transfer">Transfer</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="paymentDate">Tanggal Pembayaran</label>
            <input class="form-control" id="paymentDate" name="paymentDate" type="date" value="{{ date('Y-m-d') }}">
          </div>
          <div class="form-group mb-3">
            <label for="paymentNote">Catatan Pembelian</label>
            <textarea class="form-control" id="paymentNote" name="paymentNote" rows="3"></textarea>
          </div>
          <div class="form-group mb-3 text-end">
            <button class="btn btn-primary" id="confirm-savePurchase" name="confirm-savePurchase">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('bottom-css')
<style>
  .select2-container {
    z-index: 999 !important;
  }

</style>
@endsection
@section('script')
<!-- Required datatable js -->
<script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('js/script.js') }}"></script>

<script>
  var dataTemp = [];
  var total_cost = 0;

  const formatRupiah = (val) => {
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function dataTempJson(data) {
    for (var i = 0; i < data.length; i++) {
      dataTemp.push({
        'date': data[i].date,
        'supplier': data[i].supplier,
        'product': data[i].product,
        'productName': data[i].productName,
        'quantity': data[i].quantity,
        'unit_cost': data[i].unit_cost,
        'total_unit_cost': data[i].total_unit_cost,
      });
    }
    return dataTemp;
  }

  function deleteStock(e) {
    var table = $('#tbl-purchases').DataTable();
    table.row($(e).parents('tr')).remove().draw();

    // subtract total cost
    total_cost -= parseInt($(e).data('totalunitcost'));
    $('#total_cost').html('Rp. ' + formatRupiah(total_cost));

    var index = $(e).data('index');
    dataTemp.splice(index, 1);

    toastSuccess('Berhasil menghapus data');
  }

  function updateStock(data) {
    var index = dataTemp.findIndex(x => x.product == data.product);

    if (index == -1) {
      dataTemp.push({
        'date': data.date,
        'supplier': data.supplier,
        'product': data.product,
        'productName': data.productName,
        'quantity': data.quantity,
        'unit_cost': data.unit_cost,
        'total_unit_cost': data.total_unit_cost,
      });

      var total_unit_cost_format = formatRupiah('Rp. ' + data.total_unit_cost);

      $('#tbl-purchases').DataTable().row.add([
        data.product,
        data.productName,
        data.unit_cost,
        data.quantity,
        total_unit_cost_format,
        '<button class="btn btn-danger btn-sm" data-index="' + index + '" data-totalunitcost="' + data
        .total_unit_cost + '" onclick="deleteStock(this)">Hapus</button>'
      ]).draw();
    } else {
      dataTemp[index].quantity = parseInt(dataTemp[index].quantity) + parseInt(data.quantity);
      dataTemp[index].total_unit_cost = parseInt(dataTemp[index].total_unit_cost) + parseInt(data.total_unit_cost);
      var total_unit_cost_format = formatRupiah('Rp. ' + dataTemp[index].total_unit_cost);

      // update datatable
      var table = $('#tbl-purchases').DataTable();
      table.row(index).data([
        data.product,
        data.productName,
        data.unit_cost,
        dataTemp[index].quantity,
        total_unit_cost_format,
        '<button class="btn btn-danger btn-sm" data-index="' + index + '" data-totalunitcost="' + dataTemp[index]
        .total_unit_cost + '" onclick="deleteStock(this)">Hapus</button>'
      ]).draw();
    }

    total_cost += parseInt(data.total_unit_cost);

    var total_cost_format = formatRupiah(total_cost);

    $('#total_cost').html('Rp. ' + total_cost_format);

    toastSuccess('Berhasil menambahkan data!');
    $('#addStock').html('Add Stock').removeClass('disabled');

    return true;
  }

  function addTotal() {
    total_cost = 0;
    for (var i = 0; i < dataTemp.length; i++) {
      total_cost += parseInt(dataTemp[i].total_unit_cost);
    }

    $('#total_cost').html('Rp. ' + formatRupiah(total_cost));

    return total_cost;
  }

</script>

<script>
  // #savePurchase is clicked show modal save purchase
  $('#savePurchase').on('click', function (e) {
    e.preventDefault();
    $('#modal-savePurchase').modal('show');
  });

</script>

<script>
  // if #addStock is clicked then add product to table

  $('#addStock').on('click', function (e) {
    loadBtn($(this));
    e.preventDefault();
    var date = $('#date').val();
    var product = $('#product').val();
    var quantity = $('#quantity').val();
    var unit_cost = $('#unit_cost').val();
    var total_unit_cost = $('#total_unit_cost').html().replace('Rp. ', '').replace(/\./g, '');
    var supplier = $('#supplier').val();

    if (product != '' && quantity != '' && unit_cost != '' && supplier != '') {
      var data = {
        date: date,
        product: product,
        productName: $('#product').select2('data')[0].name,
        quantity: quantity,
        unit_cost: unit_cost,
        total_unit_cost: total_unit_cost,
        supplier: supplier
      };
      var total_unit_cost_format = formatRupiah('Rp. ' + data['total_unit_cost']);

      updateStock(data);

      if (dataTemp.length == 0) {
        var saveToJSON = dataTempJson([data]);

        if (saveToJSON) {
          $('#tbl-purchases').DataTable().row.add([
            // date,
            product,
            $('#product').select2('data')[0].name,
            unit_cost,
            quantity,
            total_unit_cost_format,
            `<button class="btn btn-danger btn-sm" onclick="deleteStock(this)" data-totalunitcost="${total_unit_cost}">Delete</button>`
          ]).draw(false);

          toastSuccess('Berhasil menambahkan data!');
          $('#addStock').html('Add Stock').removeClass('disabled');
        } else {
          toastError('Gagal menambahkan data!');
          $('#addStock').html('Add Stock').removeClass('disabled');
        }
      }

      $('#product').val('').trigger('change');
      $('#quantity').val('');
      $('#unit_cost').val('');
      $('#total_unit_cost').html('Rp. 0');
      $('#supplier').val('').trigger('change');

    } else {
      toastWarning('Mohon isi semua form!');

      $(this).html('Add Stock').removeClass('disabled');
    }
    addTotal();
  });

</script>

<script>
  dataTableInit('#tbl-purchases');
  $('.select2').select2();

</script>

<script>
  $('#unit_cost').on('keyup', function () {
    if ($('#quantity').val() != '' && $('#quantity').val() != 0) {
      if ($(this).val() != '' && $(this).val() != 0) {
        var total_unit_cost = formatRupiah($('#quantity').val() * $(this).val());
        $('#total_unit_cost').html('Rp. ' + total_unit_cost);
      }
    }
  });

  $('#quantity').on('keyup', function () {
    if ($('#unit_cost').val() != '' && $('#unit_cost').val() != 0) {
      if ($(this).val() != '' && $(this).val() != 0) {
        var total_unit_cost = formatRupiah($('#unit_cost').val() * $(this).val());
        $('#total_unit_cost').html('Rp. ' + total_unit_cost);
      }
    }
  });

  // if #quantity or #unit_cost is empty, set total_unit_cost to 0
  $('#quantity').on('keyup', function () {
    if ($(this).val() == '' || $(this).val() == 0) {
      $('#total_unit_cost').html('Rp. 0');
    }
  });

  $('#unit_cost').on('keyup', function () {
    if ($(this).val() == '' || $(this).val() == 0) {
      $('#total_unit_cost').html('Rp. 0');
    }
  });

</script>

<script>
  $('.select2-supplier').select2({
    placeholder: 'Select Supplier',
    ajax: {
      url: `{{ route('admin.suppliers.getSuppliers') }}`,
      method: 'GET',
      dataType: 'json',
      delay: 250,
      processResults: function processResults(data) {
        return {
          results: data.data,
        };
      },

      cache: true
    },
    templateResult: formatSupplier,
    templateSelection: formatSupplierSelection,
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
      method: 'GET',
      delay: 250,
      processResults: function processResults(data) {
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

</script>

<script>
  // #confirm-savePurchase save to ajax
  $('#confirm-savePurchase').on('click', function (e) {
    e.preventDefault();
    loadBtn('#confirm-savePurchase');
    const paymentStatus = $('#paymentStatus').val();
    const paymentMethod = $('#paymentMethod').val();
    const paymentDate = $('#paymentDate').val();
    const paymentNote = $('#paymentNote').val();

    const purchases = {
      payment_status: paymentStatus,
      payment_method: paymentMethod,
      payment_date: paymentDate,
      payment_note: paymentNote,
      total_cost: total_cost,
    }
    console.log(purchases.total_cost);
    $.ajax({
      url: `{{ route('admin.purchases.store') }}`,
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data: {
        purchases: purchases,
        purchases_details: dataTemp,
      },
      success: (response) => {
        if (response.success) {
          var message = response.message;
          document.cookie = "successMessage=" + message;
          window.location.replace("{{ route('admin.purchases.index') }}");

          $('#confirm-savePurchase').html('Simpan').removeClass('disabled');
        } else {
          toastWarning(response.message);
          $('#confirm-savePurchase').html('Simpan').removeClass('disabled');
        }
      },
      error: (error) => {
        // $('#editPurchaseModal').modal('dispose')
        if (error.responseJSON.message) {
          $('#confirm-savePurchase').html('Simpan').removeClass('disabled');
          toastWarning(error.responseJSON.message);
        } else {
          $('#confirm-savePurchase').html('Simpan').removeClass('disabled');
          toastError(error.message);
        }
      }
    })
  })

</script>
@endsection
