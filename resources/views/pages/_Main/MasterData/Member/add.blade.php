<!-- Verify Modal content -->
<div class="modal fade" id="addMemberModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Add new Member</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="addMemberForm" novalidate>
          <div class="mb-3">
            <label class="col-form-label" for="name">Name :</label>
            <input class="form-control" id="name" name="name" type="text" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="email">Email :</label>
            <input class="form-control" id="email" name="email" type="email" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="phone">Phone :</label>
            <input class="form-control" id="phone" name="phone" type="number" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="address">Address :</label>
            <textarea class="form-control" id="address" name="address" placeholder="Enter ..."></textarea>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary addMember mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
