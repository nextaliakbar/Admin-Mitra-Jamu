<div class="modal fade" id="editVoucherModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Employment</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editVoucherForm" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
            <div class="mb-3">
              <label for="" class="col-form-label">Employment :</label>
              <input type="text" class="form-control" id="nama-jabatan"  placeholder="Enter ...">
            </div>
            <div class="mb-3">
              <label for="" class="col-form-label">Basic Salary :</label>
              <div class="input-group">
                <span class="input-group-text" id="">Rp.</span>
                <input type="text" class="form-control" name="" value aria-describedby=""
                  placeholder="Enter ...">
              </div>
            </div>
            <div class="mb-3">
              <label for="" class="col-form-label">Others :</label>
              <textarea class="form-control" id="lain-lain"  placeholder="Enter ..."></textarea>
            </div>
            <div class="mb-3">
              <label for="" class="col-form-label">Description :</label>
              <textarea class="form-control" id="deskripsi"  placeholder="Enter ..."></textarea>
            </div>
            <div class="d-flex justify-content-end">
              <button class="btn btn-warning addVoucher mt-2" type="submit">
                <i class="bx bx-save font-size-16 me-2 align-middle"></i> Save
              </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
