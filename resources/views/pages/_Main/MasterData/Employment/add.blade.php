<!-- Verify Modal content -->
<div class="modal fade" id="addEmploymentModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Add new Employment</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="addEmploymentForm" novalidate>
          <div class="mb-3">
            <label class="col-form-label" for="name">Name :</label>
            <input class="form-control" id="name" name="name" type="text" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="basic_salary">Basic Salary :</label>
            <div class="input-group">
              <span class="input-group-text">Rp.</span>
              <input class="form-control" id="basic_salary" name="basic_salary" type="number" value aria-describedby=""
                placeholder="Enter ...">
            </div>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="other">Other :</label>
            <textarea class="form-control" id="other" name="other" placeholder="Enter ..."></textarea>
          </div>
          <div class="mb-3">
            <label class="col-form-label" for="description">Description :</label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter ..."></textarea>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary addEmployment mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
