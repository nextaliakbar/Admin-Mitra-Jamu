<!-- Verify Modal content -->
<div class="modal fade" id="addEmployeeModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Add new Employee</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="addEmployeeForm" novalidate>
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
            <label class="col-form-label" for="name">Name :</label>
            <input class="form-control" id="" name="name" type="text" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label for="email" class="col-form-label">Email :</label>
            <input type="Email" class="form-control" name="email" id="" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">Phone :</label>
            <input type="number" class="form-control" name="phone" id="" placeholder="Enter ...">
          </div>
          <div class="mb-3">
            <label for="employment_id" class="col-form-label">Employment :</label>
            <select class="form-select" name="employment_id" id="" required>
              <option value="">Select</option>
              @foreach ($employments as $employment)
              <option value="{{ $employment->id }}">{{ $employment->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="department" class="col-form-label">Departement:</label>
            <select class="form-select" name="department" id="">
              <option value="">Select</option>
              <option value="Produksi">Produksi</option>
              <option value="Gudang">Gudang</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">Address :</label>
            <textarea class="form-control" name="address" id="" placeholder="Enter ..."></textarea>
          </div>
          <div class="mb-3">
            <label for="status" class="col-form-label">Status:</label>
            <select class="form-select" name="status" id="">
              <option value="">Select</option>
              <option value="1">Aktif</option>
              <option value="2">Resign</option>
            </select>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary addEmployee mt-2" type="submit">
              <i class="bx bx-save font-size-16 me-2 align-middle"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
