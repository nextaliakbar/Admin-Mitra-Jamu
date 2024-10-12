@extends('layouts.master')

@section('title')
    @lang('translation.Debts')
@endsection

@section('css')
    <link type="text/css"
          href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}"
          rel="stylesheet" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            @lang('translation.Debt')
        @endslot
    @endcomponent
    {{-- <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">@lang('translation.Debts')</h4>
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="row mb-4">
                                <label for=""
                                       class="col-sm-4 col-form-label">Start Date</label>
                                <div class="col-sm-8">
                                    <div class="input-group"
                                         id="datepicker2">
                                        <input type="text"
                                               class="form-control"
                                               name=""
                                               placeholder="dd M, yyyy"
                                               data-date-format="dd M, yyyy"
                                               data-date-container='#datepicker2'
                                               data-provide="datepicker"
                                               data-date-autoclose="true">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div><!-- input-group -->
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for=""
                                       class="col-sm-4 col-form-label">End Date</label>
                                <div class="col-sm-8">
                                    <div class="input-group"
                                         id="datepicker2">
                                        <input type="text"
                                               class="form-control"
                                               name=""
                                               placeholder="dd M, yyyy"
                                               data-date-format="dd M, yyyy"
                                               data-date-container='#datepicker2'
                                               data-provide="datepicker"
                                               data-date-autoclose="true">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div><!-- input-group -->
                                </div>
                            </div>
                            <div>
                                <button type="submit"
                                        class="btn btn-success w-md"><i
                                       class="bx bx-search font-size-16 me-2 align-middle"></i>Filter</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form>
                            <div class="row mb-4">
                                <label for=""
                                       class="col-lg-6 col-form-label">
                                    <h5>Amount of Debt</h5>
                                </label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control-lg"
                                               name=""
                                               value="Rp. 12.000.000,00"
                                               @disabled(true)>
                                    </div><!-- input-group -->
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for=""
                                       class="col-lg-6 col-form-label">
                                    <h5>Amount of Debt Paid</h5>
                                </label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control-lg"
                                               name=""
                                               value="Rp. 12.000.000,00"
                                               @disabled(true)>
                                    </div><!-- input-group -->
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for=""
                                       class="col-lg-6 col-form-label">
                                    <h5>Amount of Remaining Debt</h5>
                                </label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control-lg"
                                               name=""
                                               value="Rp. 12.000.000,00"
                                               @disabled(true)>
                                    </div><!-- input-group -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4>@lang('translation.Debts')</h4>
                        {{-- <div class="col-md-12">
                            <button class="btn btn-success w-md"
                                    data-filter="lunas"><i class="bx bx-check-square font-size-16 me-2 align-middle"></i>
                                Paid Off</button>
                            <button class="btn btn-warning w-md"
                                    data-filter="belum_lunas"><i
                                   class="bx bx-window-close font-size-16 me-2 align-middle"></i>
                                Not yet Paid Off</button>
                            <button class="btn btn-danger w-md"
                                    data-filter="belum_dibayar"><i
                                   class="bx bx-x-circle font-size-16 me-2 align-middle"></i>
                                Not yet Paid</button>
                        </div> --}}
                    </div>
                    <div id="table">
                        <table class="table-bordered dt-responsive nowrap w-100 table"
                               id="tbl-debt">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Debt</th>
                                    <th>Debt Paid</th>
                                    <th>Remaining Debt</th>
                                    <th>Term of Payment
                                    </th>
                                    <th>Suplier</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($debts as $debt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $debt->formatted_created_date }}</td>
                                        <td>{{ moneyFormat($debt->purchase->total_cost) }}</td>
                                        <td>{{ moneyFormat($debt->paid_amount) }}</td>
                                        <td>{{ moneyFormat($debt->purchase->total_cost - $debt->paid_amount) }}</td>
                                        <td>{{ $debt->purchase->date }}</td>
                                        <td>{{ $debt->supplier->name }}</td>
                                        {{-- if 'lunas' --}}
                                        @if ($debt->purchase->total_cost == $debt->paid_amount)
                                            <td>
                                                <button class="btn btn-success waves-effect waves-light btn-sm"
                                                        type="button"
                                                        disabled>
                                                    <i class="bx bx-check-square"></i> Paid Off
                                                </button>
                                            </td>
                                        @else
                                            <td>
                                                <button class="btn btn-warning waves-effect waves-light btn-sm edit"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        type="button"
                                                        onclick="editDebt('{{ $debt->id }}')">
                                                    <i class="bx bx-cog"></i> Edit
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    @include('pages._Main.Accounting.Debt.edit')
@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

    <script src="{{ URL::asset('js/script.js') }}"></script>
    <!-- Datatable init -->
    <script>
        dataTableInit('#tbl-debt');
        $('.select2').select2();
    </script>

    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>

    <!-- form advanced init -->
    <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>

    <script>
        const editDebt = (id) => {
            $.ajax({
                url: `{{ route('admin.debts.edit', ':id') }}`.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.data.id);
                    $('#hasPaid').val(response.data.paid_amount);
                    const nowRemainingAmount = response.data.purchase.total_cost - response.data
                        .paid_amount;
                    let remainingAmount = nowRemainingAmount;

                    const formattedMoney = (amount) => {
                        return new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(amount);
                    }
                    $('#remainingAmountWillBe').html(
                        `Remaining Amount Will Be: ${formattedMoney(remainingAmount)}`);

                    $('#paidAmount').on('input', function(e) {
                        this.value = this.value.replace(/[^0-9]/g, '');

                        if ($(this).val() > nowRemainingAmount) {
                            $(this).val(nowRemainingAmount);
                        }

                        remainingAmount = nowRemainingAmount - $(this).val();

                        $('#remainingAmountWillBe').html(
                            `Remaining Amount Will Be: ${formattedMoney(remainingAmount)}`);
                    });


                },
                error: function(xhr) {
                    $('#editModal').modal('dispose')
                    if (error.responseJSON.message) {
                        toastWarning(error.responseJSON.message);
                    } else {
                        toastError(error.message);
                    }
                }
            });
        }

        $('#editPaidAmount').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editId').val();
            const paidAmount = $('#paidAmount').val();
            const hasPaid = $('#hasPaid').val();
            $.ajax({
                url: `{{ route('admin.debts.update', ':id') }}`.replace(':id', id),
                type: 'PUT',
                data: {
                    id: id,
                    paid_amount: parseInt(paidAmount) + parseInt(hasPaid)
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#editModal').modal('hide');
                    toastSuccess(response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                },
                error: function(error) {
                    $('#editModal').modal('hide');
                    if (error.responseJSON.message) {
                        toastWarning(error.responseJSON.message);
                    } else {
                        toastError(error.message);
                    }
                }
            });
        });
    </script>
@endsection
