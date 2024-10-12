<div class="modal fade" id="editCategoryModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Kategori</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editCategoryForm" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
          <div class="form-group">
            <label for="editName">Nama Kategori</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="editName" type="text" placeholder="e.g. Category" required>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateCategory mt-2" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
