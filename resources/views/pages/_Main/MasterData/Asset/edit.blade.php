<div class="modal fade" id="editAssetModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Asset</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editAssetForm" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
          <div class="mb-3">
            <label class="col-form-label" for="name">Name :</label>
            <input class="form-control" id="editName" name="name" type="text" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="date">Tanggal :</label>
            <div class="input-group" >
              <input type="text" id="editDate" class="form-control" name="date" placeholder="dd M, yyyy" data-date-format="dd M, yyyy"
                data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true">
              <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
            </div><!-- input-group -->
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="unit">Jumlah Unit :</label>
            <input class="form-control" id="editUnit" name="unit" type="number" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label for="type" class="col-form-label">Tipe Asset:</label>
            <select class="form-select" name="type" id="editType">
              <option value="">Pilih</option>
              <option value="fixed">Asset Tetap</option>
              <option value="current">Asset Lancar</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="useful_life">Umur Manfaat (Bulan) :</label>
            <input class="form-control" id="editUsefulLife" name="useful_life" type="number" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="assets_price">Harga Perolehan :</label>
            <div class="input-group">
              <span class="input-group-text">Rp.</span>
              <input class="form-control" id="editAssetPrice" name="assets_price" type="number" value aria-describedby=""
                placeholder="Enter ...">
            </div>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="monthly_depreciation">Akumulasi Penyusutan (Bulan) :</label>
            <div class="input-group">
              <span class="input-group-text">Rp.</span>
              <input class="form-control" id="editMonthlyDepreciation" name="monthly_depreciation" type="number" value aria-describedby=""
                placeholder="Enter ...">
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateAsset mt-2" type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
