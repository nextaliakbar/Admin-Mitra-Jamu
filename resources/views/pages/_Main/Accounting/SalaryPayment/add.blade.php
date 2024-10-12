@extends('layouts.master')

@section('title')
  @lang('translation.Dashboards')
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
     Pembayaran Gaji
    @endslot
    @slot('title')
      Tambah
    @endslot
  @endcomponent
  <form class="needs-validation" novalidate>

    <div class="wrapper">
      <p class="h3 mb-3">Tambah Pembayaran Gaji</p>
      <div class="row">
        <div class="col-12">
          <div class="alert alert-primary" role="alert">
            Anda dapat melakukan pembayaran gaji karyawan dengan mengisi form di bawah ini.
            <br />
            <b>Pembayaran gaji karyawan hanya bisa dilakukan satu kali setiap karyawan dalam satu bulan.</b>
          </div>
          <div class="card">
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label" for="date">Date</label>
                      <input class="form-control" id="date" type="text" value="{{ date('Y-m-d H:i:s') }}"
                        readonly>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label" for="invoice">Invoice</label>
                      <input class="form-control" id="invoice" name="invoice" type="text" value="{{ $invoice }}"
                        readonly>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label" for="user_id">User</label>
                      <input class="form-control" id="user_id" name="user_id" type="text"
                        value="{{ Auth::user()->name }}" readonly>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-8">
                    <div class="mb-3">
                      <label class="form-label" for="employment">Name</label>
                      <div class="input-group">
                        <input class="form-control" id="id_employee" name="id_employee" type="hidden" readonly>
                        <input class="form-control" id="name" name="name" type="text" readonly
                          placeholder="Employee">
                        <span class="input-group-text showModal"><i class='bx bxs-user-rectangle'
                            style="cursor: pointer;"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label" for="employment">Employment</label>
                      <input class="form-control" id="employment" name="employment" type="text"
                        placeholder="Employment" disabled>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="phone">Phone</label>
                      <input class="form-control" id="phone" type="text" placeholder="Phone">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="last_paids">Last Paid</label>
                      <input class="form-control" id="last_paids" name="last_paids" type="text" disabled>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label" for="Basic Salary">Basic Salary</label>
                      <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input class="form-control" id="basic_salary" name="basic_salary" type="text"
                          placeholder="Basic Salary" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label" for="salary_reduction">Salary Reduction</label>
                      <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input class="form-control" id="salary_reduction" name="salary_reduction" type="text"
                          value="0">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label" for="net_salary">Net Salary</label>
                      <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input class="form-control" id="net_salary" name="net_salary" type="text"
                          placeholder="Net Salary" readonly>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!-- end card body -->
          </div>
          <!-- end card -->
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="text-center">
                  <a class="btn btn-secondary" href="{{ route('admin.salary-payment.index') }}">
                    <i class="mdi mdi-arrow-left"></i>
                    Kembali
                  </a>
                  <button class="btn btn-primary" id="save" type="submit">
                    <i class="mdi mdi-content-save"></i>
                    Simpan
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <div class="modal fade bs-example-modal-xl" id="modalEmployee" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Employee Data</h5>
          <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table">
                <table class="table-bordered dt-responsive nowrap w-100 table" id="example-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Employment</th>
                      <th>Departement</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($employees as $employee)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->employment->name }}</td>
                        <td>{{ $employee->department }}</td>
                        <td>
                          @if ($employee->status == 1)
                            <span class="badge bg-success">Aktif</span>
                          @else
                            <span class="badge bg-danger">Resign</span>
                          @endif
                        </td>
                        <td>
                          <a class="btn btn-warning btn-sm btn-pilih" data-id="{{ $employee->id }}"
                            data-phone="{{ $employee->phone }}" data-name="{{ $employee->name }}"
                            data-employment="{{ $employee->employment->name }}"
                            data-basic_salary="{{ $employee->employment->basic_salary }}" href="#">
                            Submit</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
@endsection

@section('script')
  <!-- Required datatable js -->
  <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

  <script src="{{ URL::asset('js/script.js') }}"></script>
  <!-- Datatable init -->
  <script>
    dataTableInit('#tbl-employment');
    $('.select2').select2();
  </script>
  <script>
    $(document).ready(function() {
      $('#example-table').dataTable();
      $('.showModal').click(function() {
        $('#modalEmployee').modal('show');
      });
      $(document).on('click', '.btn-pilih', function() {
        $('#id_employee').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#phone').val($(this).data('phone'));
        $('#employment').val($(this).data('employment'));
        $('#basic_salary').val($(this).data('basic_salary'));
        $('#net_salary').val($(this).data('basic_salary'));
        getDetailEmployee($(this).data('id'));
        $('#modalEmployee').modal('hide');
      });

      function getDetailEmployee(id) {
        let url = `{{ route('admin.salary-payment.get_detail', ':id') }}`;
        url = url.replace(':id', id);
        $.ajax({
          type: "GET",
          url: url,
          dataType: "json",
          success: function(response) {
            $('#last_paids').val(response);
          }
        });
      }

      $('#salary_reduction').keyup(function() {
        const basic_salary = $('#basic_salary').val();
        if (basic_salary - $(this).val() <= 0) {
          Swal.fire("error", "Salary deduction to much", "error");
          $(this).val(0);
          return;
        }
        $('#net_salary').val(basic_salary - $(this).val());
      });

      // // if submit button is clicked then console
      // $("#submitProduct").click(function(e) {
      //   e.preventDefault();
      //   console.log('submit clicked');
      //   var data = {}
      //   data['name'] = $('#name').val();
      //   data['phone'] = $('#phone').val();
      //   data['employment'] = $('#employment').val();
      //   data['basic_salary'] = $('#basic_salary').val();
      //   data['net_salary'] = $('#net_salary').val();
      //   data['salary_reduction'] = $('#salary_reduction').val();

      //   $.ajax({
      //     url: "{{ route('admin.salary-payment.store') }}",
      //     type: "POST",
      //     data: data,
      //     headers: {
      //       'X-CSRF-TOKEN': '{{ csrf_token() }}'
      //     },
      //     success: function(response) {
      //       if (response.success) {
      //         var message = response.message;
      //         document.cookie = "successMessage=" + message;
      //         window.location.replace("{{ route('admin.salary-payment.index') }}");
      //       }
      //     },
      //     error: function(response) {
      //       if (response.responseJSON.errors) {
      //         var errors = response.responseJSON.message;
      //         toastError(errors);
      //       } else {
      //         toastError('Terjadi kesalahan');
      //       }
      //     }
      //   })
      // });

      $('#save').click(function(e) {
        e.preventDefault();
        loadBtn('#save');
        if ($('#name').val() == "") {
          alert('Form stil null');
          return;
        }
        let url = `{{ route('admin.salary-payment.store') }}`;
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id_employee: $('#id_employee').val(),
            salary_reduction: $('#salary_reduction').val(),
            invoice: $('#invoice').val(),
          },
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          dataType: "json",
          success: function(response) {
            if (response.success) {
              var message = response.message;
              document.cookie = "successMessage=" + message;
              window.location.replace("{{ route('admin.salary-payment.index') }}");

              $('#save').html('Simpan').removeClass('disabled');
            } else {
              toastWarning(response.message);
              $('#save').html('Simpan').removeClass('disabled');
            }
          },
          error: function(response) {
            if (response.responseJSON.errors) {
              var errors = response.responseJSON.message;
              toastError(errors);
            } else {
              toastError('Terjadi kesalahan');
            }
            $('#save').html('Simpan').removeClass('disabled');
          }
        });
      });
    })
  </script>
@endsection
