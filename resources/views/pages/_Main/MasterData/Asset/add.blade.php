<!-- Verify Modal content -->
<div class="modal fade" id="addAssetModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Add new Asset</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="addAssetForm" novalidate>
          <div class="mb-3">
            <label class="col-form-label" for="name">Name :</label>
            <input class="form-control" id="name" name="name" type="text" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="date">Tanggal :</label>
            <div class="input-group" id="datepicker2">
              <input class="form-control" name="date" data-date-format="dd M, yyyy"
                data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" type="text"
                placeholder="dd M, yyyy">
              <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
            </div><!-- input-group -->
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="unit">Jumlah Unit :</label>
            <input class="form-control" id="unit" name="unit" type="number" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="type">Tipe Asset:</label>
            <select class="form-select" id="type" name="type">
              <option value="">Pilih</option>
              <option value="fixed">Asset Tetap</option>
              <option value="current">Asset Lancar</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="useful_life">Umur Manfaat (Bulan) :</label>
            <input class="form-control" id="UsefulLife" name="useful_life" type="number" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="assets_price">Harga Perolehan :</label>
            <div class="input-group">
              <span class="input-group-text">Rp.</span>
              <input class="form-control" id="AssetPrice" name="assets_price" type="number" value aria-describedby=""
                placeholder="Enter ...">
            </div>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="monthly_depreciation">Akumulasi Penyusutan (Bulan) :</label>
            <div class="input-group">
              <span class="input-group-text">Rp.</span>
              <input class="form-control" id="MonthlyDepreciation" name="monthly_depreciation" type="number" value
                aria-describedby="" placeholder="Enter ..." readonly>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary addAsset mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
