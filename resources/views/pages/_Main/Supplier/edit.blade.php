<!-- Verify Modal content -->
<div class="modal fade" id="editSupplierModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Supplier</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editSupplierForm" novalidate>
          <input id="editId" name="editId" type="hidden">
          <div class="form-group">
            <label for="editName">Supplier Name</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="editName" name="editName" type="text"
              placeholder="e.g. PT Bangun Sejahtera" required>
          </div>

          <div class="form-group">
            <label for="editEmail">Email</label>
            <input class="form-control" id="editEmail" name="editEmail" type="email"
              placeholder="e.g. info@bangunsejahtera.com" required>
          </div>

          <div class="form-group">
            <label for="editAddress">Address</label>
            <textarea class="form-control" id="editAddress" name="editAddress" cols="30" rows="5"></textarea>
          </div>

          <div class="form-group">
            <label for="editStatus">Status</label>
            <select class="form-control select2" id="editStatus" name="editStatus" style="width: 100%;">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <div class="form-group">
            <label for="editType">Type</label>
            <select class="form-control select2" id="editType" name="editType" style="width: 100%;">
              <option value="internal">Internal</option>
              <option value="individual">Individual</option>
              <option value="company">Company</option>
            </select>
          </div>

          <div class="d-flex justify-content-end">
            <button class="btn btn-primary updateSupplier mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
