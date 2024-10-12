<div class="modal fade" id="editUserModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Data Pengguna</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editUserForm" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
          <div class="form-group">
            <label for="editName">Nama</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="editName" type="text" placeholder="e.g. Ahmad Yusuf" required>
          </div>
          <div class="form-group">
            <label for="editEmail">Email</label>
            <small class="text-danger">* (default password : <b>password</b>)</small>
            <input class="form-control" id="editEmail" type="email" placeholder="e.g. example@mitrajamur.com"
              required>
          </div>
          <div class="form-group">
            <label for="editRole">Role</label>
            <small class="text-danger">*</small>
            <select class="form-control select2" id="editRole" style="width: 100%;" required>
              @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateUser mt-2" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
