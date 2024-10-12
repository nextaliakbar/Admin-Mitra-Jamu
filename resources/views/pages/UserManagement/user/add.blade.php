<!-- Verify Modal content -->
<div class="modal fade" id="addUserModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Tambah Pengguna Baru</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="addUserForm" novalidate>
          <div class="form-group">
            <label for="name">Nama</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="name" name="name" type="text" placeholder="contoh: Ahmad Yusuf"
              required>
          </div>
          <div class="form-group mb-2">
            <label for="email">Email</label>
            <small class="text-danger">* (default password : <b>password</b>)</small>
            <input class="form-control" id="email" name="email" type="email"
              placeholder="contoh: example@mitrajamur.com" required>
          </div>
          <div class="form-group mb-2">
            <label for="role">Role</label>
            <small class="text-danger">*</small>
            <select class="form-control select2" id="role" name="role" style="width: 100%;" required>
              @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary addUser mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
