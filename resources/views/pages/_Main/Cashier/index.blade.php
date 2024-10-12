@extends('layouts.master')

@section('title')
  Kasir
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
      Kasir
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex justify-content-between" id="tutup_kasir" type="button">
            <h4>Kasir</h4>
            <div class="d-flex justify-content-end">
              <button class="btn btn-danger waves-effect waves-light" id="showModalCloseChasier"type="button">
                <i class="bx bx-x font-size-16 me-2 align-middle"></i> Tutup Kasir
              </button>
            </div>
            {{-- <a class="btn btn-danger" id="showModalCloseChasier" href="{{ route('admin.pos.close') }}"> --}}
            {{-- <a class="btn btn-danger" id="showModalCloseChasier" href="">
            <i class="bx bx-x"></i>
            Tutup Kasir
          </a> --}}
          </div>
        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->

  <input id="id_transaction" name="id_transaction" type="text" hidden>
  <form class="needs-validation" id="addStockForm" novalidate>
    <div class="row">
      <div class="col-lg-3 col-12">
        <div class="card border-primary border">
          <div class="card-body">
            <div class="form-group mb-3">
              <label for="name">Date</label>
              <input class="form-control" id="date" name="date" type="text" value="{{ date('Y-m-d H:i:s') }}"
                readonly>
            </div>

            <div class="form-group mb-3">
              <label for="supplier">Cashier</label>
              <input class="form-control" id="cashier" name="cashier" type="text" value="{{ Auth::user()->name }}"
                readonly>
            </div>

            <div class="form-group mb-3">
              <label for="product">Invoice</label>
              <input class="form-control" id="invoice" name="invoice" type="text" value="{{ $invoice }}"
                readonly>
            </div>
            <div class="form-group mb-3">
              <label for="customer">Customer</label>
              <div class="input-group">
                <select class="form-control" id="customer" name="customer" type="text">
                  <option value="">Pilih Customer</option>
                  @foreach ($customers as $item)
                    {{-- if name = umum then select --}}
                    <option value="{{ $item->id }}" {{ $item->name == 'Umum' ? 'selected' : '' }}>
                      {{ $item->name }}</option>
                  @endforeach
                </select>
                <span class="input-group-text"><i class='bx bxs-user-rectangle'></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5 col-12">
        <div class="card border-primary border">
          <div class="card-body">

            <div class="form-group mb-3">
              <label class="form-label">Kode Produk</label>
              <div class="input-group">
                <input class="form-control" id="id_product" name="id_product" type="text">
                <span class="input-group-text" id="showModalProduct" style="cursor: pointer">Pilih</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name">Nama Product</label>
                  <input class="form-control" id="name_product" name="name_product" type="text" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label" for="price">Harga</label>
                  <input class="form-control" id="price" name="price" type="text" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="unit">Unit</label>
                  <input class="form-control" id="unit" name="unit" type="text" value="pcs" readonly>
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
            <h1 class="text-primary text-center" id="total_unit_cost" data-total="0">Rp. 0</h1>
          </div>
        </div>

        <div class="card border-primary border">
          <div class="card-body">
            <h4 class="text-center">Total Belanja</h4>
            <h1 class="text-primary text-center" id="total_cost" data-total="0">Rp. 0</h1>
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
    </div>
  </div>
  <div class="row">
    <div class="col-lg-8 col-12">
      <div class="card border-primary border">
        <div class="card-body">

          <div class="form-group mb-3">
            <label class="form-label" for="code_barang">Payment Method</label>
            <select class="form-select" id="payment_method" name="payment_method" required>
              <option value="cash">Cash</option>
              <option value="debt">Debt</option>
            </select>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="mb-3">
                <label for="dibayar">Dibayar</label>
                <input class="form-control" id="dibayar" name="dibayar" type="number">
              </div>
            </div>
            <div class="col-md-3">
              <div class="row">
                <button class="btn btn-secondary" id="btn_uang_pas">Uang Pas [F7]</button>
                <button class="btn btn-secondary mt-2" id="btn_kosongkan">Kosongkan [F8]</button>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label class="form-label" for="codeEmployee Data_barang">Kembali</label>
            <input class="form-control" id="kembali" name="" type="text" readonly>
          </div>
          <div class="form-group d-none mb-3" id="dueDateDebt">
            <label for="name">Tanggal Jatuh Tempo<span class="text-danger">*</span></label>
            <input class="form-control" id="dateDebt" name="dateDebt" type="date" min="{{ date('Y-m-d') }}"
              max="2999-12-31">
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-12">
      <div class="card border-primary border">
        <div class="card-body">
          <h4 class="text-center">Total di Bayar</h4>
          <h1 class="text-primary text-center" id="total_dibayar">Rp. 0</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button class="btn btn-warning btn-cancel" id="test"><i class="fa fa-refresh"></i> Cancel</button>
        </div>
        <div class="col-md-12 mt-2">
          <button class="btn btn-success" id="btn_proses">
            <i class="fa fa-location-arrow"></i>
            Proses Pembayaran
          </button>
        </div>
      </div>
    </div>
  </div>
  </form>

  <div class="modal fade bs-example-modal-xl" id="modalProduct" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Produk Data</h5>
          <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table-bordered dt-responsive nowrap w-100 table" id="table-product">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Harga</th>
                      <th>Diskon</th>
                      <th>Stok</th>
                      <th>status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($product as $key => $row)
                      <tr>
                        <td>{{ $row->name }}</td>
                        <td>{{ @moneyFormat($row->price) }}</td>
                        <td>{{ $row->discount }}%</td>
                        <td>{{ $row->stock }}</td>
                        <td>{{ $row->status }}</td>
                        <td>
                          <a class="btn btn-warning btn-sm btn-pilih" id='btn-pick-produk'
                            data-id="{{ $row->id }}" data-name="{{ $row->name }}"
                            data-price="{{ $price = $row->price - ($row->price * $row->discount) / 100 }}"
                            data-stock="{{ $row->stock }}" data-status="{{ $row->status }}" href="#">
                            Pilih</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->

  <!-- Modal Confirmation -->
  <div class="modal fade" id="detailModal" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Apakah anda mencetak resi?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-secondary me-2" data-bs-dismiss="modal" type="button">Tidak</button>
            <button class="btn btn-sm btn-primary" id="detailBtn" type="button">Cetak</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal detail -->
  <div class="modal fade" id="confirmationModal" role="dialog" aria-labelledby="confirmationModalLabel"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4 class="mt-4">Apakah anda yakin untuk melanjutkan transaksi?</h4>
          <input id="deleteId" type="hidden">
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-sm btn-secondary me-2" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-sm btn-primary" id="confirmationBtn" type="button">Lanjut</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Close Cashier -->
  <div class="modal fade bs-example-modal-lg" id="modalCloseCashier" role="dialog"
    aria-labelledby="CloseCashierModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <h2 style="text-align:center;margin:40px 0px">Tutup Kasir</h2>
          <div class="table-responsive">
            <table class="table-hover dt-responsive mb-0 table">
              <tbody>
                <tr>
                  <th class="fs-3 text" scope="row">Total Transaksi</th>
                  <td class="fs-3 text" id="total_transaksi" style="text-align: right"></td>
                </tr>
                <tr>
                  <th class="fs-3 text" scope="row">Saldo Kasir</th>
                  <td class="fs-3 text" id="saldo_kasir" style="text-align: right"></td>
                </tr>
                <tr>
                  <th class="fs-3 text" scope="row">Saldo Register</th>
                  <td class="fs-3 text" id="saldo_register" style="text-align: right"></td>
                </tr>
                <tr>
                  <th class="fs-3 text" scope="row">Pendapatan</th>
                  <td class="fs-3 text" id="pendapatan" style="text-align: right"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary waves-effect" data-bs-dismiss="modal" type="button">Batal</button>
          <button class="btn btn-primary waves-effect waves-light" id="submitCloseCashier"
            type="button">Submit</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
