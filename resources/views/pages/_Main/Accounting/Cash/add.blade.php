<!-- Verify Modal content -->
<div class="modal fade" id="addCashModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Tambah Kas</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="addCashForm" novalidate>
          {{-- <div class="col-xl-8 col-md-12">
            <div class="card-body">
              <div class="form-group mb-0">
                <label for="productStock">
                  Foto Produk <span class="text-danger">*</span>
                </label>
                <input id="pathProductImage" name="path" type="hidden">
                <input class="filepond" id="productImage-pond" name="media[]" type="file" multiple />
              </div>
            </div>
          </div> --}}
          <div class="mb-3">
            <label class="col-form-label" for="invoice">Invoice :</label>
            <div class="form-group">
              <input type="text" name="invoice" id="invoice" value="" readonly class="form-control">
            </div>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="datepicker2">Tanggal :</label>
            <div class="input-group" id="datepicker2">
              <input type="text" class="form-control" name="date" placeholder="dd M, yyyy" data-date-format="dd M, yyyy"
                data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true">
              <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
            </div><!-- input-group -->
          </div>
          <div class="mb-3">
            <label for="tipe" class="col-form-label">Tipe:</label>
            <select class="form-select" name="tipe" id="tipe">
              <option disabled selected>Pilih</option>
              <option value="pendapatan">Pemasukan</option>
              <option value="pengeluaran">Pengeluaran</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">Pemasukan :</label>
            <input type="text" name="pemasukan" id="pemasukan" value="0" disabled class="form-control">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">Pengeluaran :</label>
            <input type="text" name="pengeluaran" id="pengeluaran" value="0" disabled class="form-control">
          </div>
          <div class="row kotak-jenis-pengeluaran" style="display: none">
            <div class="mb-3">
              <div class="form-group">
                <label for="jenis_pengeluaran">Jenis Pengeluaran</label>
                <select name="jenis_pengeluaran" id="jenis_pengeluaran" class="form-control">
                  <option disabled selected>Pilih</option>
                  <option value="kas akhir">Kas Akhir</option>
                  <option value="pengeluaran lain">Pengeluaran Lain</option>
                  <option value="biaya">Biaya</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row kotak-jenis-pemasukan" style="display: none">
            <div class="mb-3">
              <div class="form-group">
                <label for="jenis_pemasukan">Jenis Pemasukan</label>
                <select name="jenis_pemasukan" id="jenis_pemasukan" class="form-control">
                  <option disabled selected>Pilih</option>
                  <option value="kas awal">Kas Awal</option>
                  <option value="pemasukan lain">Pemasukan Lain</option>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="keterangan">Keterangan :</label>
            <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Enter ..."></textarea>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary addCash mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
