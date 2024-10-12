<!-- Verify Modal content -->
<div class="modal fade" id="addRoleModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Add new role</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addRoleForm" novalidate>
          <div class="form-group mb-2">
            <label for="name">Role Name</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="name" name="name" type="text" placeholder="e.g. pegawai"
              required>
          </div>
          <div class="form-group mb-2">
            <label for="permissions">Permissions</label>
            <select class="form-control select2" id="permissions" name="permissions[]"
              data-placeholder="Select a Permissions" style="width: 100%" multiple="" required>
              @foreach ($permissions as $permission)
                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary addRole mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