@endsection

@section('bottom-css')
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ URL::asset('js/script.js') }}"></script>

  <script>
    $('#payment_method').on('input', function() {
      const payment_method = $(this).val();
      if (payment_method == 'debt') {
        $('#dueDateDebt').removeClass('d-none');
        $('#btn_proses').attr('disabled', true);
      } else {
        $('#dueDateDebt').addClass('d-none');
        $('#dateDebt').val('');
      }
    });

    $('#dateDebt').on('input', function() {
      const dateDebt = $(this).val();
      if (dateDebt == '') {
        $('#btn_proses').attr('disabled', true);
      } else {
        $('#btn_proses').attr('disabled', false);
      }
    });

    dataTableInit('#tbl-purchases');

    $('#customer').select2({
      placeholder: 'Pilih Customer',
    });

    function moneyFormat(n) {
      return "Rp. " + n.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    }

    function total() {
      var price = $('#price').val();
      var quantity = $('#quantity').val();

      var total = price * quantity;

      $('#total_unit_cost').attr('data-total', total);

      $('#total_unit_cost').text(moneyFormat(total));
    }
  </script>

  <script>
    var dataTemp = [];
    var total_cost = 0;

    const formatRupiah = (val) => {
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function dataTempJson(data) {
      for (var i = 0; i < data.length; i++) {
        dataTemp.push({
          'id_product': data[i].id_product,
          'name_product': data[i].name_product,
          'price': data[i].price,
          'quantity': data[i].quantity,
          'total_unit_cost': data[i].total_unit_cost,
          'customer': data[i].customer
        });
      }
      return dataTemp;
    }

    function deleteStock(e) {
      var table = $('#tbl-purchases').DataTable();
      table.row($(e).parents('tr')).remove().draw();
      // console.log($(e).data('totalunitcost'));
      // subtract total cost
      total_cost -= parseInt($(e).data('totalunitcost'));
      $('#total_cost').html('Rp. ' + formatRupiah(total_cost));
      $('#total_cost').attr('data-total', total_cost);

      var index = $(e).data('index');
      dataTemp.splice(index, 1);

      toastSuccess('Berhasil menghapus data');
    }

    function updateStock(data) {
      var index = dataTemp.findIndex(x => x.id_product == data.id_product);

      if (index == -1) {
        dataTemp.push({
          'id_product': data.id_product,
          'name_product': data.name_product,
          'price': data.price,
          'quantity': data.quantity,
          'total_unit_cost': data.total_unit_cost,
          'customer': data.customer
        });

        var total_unit_cost_format = formatRupiah('Rp. ' + data.total_unit_cost);

        $('#tbl-purchases').DataTable().row.add([
          data.name_product,
          data.price,
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
          data.name_product,
          data.price,
          dataTemp[index].quantity,
          total_unit_cost_format,
          '<button class="btn btn-danger btn-sm" data-index="' + index + '" data-totalunitcost="' + dataTemp[index]
          .total_unit_cost + '" onclick="deleteStock(this)">Hapus</button>'
        ]).draw();
      }

      total_cost += parseInt(data.total_unit_cost);

      var total_cost_format = formatRupiah(total_cost);

      $('#total_cost').html('Rp. ' + total_cost_format);
      $('#total_cost').attr('data-total', total_cost);

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
      $('#total_cost').attr('data-total', total_cost);

      return total_cost;
    }
  </script>

  <script>
    $(document).ready(function() {
      $("#table-product").dataTable();
      $('#showModalProduct').click(function() {
        $('#modalProduct').modal('show');
      });

      $(document).on('click', '.btn-pilih', function() {
        $('#id_product').val($(this).data('id'));
        $('#name_product').val($(this).data('name'));
        $('#price').val($(this).data('price'));
        $('#price').attr('data-stock', $(this).data('stock'));
        $('#status').val($(this).data('status'));
        $('#quantity').val(0);
        $('#modalProduct').modal('hide')
      });
    });

    $('#quantity').on('keyup', function() {
      var quantity = $(this).val();
      var price = $('#price').val();
      var stock = $('#price').attr('data-stock');

      // parseInt
      quantity = parseInt(quantity);
      price = parseInt(price);

      if (quantity > stock) {
        // alert('Stok tidak mencukupi');
        toastError('Stok tidak mencukupi');
        $(this).val(0);
      } else {
        total();
      }
    });
  </script>

  <script>
    // if #addStock is clicked then add product to table

    $('#addStock').on('click', function(e) {
      loadBtn($(this));
      e.preventDefault();
      var id_product = $('#id_product').val();
      var name_product = $('#name_product').val();
      var price = $('#price').val();
      var quantity = $('#quantity').val();
      var total_unit_cost = $('#total_unit_cost').attr('data-total');
      var customer = $('#customer').select2('data')[0].name;

      if (id_product != '' && name_product != '' && quantity != '' && price != '' && customer != '') {
        var data = {
          id_product: id_product,
          name_product: name_product,
          price: price,
          quantity: quantity,
          total_unit_cost: total_unit_cost,
          customer: customer
        };
        var total_unit_cost_format = formatRupiah('Rp. ' + data['total_unit_cost']);

        updateStock(data);

        if (dataTemp.length == 0) {
          var saveToJSON = dataTempJson([data]);
          ModalCloseChasier

          if (saveToJSON) {
            $('#tbl-purchases').DataTable().row.add([
              name_product,
              price,
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

        $('#id_product').val('');
        $('#name_product').val('');
        $('#price').val('');
        $('#total_unit_cost').html('Rp. 0');
        $('#quantity').val('');

      } else {
        toastWarning('Mohon isi semua form!');

        $(this).html('Add Stock').removeClass('disabled');
      }
      addTotal();
    });
  </script>

  <script>
    $('#btn_uang_pas').on('click', function() {
      var total_cost = $('#total_cost').attr('data-total');
      $('#dibayar').val(total_cost);
      $('#total_dibayar').html('Rp. ' + formatRupiah(total_cost));
      $('#kembali').val(0);
    });

    $('#btn_kosongkan').on('click', function() {
      $('#dibayar').val(0);
      $('#total_dibayar').html('Rp. 0');
      $('#kembali').val(0);
    });

    $('#dibayar').on('keyup', function() {
      var total_cost = $('#total_cost').attr('data-total');
      var dibayar = $(this).val();
      var kembali = dibayar - total_cost;

      $('#total_dibayar').html('Rp. ' + formatRupiah(dibayar));
      $('#kembali').val(kembali);
    });

    $('#btn_proses').on('click', function() {
      var total_cost = $('#total_cost').attr('data-total');
      var dibayar = $('#dibayar').val();
      var kembali = $('#kembali').val();
      var customer = $('#customer').select2('data')[0].name;
      var payment_method = $('select[name="payment_method"]').val();

      if (payment_method == 'cash' && dibayar < total_cost) {
        toastError('Uang yang dibayar kurang!');
      } else if (payment_method == 'debt') {
        $('#confirmationModal').modal('show');
      } else {
        $('#confirmationModal').modal('show');
      }

      // if (dibayar < total_cost) {
      //   toastError('Uang yang dibayar kurang!');
      // } else {
      //   $('#confirmationModal').modal('show');
      // }
    });

    $('#confirmationBtn').on('click', function() {
      var invoice = $('#invoice').val();
      var total_cost = $('#total_cost').attr('data-total');
      var dibayar = $('#dibayar').val();
      var kembali = $('#kembali').val();
      var customer = $('#customer').val();
      var payment_method = $('select[name="payment_method"]').val();
      const due_date = $('#dateDebt').val();

      var data = {
        invoice: invoice,
        total_cost: total_cost,
        paid: dibayar,
        change: kembali,
        customer: customer,
        payment_method: payment_method,
        dataTemp: dataTemp,
        due_date: due_date
      };

      $.ajax({
        url: "{{ route('admin.cashier.store') }}",
        type: "POST",
        data: data,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(data) {
          if (data.success == true) {
            $('#confirmationModal').modal('hide');
            toastSuccess('Berhasil melakukan transaksi!');
            $('#id_transaction').val(data.data.id);
            $('#detailModal').modal('show');
          } else {
            toastError('Gagal menyimpan data!');
          }
        },
        error: function(xhr, status, error) {
          toastError('Gagal menyimpan data!');
        }
      });
    });

    $('#detailBtn').on('click', function() {
      var id_transaction = $('#id_transaction').val();
      window.open("{{ route('admin.cashier.index') }}/" + id_transaction, "_blank");
      $('#detailModal').modal('hide');
      location.reload();
    });
  </script>
  <script>
    $('#showModalCloseChasier').click(function() {
      $.ajax({
        url: "{{ route('admin.pos.close') }}",
        type: "GET",
        success: function(data) {
          console.log(data);
          // if (data.success == true) {
          $('#modalCloseCashier').modal('show');
          $('#modalCloseCashier').on('shown.bs.modal', function() {
            $('#total_transaksi').html(data.total_transaction);
            $('#saldo_kasir').html(data.balance);
            console.log(data.balance);
            $('#saldo_register').html(data.pos_register_balance);
            $('#pendapatan').html(data.total);

          });
          // } else {
          // toastError('Gagal menampilkan data!');
          // }
        },
        error: function(xhr, status, error) {
          toastError('Gagal menampilkan data!');
        }
      });
    });

    $('#submitCloseCashier').on('click', function() {
      $.ajax({
        url: "{{ route('admin.pos.close_cashier') }}",
        type: "GET",
        success: function(data) {
          if (data.success == true) {
            // reload page
            location.reload();
          } else {
            toastError('Gagal melakukan tutup kasir!');
          }
        },
        error: function(xhr, status, error) {
          toastError('Gagal melakukan tutup kasir!');
        }
      });
    });
  </script>
@endsection
