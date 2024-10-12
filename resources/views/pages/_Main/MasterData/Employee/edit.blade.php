<div class="modal fade" id="editEmployeeModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Employment</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editEmployeeForm" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
          {{-- <div class="col-xl-8 col-md-12">
              <div class="card-body">
                <div class="form-group mb-0">
                  <label for="productStock">
                    Foto Produk <span class="text-danger">*</span>
                  </label>
                  <input id="pathProductImage" name="path" type="hidden">
                  <input class="filepond" id="productImage-pond" name="media[]" type="file" multiple />
                </div>
              </div>
            </div> --}}
          <div class="mb-3">
            <label class="col-form-label" for="editName">Name :</label>
            <input class="form-control" id="editName" name="editName" type="text" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label for="editEmail" class="col-form-label">Email :</label>
            <input type="Email" class="form-control" name="editEmail" id="editEmail" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label for="editPhone" class="col-form-label">Phone :</label>
            <input type="number" class="form-control" name="editPhone" id="editPhone" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label for="editEmployement" class="col-form-label">Employment :</label>
            <select class="form-select" name="editEmployement" id="editEmployement" required>
              <option value="">Select</option>
              @foreach ($employments as $employment)
              <option value="{{ $employment->id }}">{{ $employment->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="editDepartment" class="col-form-label">Departement:</label>
            <select class="form-select" name="editDepartment" id="editDepartment">
              <option value="">Select</option>
              <option value="Produksi">Produksi</option>
              <option value="Gudang">Gudang</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editAddress" class="col-form-label">Address :</label>
            <textarea class="form-control" name="editAddress" id="editAddress" placeholder="Enter ..."></textarea>
          </div>
          <div class="mb-3">
            <label for="editStatus" class="col-form-label">Status:</label>
            <select class="form-select" name="editStatus" id="editStatus">
              <option value="">Select</option>
              <option value="1">Aktif</option>
              <option value="2">Resign</option>
            </select>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateEmployee mt-2" type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
