<div class="modal fade" id="editEmploymentModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Employment</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editEmploymentForm" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
          <div class="mb-3">
            <label class="col-form-label" for="editName">Name :</label>
            <input class="form-control" id="editName" name="editName" type="text" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="editBasicSalary">Basic Salary :</label>
            <div class="input-group">
              <span class="input-group-text" id="">Rp.</span>
              <input class="form-control" id="editBasicSalary" name="editBasicSalary" type="text" value
                aria-describedby="" placeholder="Enter ...">
            </div>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="editOther">Other :</label>
            <textarea class="form-control" id="editOther" name="editOther" placeholder="Enter ..."></textarea>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="editDescription">Description :</label>
            <textarea class="form-control" id="editDescription" name="editDescription" placeholder="Enter ..."></textarea>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateEmployment mt-2" type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
