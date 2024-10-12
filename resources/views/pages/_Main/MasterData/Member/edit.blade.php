<div class="modal fade" id="editMemberModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Member</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editMemberForm" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
          <div class="mb-3">
            <label class="col-form-label" for="editName">Name :</label>
            <input class="form-control" id="editName" name="editName" type="text" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="editEmail">Email :</label>
            <input class="form-control" id="editEmail" name="editEmail" type="email" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="editPhone">Phone :</label>
            <input class="form-control" id="editPhone" name="editPhone" type="number" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="editAddress">Address :</label>
            <textarea class="form-control" id="editAddress" name="editAddress" placeholder="Enter ..."></textarea>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateMember mt-2" type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
