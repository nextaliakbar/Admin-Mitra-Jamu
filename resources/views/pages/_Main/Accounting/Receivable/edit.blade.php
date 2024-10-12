<div class="modal fade" id="editModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Bayar Piutang</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editPaidAmount" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
          <input id="hasPaid" type="text" hidden>
          <span id="remainingAmountWillBe" class="mb-2"></span>
          <div class="form-group">
            <label for="paidAmount">Paid Amount</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="paidAmount" autofocus autocomplete="off" type="text" inputmode="numeric" required>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateVoucher mt-2" type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
