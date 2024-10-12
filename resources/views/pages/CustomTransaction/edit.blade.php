<div class="modal fade" id="editCustomTransactionModal" role="dialog" aria-labelledby="verifyModalContent"
  aria-hidden="true" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Jumlah Penjualan</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editCustomTransactionForm" novalidate>
          @csrf
          @method('PUT')
          <input id="editId" type="text" hidden>
          <div class="form-group">
            <label for="editQuantity">Jumlah</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="editQuantity" type="number" required>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateCustomTransaction mt-2" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
