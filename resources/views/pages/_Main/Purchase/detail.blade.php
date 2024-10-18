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
      Detail Pemesanan Stok
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h4>Detail Pemesanan Stok</h4>
          </div>
        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->

  <form class="needs-validation" id="addStockForm" novalidate>
    @foreach($purchase_lists as $purchase_list)
    <div class="row">
      <div class="col-lg-3 col-12">
        <div class="card border-primary border">
          <div class="card-body">

            <div class="form-group mb-3">
              <label for="invoice">Invoice</label>
              <input class="form-control" id="invoice" value="{{$purchase_list->invoice}}" name="invoice" @disabled(true)>
            </div>

            <div class="form-group mb-3">
              <label for="name">Date</label>
              <input class="form-control" id="date" name="date" type="text" value="{{$purchase_list->date}}" @disabled(true)>
            </div>

            <div class="form-group mb-3">
              <label for="supplier">Supplier</label>
              <input class="form-control " id="supplier" value="{{$purchase_list->supplier_name}}" name="supplier" @disabled(true)>
            </div>

            <div class="form-group mb-3">
              <label for="paymentNote">Catatan Pembelian</label>
              <textarea class="form-control" id="paymentNote" name="paymentNote" rows="3" @disabled(true)>{{$purchase_list->note}}</textarea>
            </div>
{{--            <div class="form-group mb-3">--}}
{{--              <label for="product">Product</label>--}}
{{--              <select class="form-control select2-product" id="product" name="product" style="width: 100%;">--}}
{{--              </select>--}}
{{--            </div>--}}

          </div>
        </div>
      </div>

      <div class="col-lg-3 col-12">
        <div class="card border-primary border">
          <div class="card-body">
            <div class="form-group mb-3">
              <label for="paymentStatus">Status Pembayaran</label>
              <input class="form-control" id="paymentStatus" name="paymentStatus" value="{{$purchase_list->payment_status}}" @disabled(true)>
            </div>
            <div class="form-group mb-3">
              <label for="paymentMethod">Metode Pembayaran</label>
              <input class="form-control" id="paymentMethod" name="paymentMethod" value="{{$purchase_list->payment_method}}" @disabled(true)>
            </div>
            <div class="form-group mb-3">
              <label for="paymentDate" id="paymentDateLabel">Tanggal Pembayaran</label>
              <input class="form-control" id="paymentDate" name="paymentDate" type="text"
                     value="{{$purchase_list->payment_date}}" @disabled(true)>
            </div>
{{--            <div class="form-group mb-3">--}}
{{--              <label for="quantity">Quantity</label>--}}
{{--              <input class="form-control" id="quantity" name="quantity" type="number">--}}
{{--            </div>--}}

{{--            <div class="form-group mb-3">--}}
{{--              <label for="unit_cost">Harga Beli Satuan</label>--}}
{{--              <input class="form-control" id="unit_cost" name="unit_cost" type="number">--}}
{{--            </div>--}}

{{--            <div class="form-group mb-3">--}}
{{--              <label class="text-white">&nbsp;</label>--}}
{{--              <button class="form-control btn btn-primary" id="addStock" name="addStock" style="width: 100%;">--}}
{{--                Add Product--}}
{{--              </button>--}}
{{--            </div>--}}

          </div>
        </div>
      </div>

      <div class="col-lg-6 col-12">
        <div class="card border-primary border">
          <div class="card-body">
            <h4 class="text-center">Belanja</h4>
            <h1 class="text-primary text-center" id="total_unit_cost">Rp. {{$purchase_list->unit_cost}}</h1>
          </div>
        </div>

        <div class="card border-primary border">
          <div class="card-body">
            <h4 class="text-center">Total Belanja</h4>
            <h1 class="text-primary text-center" id="total_cost">Rp. {{$purchase_list->total_cost}}</h1>
          </div>
        </div>
      </div>
    </div>
    @endforeach
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
          </tr>
        </thead>
        <tbody>
        @foreach($purchase_lists as $purchase_list)
          <tr>
            <td>{{$purchase_list->product_id}}</td>
            <td>{{$purchase_list->product_name}}</td>
            <td>{{$purchase_list->unit_cost}}</td>
            <td>{{$purchase_list->quantity}}</td>
            <td>{{$purchase_list->total_cost}}</td>
          </tr>
        @endforeach
        </tbody>
      </table>

      {{-- button simpan dan kembali --}}
      <div class="row">
        <div class="col-1">
          <div class="text-center">
            <a href="{{route('admin.purchases.index')}}" class="btn btn-secondary">
              Kembali
            </a>
{{--            <button class="btn btn-secondary" id="cancelPurchase" name="cancelPurchase">--}}
{{--              Kembali--}}
{{--            </button>--}}
          </div>
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
