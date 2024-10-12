@extends('layouts.master')

@section('title')
  @lang('translation.Products')
@endsection

@section('css')
  <!-- ION Slider -->
  <link type="text/css" href="{{ URL::asset('/assets/libs/ion-rangeslider/ion-rangeslider.min.css') }}" rel="stylesheet" />

  <style>
    .avatar-sm {
      height: auto !important;
      width: auto !important;
    }

    .avatar-title {
      padding: 10px !important;
    }

    .round-circle {
      border-radius: 10px !important;
    }
  </style>
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Ecommerce
    @endslot
    @slot('title')
      Products
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Filter</h4>

          <div>
            <h5 class="font-size-14 mb-3">Categories</h5>
            <ul class="list-unstyled product-list">
              <li><a href="#"><i class="mdi mdi-chevron-right me-1"></i> T-shirts</a></li>
              <li><a href="#"><i class="mdi mdi-chevron-right me-1"></i> Shirts</a></li>
              <li><a href="#"><i class="mdi mdi-chevron-right me-1"></i> Jeans</a></li>
              <li><a href="#"><i class="mdi mdi-chevron-right me-1"></i> Jackets</a></li>
            </ul>
          </div>

          <div>
            <h5 class="font-size-14 mb-3">Labels</h5>
            <ul class="list-unstyled product-list">
              <li><a href="#"><i class="mdi mdi-chevron-right me-1"></i> New</a></li>
              <li><a href="#"><i class="mdi mdi-chevron-right me-1"></i> Best</a></li>
              <li><a href="#"><i class="mdi mdi-chevron-right me-1"></i> Diskon</a></li>
            </ul>
          </div>
          {{-- <div class="mt-4 pt-3">
            <h5 class="font-size-14 mb-3">Price</h5>
            <input id="pricerange" type="text">
          </div> --}}

          {{-- <div class="mt-4 pt-3">
            <h5 class="font-size-14 mb-3">Discount</h5>
            <div class="form-check mt-2">
              <input class="form-check-input" id="productdiscountCheck1" type="checkbox">
              <label class="form-check-label" for="productdiscountCheck1">
                Less than 10%
              </label>
            </div>

            <div class="form-check mt-2">
              <input class="form-check-input" id="productdiscountCheck2" type="checkbox">
              <label class="form-check-label" for="productdiscountCheck2">
                10% or more
              </label>
            </div>

            <div class="form-check mt-2">
              <input class="form-check-input" id="productdiscountCheck3" type="checkbox" checked>
              <label class="form-check-label" for="productdiscountCheck3">
                20% or more
              </label>
            </div>

            <div class="form-check mt-2">
              <input class="form-check-input" id="productdiscountCheck4" type="checkbox">
              <label class="form-check-label" for="productdiscountCheck4">
                30% or more
              </label>
            </div>

            <div class="form-check mt-2">
              <input class="form-check-input" id="productdiscountCheck5" type="checkbox">
              <label class="form-check-label" for="productdiscountCheck5">
                40% or more
              </label>
            </div>

            <div class="form-check mt-2">
              <input class="form-check-input" id="productdiscountCheck6" type="checkbox">
              <label class="form-check-label" for="productdiscountCheck6">
                50% or more
              </label>
            </div>

          </div> --}}

          <div class="mt-4 pt-3">
            <h5 class="font-size-14 mb-3">Customer Rating</h5>
            <div>
              <div class="form-check mt-2">
                <input class="form-check-input" id="productratingCheck1" type="checkbox">
                <label class="form-check-label" for="productratingCheck1">
                  4 <i class="bx bxs-star text-warning"></i> & Above
                </label>
              </div>
              <div class="form-check mt-2">
                <input class="form-check-input" id="productratingCheck2" type="checkbox">
                <label class="form-check-label" for="productratingCheck2">
                  3 <i class="bx bxs-star text-warning"></i> & Above
                </label>
              </div>
              <div class="form-check mt-2">
                <input class="form-check-input" id="productratingCheck3" type="checkbox">
                <label class="form-check-label" for="productratingCheck3">
                  2 <i class="bx bxs-star text-warning"></i> & Above
                </label>
              </div>

              <div class="form-check mt-2">
                <input class="form-check-input" id="productratingCheck4" type="checkbox">
                <label class="form-check-label" for="productratingCheck4">
                  1 <i class="bx bxs-star text-warning"></i>
                </label>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-lg-9">

      <div class="row mb-3">
        <div class="col-xl-4 col-sm-6">
          <div class="mt-2">
            <h5>Clothes</h5>
          </div>
        </div>
        <div class="col-lg-8 col-sm-6">
          <form class="mt-sm-0 float-sm-end d-sm-flex align-items-center mt-4">
            <div class="search-box me-2">
              <div class="position-relative">
                <input class="form-control border-0" type="text" placeholder="Search...">
                <i class="bx bx-search-alt search-icon"></i>
              </div>
            </div>
            <ul class="nav nav-pills product-view-nav justify-content-end mt-sm-0 mt-3">
              <li class="nav-item">
                <a class="nav-link active" href="#"><i class="bx bx-grid-alt"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="bx bx-list-ul"></i></a>
              </li>
            </ul>

          </form>
        </div>
      </div>
      <div class="row">
        @foreach ($products as $item)
          <div class="col-xl-4 col-sm-6">
            <div class="card">
              <div class="card-body">
                <div class="product-img position-relative">
                  <div class="avatar-sm product-ribbon">
                    <span class="avatar-title round-circle bg-primary">
                      {{ $item->label_name }}
                    </span>
                  </div>
                  <img class="img-fluid d-block mx-auto" src="{{ $item->thumbnail }}" alt="">
                </div>
                <div class="mt-4 text-center">
                  <h5 class="text-truncate"><a class="text-dark" href="#">{{ $item->name }}</a></h5>
                  <p>{{ $item->category_name }}</p>
                  <p class="text-muted">
                    @if ($item->rating_avg == 1)
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                    @elseif($item->rating_avg == 2)
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                    @elseif($item->rating_avg == 3)
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                    @elseif($item->rating_avg == 4)
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star"></i>
                    @elseif($item->rating_avg == 5)
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star text-warning"></i>
                      <i class="bx bxs-star"></i>
                    @elseif ($item->rating_avg == 0 || $item->rating_avg == null)
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                      <i class="bx bxs-star"></i>
                    @endif
                    ({{ $item->review_count }})
                  </p>
                  @if ($item->discount == 0)
                    <h5 class="my-0"><b>${{ $item->price }}</b></h5>
                  @else
                    <h5 class="my-0"><span class="text-muted me-2"><del>{{ moneyFormat($item->price) }}</del></span>
                      <b>{{ moneyFormat($item->price - ($item->price * $item->discount) / 100) }}</b>
                    </h5>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <!-- end row -->

      <div class="row">
        <div class="col-lg-12">
          {{-- pagination from laravel --}}
          {{ $products->links('vendor.pagination.custom') }}
          {{-- <ul class="pagination pagination-rounded justify-content-center mt-3 mb-4 pb-1">
            <li class="page-item disabled">
              <a class="page-link" href="#"><i class="mdi mdi-chevron-left"></i></a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item active">
              <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">4</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">5</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#"><i class="mdi mdi-chevron-right"></i></a>
            </li>
          </ul> --}}
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->
@endsection
@section('script')
  <!-- Ion Range Slider-->
  <script src="{{ URL::asset('/assets/libs/ion-rangeslider/ion-rangeslider.min.js') }}"></script>

  <!-- init js -->
  <script src="{{ URL::asset('/assets/js/pages/product-filter-range.init.js') }}"></script>
@endsection
