@extends('layouts.master')

@section('title')
  @lang('translation.Dashboards')
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Products
    @endslot
    @slot('title')
      add
    @endslot
  @endcomponent
  <form class="needs-validation" novalidate>

    <div class="wrapper">
      <p class="h3 mb-3">Tambah Produk</p>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5 class="mb-0">Nama Produk</h5>
                  <p class="text-muted mb-2">Nama produk min. 40 karakter dengan memasukkan merek, jenis
                    produk, warna, bahan, atau tipe.</p>
                  <p class="text-muted mb-2">Disarankan untuk tidak menggunakan huruf kapital berlebih,
                    memasukkan lebih dari 1 merek, dan kata-kata promosi.</p>
                  <p class="text-muted mb-2">Nama tidak bisa diubah setelah produk terjual, ya.</p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <label class="form-label" for="productName">
                    Nama Produk <span class="text-danger">*</span>
                  </label>
                  <input class="form-control" id="productName" type="text" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5 class="mb-0">Thumbnail Produk</h5>
                  <p class="text-muted mb-2">
                    Format gambar .jpg .jpeg .png dan ukuran minimum 300 x 300px (Untuk gambar optimal gunakan ukuran
                    minimum
                    700 x 700 px).
                  </p>
                  <p class="text-muted mb-2">
                    Thumbnail produk akan menjadi gambar utama produkmu di halaman produk.
                  </p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label for="productThumnail">
                      Thumbnail Produk <span class="text-danger">*</span>
                    </label>
                    <input id="pathThumbnail" name="path" type="hidden">
                    <input class="filepond" id="thumbnail-pond" name="media" type="file" />
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5 class="mb-0">Deskripsi Produk</h5>
                  <p class="text-muted mb-2">Pastikan deskripsi produk memuat penjelasan detail terkait produkmu agar
                    pembeli
                    mudah mengerti dan menemukan produkmu.</p>
                  <p class="text-muted mb-2">Disarankan untuk <strong>tidak memasukkan</strong> info nomor HP, e-mail,
                    dsb. ke
                    dalam deskripsi produk untuk melindungi data pribadimu.</p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <label class="form-label" for="productDesc">
                    Deskripsi Produk <span class="text-danger">*</span>
                  </label>
                  <div id="productDesc" name="productDesc" rows="5"></div>
                  {{-- <textarea class="form-control" id="productDesc" required rows="3"></textarea> --}}
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5 class="mb-0">Foto Produk</h5>
                  <p class="text-muted mb-2">
                    Format gambar .jpg .jpeg .png dan ukuran minimum 300 x 300px (Untuk gambar optimal gunakan ukuran
                    minimum
                    700 x 700 px).
                  </p>
                  <p class="text-muted mb-2">
                    Foto produk akan digunakan untuk menampilkan produk pada halaman <strong>produk</strong> dan
                    <strong>detail
                      produk</strong>.
                  </p>
                  <p class="text-muted mb-2">
                    Pilih foto produk atau tarik dan letakkan hingga 5 foto sekaligus di sini. Upload min. 3 foto yang
                    menarik
                    dan <strong>berbeda satu sama lain</strong> untuk menarik perhatian pembeli.
                  </p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label for="productStock">
                      Foto Produk <span class="text-danger">*</span>
                    </label>
                    <input id="pathProductImage" name="path" type="hidden">
                    <input class="filepond" id="productImage-pond" name="media[]" type="file" multiple />
                  </div>
                </div>
              </div>
            </div>

            <hr class="divider">

            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5 class="mb-0">Harga Jual Produk</h5>
                  <p class="text-muted mb-2">
                    Tambahkan harga jual produk untuk memudahkan pembeli memilih produk yang sesuai dengan kebutuhannya.
                  </p>
                </div>
              </div>
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label for="productPrice">
                      Harga Jual Produk <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <div class="input-group-text">Rp</div>
                      <input class="form-control" id="productPrice" type="number" value="0">
                    </div>
                    <div class="d-flex mt-3">
                      <s>
                        <h5 class="text-danger" id="coretPrice"></h5>
                      </s>
                      &nbsp;
                      &nbsp;
                      <h5 id="actualPrice"></h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label for="productDiscount">Diskon Harga</label>
                    <div class="input-group">
                      <input class="form-control" id="productDiscount" type="number" value="0">
                      <div class="input-group-text">%</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5 class="mb-0">Berat Produk</h5>
                  <p class="text-muted mb-2">
                    Tambahkan berat produk dalam satuan gram untuk memberikan informasi kepada pembeli mengenai berat
                    produk
                    yang tersedia.
                  </p>
                  <p class="text-muted mb-2">
                    Contoh: 1000 gram
                  </p>
                  <p class="text-muted mb-2">
                    Berat produk juga akan digunakan untuk menghitung <strong>ongkos kirim.</strong>
                  </p>
                </div>
              </div>
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label for="productWeight">
                      Berat Produk <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <input class="form-control text-start" id="productWeight" type="number" placeholder="1000">
                      <div class="input-group-text">Gram</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label for="productDimension">Dimensi Produk</label>
                    <div class="input-group">
                      <input class="form-control text-start" id="productDimension" type="text"
                        placeholder="100 x 100 x 20">
                      <div class="input-group-text">cm</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5>Kategori Produk</h5>
                  <p class="text-muted mb-2">Pilih kategori produk sesuai dengan produk yang kamu jual.</p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label>
                      Kategori Produk <span class="text-danger">*</span>
                    </label>
                    <select class="form-select select2" id="productCategory" required>
                      @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5>Label Produk</h5>
                  <p class="text-muted mb-2">Pilih label produk sesuai dengan kondisi produk yang kamu jual.</p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label>Label Produk</label>
                    <select class="form-select select2" id="productLabel" required>
                      @foreach ($labels as $label)
                        <option value="{{ $label->id }}">{{ $label->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5>Tags</h5>
                  <p class="text-muted mb-2">Masukkan tag produk untuk meningkatkan visibilitas produk anda di internet.
                  </p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label>Tags</label>
                    <select class="form-select select2-tags" id="productTags"
                      placeholder="Masukkan tag produk"></select>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5>Metode Pengiriman</h5>
                  <p class="text-muted mb-2">Pilih metode pengiriman untuk barang ini. Anda dapat memilih lebih dari 1
                    metode pengiriman</p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label>
                      Metode Pengiriman <span class="text-danger">*</span>
                    </label>
                    <select class="form-select select2-shipments" id="shipmentMethod">
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5>Skema Pembayaran</h5>
                  <p>
                    Pilih metode pembayaran yang tersedia untuk pembeli. Anda dapat memilih lebih dari 1 metode
                    pembayaran.
                  </p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label>
                      Skema Pembayaran <span class="text-danger">*</span>
                    </label>
                    <select class="form-select select2-payments" id="paymentMethod">
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5>Preorder?</h5>
                  <p class="text-muted mb-2">Apakah produk ini pre-order?</p>
                  <div class="square-switch mb-2">
                    <input id="isPreorder" type="checkbox" switch="none">
                    <label data-on-label="On" data-off-label="Off" for="isPreorder"></label>
                  </div>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <div id="preorderDate">
                      <label>Durasi</label>
                      <div class="input-group">
                        <input class="form-control" id="preorderDuration" type="number">
                        <div class="input-group-text">Hari</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5>Status Produk</h5>
                  <p class="text-muted mb-2">Status produk menentukan visibilitas produk anda di e-commerce</p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label>
                      Status Produk <span class="text-danger">*</span>
                    </label>
                    <p class="text-muted mb-2">Status produk menentukan visibilitas produk anda di e-commerce</p>
                    <select class="form-select select2 select2-status" id="productStatus"
                      placeholder="Pilih status produk">
                    </select>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <span class="text-danger">*</span>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="text-center">
                  <a class="btn btn-secondary" href="{{ route('admin.products.index') }}">
                    <i class="mdi mdi-arrow-left"></i>
                    Kembali
                  </a>
                  <button class="btn btn-primary" id="submitProduct" type="submit">
                    <i class="mdi mdi-content-save"></i>
                    Simpan
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('css')
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
    rel="stylesheet" />

  <style>
    .item-type-variant {
      border: 1px solid #556ee6;
      color: #556ee6;
      border-radius: 0.5rem;
      padding: 0.3rem;
      margin-bottom: 0.5rem;
      margin-right: 0.5rem;
      cursor: pointer;
    }

    .btn-type-variant-item {
      border: 1px solid #556ee6;
      color: #556ee6;
      border-radius: 20px;
      padding: 0.1rem 0.3rem;
      font-size: 0.8rem;
      background-color: transparent;
    }

    .btn-type-variant-item:hover {
      background-color: #556ee6;
      color: #fff;
    }

    .card-variant-items {
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      padding: 0.5rem;
      margin-bottom: 0.5rem;
    }

    .card-variant-items hr {
      margin-top: 0.5rem;
    }

    .item-variant {
      border: 1px solid #ced4da;
      border-radius: 0.5rem;
      padding: 0.3rem;
      margin-bottom: 0.5rem;
      margin-right: 0.5rem;
      cursor: pointer;
    }

    .title-variant-item {
      font-size: 1rem;
      font-weight: 600;
      margin-top: 0.5rem;
    }

    .add-variant-item {
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      color: #556ee6;
    }

    .add-variant-item:hover {
      color: #485ec4;
    }

    .btn-variant-item {
      border: 1px solid #ced4da;
      border-radius: 20px;
      padding: 0.1rem 0.3rem;
      font-size: 0.8rem;
      background-color: transparent;
    }

    .btn-variant-item:hover {
      background-color: #ced4da;
    }

    .select2-container {
      z-index: 999 !important;
    }

    .wrapper {
      padding: 0 5%;
    }

    /* if media query is mobile or smartphone, then padding = 0 */
    @media only screen and (max-width: 600px) {
      .wrapper {
        padding: 0;
      }
    }
  </style>
@endsection

@section('script')

  <script>
    $('.select2').select2();
    $('.select2-shipments').select2({
      placeholder: 'Pilih metode pengiriman',
      multiple: true,
      data: [{
          id: 'expedition',
          text: 'Jasa Pengiriman Ekspedisi'
        },
        {
          id: 'pickup',
          text: 'Ambil di Toko'
        }
      ],
    });
    $('.select2-payments').select2({
      placeholder: 'Pilih metode pembayaran',
      multiple: true,
      data: [{
          id: 'transfer',
          text: 'Transfer Bank / Virtual Account (VA)'
        },
        {
          id: 'cash',
          text: 'Tunai / Cash'
        },
        {
          id: 'qris',
          text: 'QRIS'
        }
      ],
    });
    $('.select2-status').select2({
      placeholder: 'Pilih status produk',
      data: [{
          id: true,
          text: 'Active'
        },
        {
          id: false,
          text: 'Draft'
        }
      ],
    });
    $('.select2-tags').select2({
      placeholder: 'Ketik dan pilih tag produk',
      multiple: true,
      tags: true,
      tokenSeparators: [','],
      createTag: function(params) {
        var term = $.trim(params.term);

        if (term === '') {
          return null;
        }

        return {
          id: term,
          text: term,
          newTag: true // add additional parameters
        }
      },
      templateResult: function(data) {
        var $result = $("<span></span>");
        $result.text(data.text);
        if (data.newTag) {
          $result.append(" <em>(new)</em>");
        }
        return $result;
      },
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#preorderDate').hide();
    });
  </script>
  <!-- form tinymce -->
  <script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
  <!-- include FilePond library -->
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
  <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js">
  </script>
  <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
  <script src="{{ URL::asset('js/script.js') }}"></script>
  <script>
    FilePond.registerPlugin(
      FilePondPluginImagePreview,
      FilePondPluginFileValidateType
    );

    const thumbnail = document.querySelector('#thumbnail-pond');
    const productImage = document.querySelector('#productImage-pond');
    const variantItemImage = document.querySelector('#variantItemImage-pond');

    const thumbnailPond = FilePond.create(thumbnail, {
      acceptedFileTypes: "image/*",
      allowImagePreview: true,
      imagePreviewHeight: 300,
      acceptedFileTypes: ['image/*'],
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

    thumbnailPond.on("processfile", (error, file) => {
      if (error) {
        console.log("Oh no");
        return;
      }

      const data = JSON.parse(file.serverId);
      document.getElementById("pathThumbnail").value = data.path;
    });

    thumbnailPond.on("removefile", (error, file) => {
      if (error) {
        console.log("Oh no");
        return;
      }

      const data = JSON.parse(file.serverId);
      console.log(data);
      document.getElementById("pathThumbnail").value = "";
    });


    const productImagePond = FilePond.create(productImage, {
      allowImagePreview: true,
      imagePreviewHeight: 300,
      allowMultiple: true,
      acceptedFileTypes: ['image/*'],
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
          onload: (response) => {
            const data = JSON.parse(response);

            var currentData = document.getElementById("pathProductImage").value
            console.log("currentData", currentData)
            dataParse = JSON.parse(currentData)
            var index = dataParse.indexOf(`${data.path}`);

            if (index > -1) { // check if the index exists in the array
              dataParse.splice(index, 1); // remove the item
            }
            document.getElementById("pathProductImage").value = JSON.stringify(dataParse);
          },
        },
      },
    });

    productImagePond.on("processfile", (error, file) => {
      if (error) {
        console.log("Oh no");
        return;
      }

      const data = JSON.parse(file.serverId);
      var currentData = document.getElementById("pathProductImage").value

      if (currentData == "") {
        currentData = []
        currentData.push(data.path)
      } else {
        currentData = JSON.parse(currentData)
        currentData.push(data.path)
      }
      document.getElementById("pathProductImage").value = JSON.stringify(currentData);
    });

    // get response ajax revert


    // get response after revert
    productImagePond.on("removefile", (error, file) => {
      if (error) {
        console.log("Oh no");
        return;
      }
    });
  </script>

  <script>
    const productDescription = document.querySelector('#productDesc');

    // product description tinymce init
    tinymce.init({
      selector: '#productDesc',
      height: 300,
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | bold italic backcolor | \ alignleft aligncenter alignright alignjustify | \ bullist numlist outdent indent | removeformat | help',
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
  </script>

  <script>
    // if isPreorder checkbox is checked then console
    $('#isPreorder').change(function() {
      if ($(this).is(':checked')) {
        $('#preorderDate').show();
      } else {
        $('#preorderDate').hide();
      }
    });

    // #productPrice input on keyup then write to #actualPrice


    // #productDiscount input on keyup then write to #discountPrice and actualPrice / discountPrice * 100
    $('#productPrice').keyup(function() {
      if ($('#productDiscount').val() == '' || $('#productDiscount').val() == 0) {
        $('#actualPrice').html('Rp ' + $(this).val());
        $('#coretPrice').hide();
      } else {
        $('#coretPrice').show();
        $('#coretPrice').html('Rp ' + $(this).val());
        $('#actualPrice').html('Rp ' + ($(this).val() - $('#productDiscount').val() / 100 * $(this).val()));
      }
    });

    $('#productDiscount').keyup(async function() {
      if ($(this).val() == '' || $(this).val() == 0) {
        $('#coretPrice').hide();
        $('#actualPrice').html('Rp ' + $('#productPrice').val());
      } else {
        $('#coretPrice').show();
        $('#coretPrice').html('Rp ' + $('#productPrice').val());
        $('#actualPrice').html('Rp ' + ($('#productPrice').val() - $(this).val() / 100 * $('#productPrice').val()));
      }
    });
  </script>

  <script>
    // if submit button is clicked then console
    $("#submitProduct").click(function(e) {
      e.preventDefault();
      console.log('submit clicked');
      var data = {}
      data['product_label_id'] = $('#productLabel').val();
      data['product_category_id'] = $('#productCategory').val();
      data['name'] = $('#productName').val();
      data['slug'] = $('#productName').val().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
      data['description'] = tinymce.get('productDesc').getContent();
      data['tags'] = $('#productTags').val();
      data['thumbnail'] = $('#pathThumbnail').val();
      data['images'] = $('#pathProductImage').val();
      data['price'] = $('#productPrice').val();
      data['discount'] = $('#productDiscount').val();
      data['weight'] = $('#productWeight').val();
      data['dimension'] = $('#productDimension').val();
      data['is_preorder'] = $('#isPreorder').is(':checked');
      data['preorder_duration'] = $('#preorderDuration').val();
      data['is_active'] = $('#productStatus').val();
      data['shipment'] = $('#shipmentMethod').val();
      data['payment'] = $('#paymentMethod').val();

      $.ajax({
        url: "{{ route('admin.products.store') }}",
        type: "POST",
        data: data,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
          if (response.success) {
            var message = response.message;
            document.cookie = "successMessage=" + message;
            window.location.replace("{{ route('admin.products.index') }}");
          }
        },
        error: function(response) {
          console.log(response, 'error');
          if (response.responseJSON.errors) {
            var errors = response.responseJSON.message;
            toastError(errors);
          } else {
            toastError('Terjadi kesalahan');
          }
        }
      })
    });
  </script>
@endsection

@section('script-bottom')
@endsection
