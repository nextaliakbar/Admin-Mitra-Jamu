<!-- Verify Modal content -->
<div class="modal fade" id="addLabelModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Add new user</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="addLabelForm" novalidate>
          <div class="form-group">
            <label for="name">Categroy Name</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="name" name="name" type="text" placeholder="e.g. Offer" required>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary addLabel mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
