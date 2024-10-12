<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="invoice-title">
          <h4 class="float-end font-size-16">Order # 12345</h4>
          <div class="mb-4">
            <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="logo" height="20" />
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <address>
              <strong>Billed To:</strong><br>
              John Smith<br>
              1234 Main<br>
              Apt. 4B<br>
              Springfield, ST 54321
            </address>
          </div>
          <div class="col-sm-6 text-sm-end">
            <address class="mt-sm-0 mt-2">
              <strong>Shipped To:</strong><br>
              Kenny Rigdon<br>
              1234 Main<br>
              Apt. 4B<br>
              Springfield, ST 54321
            </address>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 mt-3">
            <address>
              <strong>Payment Method:</strong><br>
              Visa ending **** 4242<br>
              jsmith@email.com
            </address>
          </div>
          <div class="col-sm-6 text-sm-end mt-3">
            <address>
              <strong>Order Date:</strong><br>
              October 16, 2019<br><br>
            </address>
          </div>
        </div>
        <div class="mt-3 py-2">
          <h3 class="font-size-15 fw-bold">Order summary</h3>
        </div>
        <div class="table-responsive">
          <table class="table-nowrap table">
            <thead>
              <tr>
                <th style="width: 70px;">No.</th>
                <th>Item</th>
                <th class="text-end">Price</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>01</td>
                <td>Skote - Admin Dashboard Template</td>
                <td class="text-end">$499.00</td>
              </tr>

              <tr>
                <td>02</td>
                <td>Skote - Landing Template</td>
                <td class="text-end">$399.00</td>
              </tr>

              <tr>
                <td>03</td>
                <td>Veltrix - Admin Dashboard Template</td>
                <td class="text-end">$499.00</td>
              </tr>
              <tr>
                <td class="text-end" colspan="2">Sub Total</td>
                <td class="text-end">$1397.00</td>
              </tr>
              <tr>
                <td class="border-0 text-end" colspan="2">
                  <strong>Shipping</strong>
                </td>
                <td class="border-0 text-end">$13.00</td>
              </tr>
              <tr>
                <td class="border-0 text-end" colspan="2">
                  <strong>Total</strong>
                </td>
                <td class="border-0 text-end">
                  <h4 class="m-0">$1410.00</h4>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="d-print-none">
          <div class="float-end">
            <a class="btn btn-success waves-effect waves-light me-1" href="javascript:window.print()"><i
                class="fa fa-print"></i></a>
            <a class="btn btn-primary w-md waves-effect waves-light" href="#">Send</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
