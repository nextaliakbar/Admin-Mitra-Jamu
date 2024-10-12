<div class="modal fade" id="editRoleModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Role</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editRoleForm" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
          <div class="form-group mb-2">
            <label for="editName">Role Name</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="editName" type="text" placeholder="e.g. pegawai" required>
          </div>
          <div class="form-group mb-2">
            <label for="editPermissions">Permissions</label>
            <select class="form-control select2" id="editPermissions" name="permissions[]"
              data-placeholder="Select a Permissions" style="width: 100%" multiple="" required>
              @foreach ($permissions as $permission)
                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateRole mt-2" type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
