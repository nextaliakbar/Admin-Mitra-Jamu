<!-- Verify Modal content -->
<div class="modal fade" id="addSupplierModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Add Supplier</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="addSupplierForm" novalidate>
          <div class="form-group">
            <label for="name">Supplier Name</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="name" name="name" type="text"
              placeholder="e.g. PT Bangun Sejahtera" required>
          </div>

          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input class="form-control" id="phone" name="phone" type="number" placeholder="e.g. 6282123456789"
              required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" id="email" name="email" type="email"
              placeholder="e.g. info@bangunsejahtera.com" required>
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" cols="30" rows="5"></textarea>
          </div>

          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control select2" id="status" name="status" style="width: 100%;">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control select2" id="type" name="type" style="width: 100%;">
              <option value="internal">Internal</option>
              <option value="individual">Individual</option>
              <option value="company">Company</option>
            </select>
          </div>

          <div class="d-flex justify-content-end">
            <button class="btn btn-primary addSupplier mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
