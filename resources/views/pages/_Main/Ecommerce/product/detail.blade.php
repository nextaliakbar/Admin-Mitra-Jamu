@extends('layouts.master')

@section('title')
  @lang('translation.Product_Detail')
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Ecommerce
    @endslot
    @slot('title')
      Product Detail
    @endslot
    @slot('back')
      {{ route('admin.products.index') }}
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-6">
              <div class="product-detai-imgs">
                <div class="row">
                  <div class="col-md-2 col-sm-3 col-4">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                      @foreach ($productImages as $item)
                        @if ($loop->first)
                          <a class="nav-link active" id="product-{{ $loop->iteration }}-tab" data-bs-toggle="pill"
                            href="#product-{{ $loop->iteration }}" role="tab"
                            aria-controls="product-{{ $loop->iteration }}" aria-selected="true">
                            <img class="img-fluid d-block mx-auto rounded" src="{{ $product->thumbnail }}" alt="">
                          </a>
                          @continue
                        @endif
                        <a class="nav-link" id="product-{{ $loop->iteration }}-tab" data-bs-toggle="pill"
                          href="#product-{{ $loop->iteration }}" role="tab"
                          aria-controls="product-{{ $loop->iteration }}" aria-selected="true">
                          <img class="img-fluid d-block mx-auto rounded" src="{{ $item->image }}" alt="">
                        </a>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-md-7 offset-md-1 col-sm-9 col-8">
                    <div class="tab-content" id="v-pills-tabContent">
                      @foreach ($productImages as $item)
                        @if ($loop->first)
                          <div class="tab-pane fade show active" id="product-{{ $loop->iteration }}" role="tabpanel"
                            aria-labelledby="product-{{ $loop->iteration }}-tab">
                            <div>
                              <img class="img-fluid d-block mx-auto" src="{{ $product->thumbnail }}" alt="">
                            </div>
                          </div>
                          @continue
                        @endif

                        <div class="tab-pane fade" id="product-{{ $loop->iteration }}" role="tabpanel"
                          aria-labelledby="product-{{ $loop->iteration }}-tab">
                          <div>
                            <img class="img-fluid d-block mx-auto" src="{{ $item->image }}" alt="">
                          </div>
                        </div>
                      @endforeach
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6">
              <div class="mt-xl-3 mt-4">
                <a class="text-primary" href="javascript: void(0);">{{ $product->category_name }}</a>
                <h4 class="mt-1 mb-3">{{ $product->name }}</h4>

                <p class="text-muted float-start me-3">
                  @if ($product->rating_avg >= 1)
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                  @elseif($product->rating_avg >= 2)
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                  @elseif($product->rating_avg >= 3)
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                  @elseif($product->rating_avg >= 4)
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star"></span>
                  @elseif($product->rating_avg <= 5 && $product->rating_avg >= 4)
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                    <span class="bx bxs-star text-warning"></span>
                  @else
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                    <span class="bx bxs-star"></span>
                  @endif
                </p>
                <p class="text-muted mb-4">( {{ $product->review_count }} Customers Review )</p>

                @if ($product->discount > 0)
                  <h6 class="text-success text-uppercase">{{ $product->discount }} % Off</h6>
                  <h5 class="mb-4">Price : <span
                      class="text-muted me-2"><del>{{ moneyFormat($product->price) }}</del></span>
                    <b>{{ moneyFormat($product->price_after_discount) }}</b>
                  </h5>
                @else
                  <h5 class="mb-4">Price : <b>{{ moneyFormat($product->price) }}</b></h5>
                @endif
                <p class="text-muted mb-4">{!! $product->description !!}</p>
                <div class="row mb-3">
                  {{-- <div class="col-md-6">
                    <div>
                      <p class="text-muted"><i class="bx bx-unlink font-size-16 text-primary me-1 align-middle"></i>
                        Wireless</p>
                      <p class="text-muted"><i
                          class="bx bx-shape-triangle font-size-16 text-primary me-1 align-middle"></i> Wireless Range :
                        10m</p>
                      <p class="text-muted"><i class="bx bx-battery font-size-16 text-primary me-1 align-middle"></i>
                        Battery life : 6hrs</p>
                    </div>
                  </div> --}}
                  {{-- <div class="col-md-6">
                    <div>
                      <p class="text-muted"><i class="bx bx-user-voice font-size-16 text-primary me-1 align-middle"></i>
                        Bass</p>
                      <p class="text-muted"><i class="bx bx-cog font-size-16 text-primary me-1 align-middle"></i>
                        Warranty : 1 Year</p>
                    </div>
                  </div> --}}
                </div>

                {{-- <div class="product-color">
                  <h5 class="font-size-15">Color :</h5>
                  <a class="active" href="javascript: void(0);">
                    <div class="product-color-item rounded border">
                      <img class="avatar-md" src="assets/images/product/img-7.png" alt="">
                    </div>
                    <p>Black</p>
                  </a>
                  <a href="javascript: void(0);">
                    <div class="product-color-item rounded border">
                      <img class="avatar-md" src="assets/images/product/img-7.png" alt="">
                    </div>
                    <p>Blue</p>
                  </a>
                  <a href="javascript: void(0);">
                    <div class="product-color-item rounded border">
                      <img class="avatar-md" src="assets/images/product/img-7.png" alt="">
                    </div>
                    <p>Gray</p>
                  </a>
                </div> --}}
              </div>
            </div>
          </div>
          <!-- end row -->

          <div class="mt-5">
            <h5 class="mb-3">Specifications :</h5>

            <div class="table-responsive">
              <table class="table-bordered mb-0 table">
                <tbody>
                  <tr>
                    <th style="width: 400px;" scope="row">SKU</th>
                    <td>{{ $product->sku }}</td>
                  </tr>
                  <tr>
                    <th style="width: 400px;" scope="row">Category</th>
                    <td>{{ $product->category_name }}</td>
                  </tr>
                  <tr>
                    <th style="width: 400px;" scope="row">Stok</th>
                    <td>{{ $product->stock }}</td>
                  </tr>
                  <tr>
                    <th style="width: 400px;" scope="row">Dimensi</th>
                    <td>{{ $product->dimension }}</td>
                  </tr>
                  <tr>
                    <th style="width: 400px;" scope="row">Berat</th>
                    <td>{{ $product->weight }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- end Specifications -->

          <div class="mt-5">
            <h5>Reviews :</h5>

            @if ($reviews->count() == 0)
              <p class="text-muted">Belum ada review</p>
            @endif

            @foreach ($reviews as $item)
              <div class="d-flex border-bottom py-3">
                <div class="me-3 flex-shrink-0">
                  <img class="avatar-xs rounded-circle" src="{{ $item->customer_avatar }}" alt="img" />
                </div>

                <div class="flex-grow-1">
                  <h5 class="font-size-15 mb-1">{{ $item->customer_name }}</h5>
                  <p class="text-muted">{{ $item->review }}</p>
                  <div class="text-muted font-size-12"><i class="far fa-calendar-alt text-primary me-1"></i>
                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>

        </div>
      </div>
      <!-- end card -->
    </div>
  </div>
  <!-- end row -->

  <div class="row mt-3">
    <div class="col-lg-12">
      <div>
        <h5 class="mb-3">Recent product :</h5>

        <div class="row">
          @foreach ($relatedProducts as $item)
            <div class="col-xl-4 col-sm-6">
              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <img class="img-fluid d-block mx-auto" src="{{ $item->thumbnail }}" alt="img" />
                    </div>
                    <div class="col-md-8">
                      <div class="text-md-start pt-md-0 pt-3 text-center">
                        <h5 class="text-truncate"><a class="text-dark"
                            href="javascript: void(0);">{{ $item->name }}</a>
                        </h5>
                        <p class="text-muted mb-4">
                          @if ($product->rating_avg >= 1)
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                          @elseif($product->rating_avg >= 2)
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                          @elseif($product->rating_avg >= 3)
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                          @elseif($product->rating_avg >= 4)
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star"></span>
                          @elseif($product->rating_avg <= 5 && $product->rating_avg >= 4)
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                            <span class="bx bxs-star text-warning"></span>
                          @else
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                            <span class="bx bxs-star"></span>
                          @endif
                        </p>
                        @if ($product->discount > 0)
                          <h6 class="text-success text-uppercase">{{ $product->discount }} % Off</h6>
                          <h5 class="my-0"><span
                              class="text-muted me-2"><del>{{ moneyFormat($product->price) }}</del></span>
                            <b>{{ moneyFormat($product->price_after_discount) }}</b>
                          </h5>
                        @else
                          <h5 class="my-0"><b>{{ moneyFormat($product->price) }}</b></h5>
                        @endif
                        {{-- <h5 class="my-0"><span class="text-muted me-2"><del>$240</del></span> <b>$225</b></h5> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          {{-- <div class="col-xl-4 col-sm-6">
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-md-4">
                    <img class="img-fluid d-block mx-auto" src="assets/images/product/img-4.png" alt="">
                  </div>
                  <div class="col-md-8">
                    <div class="text-md-start pt-md-0 pt-3 text-center">
                      <h5 class="text-truncate"><a class="text-dark" href="javascript: void(0);">Phone patterned
                          cases</a></h5>
                      <p class="text-muted mb-4">
                        <i class="bx bxs-star text-warning"></i>
                        <i class="bx bxs-star text-warning"></i>
                        <i class="bx bxs-star text-warning"></i>
                        <i class="bx bxs-star text-warning"></i>
                        <i class="bx bxs-star"></i>
                      </p>
                      <h5 class="my-0"><span class="text-muted me-2"><del>$150</del></span> <b>$145</b></h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6">
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-md-4">
                    <img class="img-fluid d-block mx-auto" src="assets/images/product/img-6.png" alt="">
                  </div>
                  <div class="col-md-8">
                    <div class="text-md-start pt-md-0 pt-3 text-center">

                      <h5 class="text-truncate"><a class="text-dark" href="javascript: void(0);">Phone Dark Patterned
                          cases</a></h5>
                      <p class="text-muted mb-4">
                        <i class="bx bxs-star text-warning"></i>
                        <i class="bx bxs-star text-warning"></i>
                        <i class="bx bxs-star text-warning"></i>
                        <i class="bx bxs-star text-warning"></i>
                        <i class="bx bxs-star"></i>
                      </p>
                      <h5 class="my-0"><span class="text-muted me-2"><del>$138</del></span> <b>$135</b></h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> --}}
        </div>
        <!-- end row -->
      </div>
    </div>
  </div>
  <!-- end row -->
@endsection
