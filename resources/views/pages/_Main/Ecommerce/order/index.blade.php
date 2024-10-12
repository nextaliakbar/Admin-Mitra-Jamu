@extends('layouts.master')

@section('title')
  @lang('translation.Order')
@endsection

@section('css')
  <link type="text/css" href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" />

  <style>
    .order-track {
      margin-top: 2rem;
      padding: 0 1rem;
      border-top: 1px dashed #2c3e50;
      padding-top: 2.5rem;
      display: flex;
      flex-direction: column;
    }

    .order-track-step {
      display: flex;
      height: auto;
    }

    .order-track-step:last-child {
      overflow: hidden;
      height: auto;
    }

    .order-track-step:last-child .order-track-status span:last-of-type {
      display: none;
    }

    .order-track-status {
      margin-right: 1.5rem;
      position: relative;
    }

    .order-track-status-dot {
      display: block;
      width: 1rem;
      height: 1rem;
      border-radius: 50%;
      background: #f05a00;
    }

    .order-track-status-line {
      display: block;
      margin: 0 auto;
      width: 1px;
      height: 6rem;
    }

    .order-track-text-stat {
      font-size: 1.3rem;
      font-weight: 500;
      margin-bottom: 3px;
    }

    .order-track-text-sub {
      font-size: 1rem;
      font-weight: 300;
    }

    .order-track {
      transition: all 0.3s height 0.3s;
      transform-origin: top center;
    }
  </style>
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Dashboard
    @endslot
    @slot('title')
      @lang('translation.Order_List')
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-sm-4">
              <form action="{{ route('admin.orders.index') }}" method="GET">
                <div class="search-box me-2 d-inline-block mb-2">
                  <div class="position-relative">
                    <input class="form-control" name="search" type="text" placeholder="Search...">
                    <i class="bx bx-search-alt search-icon"></i>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table-nowrap table-check table align-middle">
              <thead class="table-light">
                <tr>
                  <th class="align-middle">Tanggal</th>
                  <th class="align-middle">Order ID</th>
                  <th class="align-middle">No Resi</th>
                  <th class="align-middle">Total</th>
                  <th class="align-middle">Catatan Pembeli</th>
                  <th class="align-middle">Status Pembayaran</th>
                  <th class="align-middle">Status Pesanan</th>
                  <th class="align-middle">Status Pengiriman</th>
                  <th class="align-middle">Action</th>
                </tr>
              </thead>
              <tbody>
                @if ($transactions->count() == 0)
                  <tr>
                    <td class="text-center" colspan="8">
                      <h4 class="text-danger">Tidak ada data</h4>
                    </td>
                  </tr>
                @else
                  @foreach ($transactions as $item)
                    <tr>
                      <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM Y') }}</td>
                      <td>{{ $item->invoice }}</td>
                      <td>
                        @if ($item->receipt_number)
                          <span class="badge bg-primary">
                            {{ $item->receipt_number }}
                          </span>
                        @else
                          <span class="badge bg-danger">
                            Belum ada resi
                          </span>
                        @endif
                      </td>
                      <td>{{ $item->grand_total }}</td>
                      <td>{{ $item->notes }}</td>
                      <td>
                        <span class="badge bg-info">
                          {{ $item->payment_status }}
                        </span>
                      </td>
                      <td>
                        <span class="badge bg-info">
                          {{ $item->status }}
                        </span>
                      </td>
                      <td>
                        <button class="btn btn-primary waves-effect waves-light btn-sm trackOrder"
                          onclick="trackOrder('{{ $item->id }}')">
                          <i class="bx bx-paper-plane font-size-16 me-2 align-middle"></i> Lacak
                        </button>
                      </td>
                      <td>
                        <a class="text-secondary waves-effect waves-light btn-sm addReceipt" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Tambah Resi" onclick="addReceipt('{{ $item->id }}')">
                          <i class="bx bx-receipt font-size-16 me-2 align-middle"></i>
                        </a>

                        <a class="text-primary waves-effect waves-light btn-sm detailOrder" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Detail transaksi" onclick="detailOrder('{{ $item->id }}')">
                          <i class="bx bx-bullseye font-size-16 me-2 align-middle"></i>
                        </a>

                        <a class="text-warning waves-effect waves-light btn-sm updateStatusModal" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Update Status Pembayaran"
                          onclick="updateStatus('{{ $item->id }}')">
                          <i class="bx bx-edit font-size-16 me-2 align-middle"></i>
                        </a>

                        <a class="text-dark waves-effect waves-light btn-sm printInvoice" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Cetak Invoice" onclick="printInvoice('{{ $item->id }}')">
                          <i class="bx bx-printer font-size-16 me-2 align-middle"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-end">
            {{ $transactions->links('vendor.pagination.custom') }}
          </div>
        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->

  <div class="modal fade" id="addReceiptModal" role="dialog" aria-labelledby="addReceiptModalLabel" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="verifyModalContent_title">Tambah Nomor Resi Pengiriman</h5>
          <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" id="addReceiptForm" novalidate>
            @csrf
            <input id="addReceiptId" type="hidden">
            <div class="form-group">
              <label for="receipt">Nomor Resi Pengiriman</label>
              <small class="text-danger">*</small>
              <input class="form-control" id="receipt" name="receipt" type="text">
            </div>
            <div class="d-flex justify-content-end">
              <button class="btn btn-warning submitReceipt mt-2" type="button">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updateStatusModal" role="dialog" aria-labelledby="updateStatusModalLabel"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="verifyModalContent_title">Update Status Pesanan</h5>
          <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" id="updateStatusForm" novalidate>
            @csrf
            <input id="updateStatusId" type="hidden">
            <div class="form-group">
              <label for="editStatus">Status Pemesanan</label>
              <small class="text-danger">*</small>
              <select class="form-control select2" id="editStatus" name="editStatus" style="width: 100%;" required>
                <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                <option value="Sedang Diproses">Sedang Diproses</option>
                <option value="Pengemasan">Pengemasan</option>
                <option value="Pengiriman">Pengiriman</option>
                <option value="Selesai">Selesai</option>
                <option value="Gagal">Gagal</option>
                <option value="Dibatalkan">Dibatalkan</option>
              </select>
            </div>
            <div class="d-flex justify-content-end">
              <button class="btn btn-warning submitUpdateStatus mt-2" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="trackOrderModal" role="dialog" aria-labelledby="trackOrderModalLabel"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <input id="trackOrderId" type="hidden">
        <div class="modal-body" id="data-body">
          <div>
            <h5 id="track_invoice"></h5>
            <h6 id="track_date"></h6>
          </div>
          <div class="order-track" id="orderTrack">
            <div class="order-track-step">
              <div class="order-track-status">
                <span class="order-track-status-dot bg-primary"></span>
                <span class="order-track-status-line bg-primary"></span>
              </div>
              <div class="order-track-text">
                <h6 class="fw-bold mb-1">Order Received</h6>
                <p class="fst-italic mb-0">21 November, 2019</p>
                {{-- <p class="">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis qui vel voluptas</p> --}}
              </div>
            </div>
            <div class="order-track-step">
              <div class="order-track-status">
                <span class="order-track-status-dot bg-primary"></span>
                <span class="order-track-status-line bg-primary"></span>
              </div>
              <div class="order-track-text">
                <h6 class="fw-bold mb-1">Order Received</h6>
                <p class="fst-italic mb-0">21 November, 2019</p>
                <p class="">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis qui vel voluptas</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade orderdetailsModal" id="orderdetailsModal" role="dialog"
    aria-labelledby="orderdetailsModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderdetailsModalLabel">Order Details</h5>
          <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <section id="section-1">
            <h5 class="text-truncate fw-bold font-size-14 mb-3">Detail</h5>
            <div class="d-flex justify-content-between">
              <div class="item">
                <p class="mb-2">No Invoice</p>
                <p class="mb-2">Tanggal Pesanan</p>
                <p class="mb-2">Status Pesanan</p>
                <p class="mb-2">Status Pembayaran</p>
                <p class="mb-2">Metode Pembayaran</p>
              </div>
              <div class="text-end">
                <p class="fw-bold text-primary mb-2" id="invoice">INV/20230421/ECM/8283247822</p>
                <p class="fw-bold text-primary mb-2" id="tanggal_pesanan">26 April 2023</p>
                <p class="fw-bold text-primary mb-2" id="status_pesanan">Sedang Dikirim</p>
                <p class="fw-bold text-primary mb-2" id="status_pembayaran">Sukses</p>
                <p class="fw-bold text-primary mb-2" id="metode_pembayaran">Online Payment</p>
              </div>
            </div>
          </section>
          <hr class="text-muted my-3">
          <section id="section-2">
            <h5 class="text-truncate fw-bold font-size-14 mb-3">Informasi Pengiriman</h5>
            <div class="d-flex justify-content-start">
              <div class="title me-5">
                <p class="mb-2">Kurir</p>
                <p class="mb-2">No Resi</p>
                <p class="mb-2">Alamat</p>
              </div>
              <div class="item">
                <p class="fw-bold text-primary mb-2" id="kurir">POS Indonesia (POS) - Pos Regulerr</p>
                <p class="fw-bold text-primary mb-2" id="no_resi">JT1237123</p>
                <p class="fw-bold text-primary mb-2" id="alamat">Jl. Mastrip 5 No. 10, Sumbersari, Kab. Jember, Jawa
                  Timur, 68121</p>
              </div>
            </div>
          </section>
          <hr class="text-muted my-3">
          <section id="section-3">
            <h5 class="text-truncate fw-bold font-size-14 mb-3">Detail Produk</h5>
            <div id="produk">
              <div class="d-flex justify-content-between">
                <div>
                  <img class="avatar-sm" src="{{ URL::asset('/assets/images/product/img-7.png') }}" alt="">
                </div>
                <div>
                  <h5 class="text-truncate font-size-14" id="product_name">Wireless Headphone (Black)</h5>
                  <p class="text-muted mb-0" id="base_price">Rp 50.000 x 2</p>
                </div>
                <div class="fw-bold text-primary mb-2" id="price">Rp 100.000</div>
              </div>
            </div>
          </section>
          <hr class="text-muted my-3">
          <section id="section-2">
            <h5 class="text-truncate fw-bold font-size-14 mb-3">Rincian Pembayaran</h5>
            <div class="d-flex justify-content-between">
              <div class="title me-5">
                <p class="mb-2">Sub Total</p>
                <p class="mb-2">Ongkos Kirim</p>
                <p class="mb-2">Total Diskon</p>
                <p class="mb-2">Biaya Layanan</p>
                <p class="mb-2">Total Pembayaran</p>
              </div>
              <div class="item">
                <p class="fw-bold text-primary mb-2" id="sub_total">Rp 100.000</p>
                <p class="fw-bold text-primary mb-2" id="ongkos_kirim">Rp 12.000</p>
                <p class="fw-bold text-primary mb-2" id="total_diskon">Rp 20.000</p>
                <p class="fw-bold text-primary mb-2" id="biaya_layanan">Rp 6.000</p>
                <p class="fw-bold text-primary mb-2" id="total_pembayaran">Rp 72.000</p>
              </div>
            </div>
          </section>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-order');
    $('.select2').select2();
  </script>

  <script>
    function printInvoice() {
      window.print();
    }

    function detailOrder(id) {
      $.ajax({
        url: `{{ route('admin.orders.show', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: function(data) {
          if (data.success == true) {
            var transaction = data.data[0];
            console.log(transaction.courier);
            $('#invoice').html(transaction.transaction_invoice);
            $('#tanggal_pesanan').html(transaction.transaction_date);
            $('#status_pesanan').html(transaction.transaction_status);
            $('#status_pembayaran').html(transaction.payment_status);
            $('#metode_pembayaran').html(transaction.payment_method);
            $('#kurir').html(transaction.courier);
            $('#no_resi').html(transaction.receipt_number);
            $('#alamat').html(transaction.customer_address);
            $('#sub_total').html(transaction.total_price);
            $('#ongkos_kirim').html(transaction.courier_cost);
            $('#total_diskon').html(transaction.total_discount);
            $('#biaya_layanan').html(transaction.service_fee);
            $('#total_pembayaran').html(transaction.grand_total);
            var product = transaction.product;
            var html = '';
            $('#produk').html('');

            product.forEach((q) => {
              $('#produk').append(
                `
                <div class="d-flex justify-content-between">
                  <div>
                    <img class="avatar-sm" src="${q.product_thumbnail}" alt="">
                  </div>
                  <div>
                    <h5 class="text-truncate font-size-14" id="product_name">${q.product_name}</h5>
                    <p class="text-muted mb-0" id="base_price">${q.product_price} x ${q.product_quantity}</p>
                  </div>
                  <div class="fw-bold text-primary mb-2" id="price">${q.total_product_price}</div>
                </div>
                `
              )
            })
            $('#orderdetailsModal').modal('show');

          } else {
            toastError(data.message);
          }
        },
        error: function(err) {
          if (err.status == 422) {
            toastError(err.responseJSON.message);
          } else {
            toastError('Terjadi kesalahan, silahkan coba lagi');
          }
        }
      });
    }

    function updateStatus(id) {
      $('#updateStatusModal').modal('show');
      $('#updateStatusId').val(id);

      $('.submitUpdateStatus').click(function(e) {
        e.preventDefault();
        loadBtn($(this));
        $.ajax({
          url: `{{ route('admin.orders.updateStatus', ':id') }}`.replace(':id', id),
          type: 'POST',
          data: new FormData($('#updateStatusForm')[0]),
          contentType: false,
          processData: false,
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          success: function(data) {
            if (data.success == true) {
              $('#updateStatusModal').modal('hide');
              $('#editStatus').val('');
              $('#updateStatusId').val('');
              toastSuccess(data.message);
              setTimeout(() => {
                location.reload();
              }, 1000);
            } else {
              toastError(data.message);
            }
            $('.submitUpdateStatus').html('Save').removeClass('disabled');
          },
          error: function(err) {
            if (err.status == 422) {
              toastError(err.responseJSON.message);
            } else {
              toastError('Something went wrong!');
            }
            $('.submitUpdateStatus').html('Save').removeClass('disabled');
          }
        });
      })
    }

    function addReceipt(id) {
      $('#addReceiptModal').modal('show');
      $('#addReceiptId').val(id);

      $('.submitReceipt').click(function(e) {
        e.preventDefault();
        loadBtn($(this));
        $.ajax({
          url: `{{ route('admin.orders.addReceipt', ':id') }}`.replace(':id', id),
          type: 'POST',
          data: new FormData($('#addReceiptForm')[0]),
          contentType: false,
          processData: false,
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          success: function(data) {
            if (data.success == true) {
              $('#addReceiptModal').modal('hide');
              $('#receipt').val('');
              $('#addReceiptId').val('');
              toastSuccess(data.message);
              setTimeout(() => {
                location.reload();
              }, 1000);

            } else {
              toastError(data.message);

            }
            $('.submitReceipt').html('Save').removeClass('disabled');
          },
          error: function(err) {
            if (err.status == 422) {
              toastError(err.responseJSON.message);
            } else {
              toastError('Something went wrong!');
            }
            $('.submitReceipt').html('Save').removeClass('disabled');
          }
        });
      });
    }

    function trackOrder(id) {
      $('#trackOrderModal').modal('show');
      $('#trackOrderId').val(id);
      // $('#trackOrderModal .modal-body').html('');

      // set loading state
      $('#trackOrderModal #orderTrack').html(`
      <div class="d-flex justify-content-center align-items-center">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    `);

      $.ajax({
        url: `{{ route('admin.orders.tracking', ':id') }}`.replace(':id', id),
        type: 'GET',
        success: function(data) {
          var transaction = data.transaction;
          $('#track_invoice').html(transaction.invoice);
          $('#track_date').html(transaction.date);

          console.log(data.success);
          if (data.success == false) {
            $('#trackOrderModal #orderTrack').html('');

            $('#trackOrderModal #orderTrack').append(`
              <div class="d-flex justify-content-center align-items-center">
                <h5 class="text-danger">${ data.message }</h5>
              </div>
            `);
          } else {
            $('#track_status').html(data.status).addClass('text-warning');
          }

          var data = data.data.rajaongkir;
          if (data.status.code == 200) {
            $('#trackOrderModal #orderTrack').html('');
            var manifest = data.result.manifest;
            var html = '';
            manifest.forEach((item) => {
              html += `
                <div class="order-track-step">
                  <div class="order-track-status">
                    <span class="order-track-status-dot bg-primary"></span>
                    <span class="order-track-status-line bg-primary"></span>
                  </div>
                  <div class="order-track-text">
                    <h6 class="fw-bold mb-1">${item.manifest_description}</h6>
                    <p class="fst-italic mb-0">${item.manifest_date} ${item.manifest_time}</p>
                    <p class="">${item.city_name}</p>
                  </div>
                </div>
              `
            })


            if (data.result.delivery_status.status == 'DELIVERED') {
              var deliveredData = data.result.delivery_status;
              var deliveredHTML = `
                <div class="order-track-step">
                  <div class="order-track-status">
                    <span class="order-track-status-dot bg-primary"></span>
                    <span class="order-track-status-line bg-primary"></span>
                  </div>
                  <div class="order-track-text">
                    <h6 class="fw-bold mb-1">${deliveredData.status}</h6>
                    <p class="fst-italic mb-0">${deliveredData.pod_date} ${deliveredData.pod_time}</p>
                    <p class="">${deliveredData.pod_receiver}</p>
                  </div>
                </div>
              `

              $('#trackOrderModal #orderTrack').append(`
              <div class="d-flex justify-content-center align-items-center mb-5">
                <h5 class="text-success">Pesanan telah sampai</h5>
              </div>
              ${deliveredHTML}
              ${html}
              `);
            } else {
              $('#trackOrderModal #orderTrack').append(`
              <div class="d-flex justify-content-center align-items-center">
                <h5 class="text-danger">Pesanan dalam perjalanan</h5>
              </div>
              ${html}
              `);
            }

          } else if (data.status.code == 400) {
            toastError(data.status.description);
            $('#trackOrderModal #orderTrack').html(`
          <div class="d-flex justify-content-center align-items-center">
            <h5 class="text-danger">${ data.status.description }</h5>
            </div>
            `);
          } else {
            toastError(data.status.description);
            $('#trackOrderModal #orderTrack').html(`
            <div class="d-flex justify-content-center align-items-center">
              <h5 class="text-danger">${ data.status.description }</h5>
            </div>
          `);
          }
          $('.submitReceipt').html('Save').removeClass('disabled');
        },
        error: function(err) {
          if (err.status == 422) {
            toastError(err.responseJSON.message);
          } else {
            toastError('Something went wrong!');
          }
          $('#trackOrderModal #orderTrack').html(`
          <div class="d-flex justify-content-center align-items-center">
            <h5 class="text-danger">Terjadi kesalahan, silahkan coba lagi</h5>
          </div>
        `);
        }
      });

      // on modal close reset
      $('#trackOrderModal').on('hidden.bs.modal', function() {
        $('#track_invoice').html('');
        $('#track_date').html('');
      });
    }
  </script>
@endsection
