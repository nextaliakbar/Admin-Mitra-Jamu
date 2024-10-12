  <div class="modal fade"
       id="deleteItemModal"
       role="dialog"
       aria-labelledby="deleteItemModalLabel"
       aria-hidden="true"
       tabindex="-1">
      <div class="modal-dialog modal-dialog-centered"
           role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title"
                      id="deleteItemTitle"></h5>
                  <button type="button"
                          class="btn-close"
                          data-bs-dismiss="modal"
                          aria-label="Close"></button>
              </div>
              <input id="deleteId"
                     type="hidden">
              <div class="modal-body"
                   id="deleteItemBody">
                  <p></p>
              </div>
              <div class="modal-footer"
                   id="deleteItemFooter">
                  <button type="button"
                          class="btn btn-secondary"
                          data-bs-dismiss="modal">Batal</button>
                  <button type="button"
                          class="btn btn-primary deleteItemConfirmBtn">Hapus</button>
              </div>
          </div>
      </div>
  </div>
