@extends('layouts.master')

@section('title')
    {{ $title }}
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
            {{ $title }}
        @endslot
    @endcomponent

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show"
             role="alert">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="card-title">
                        <h4>{{ $title }}</h4>
                        @if (auth()->user()->can('add-expert-system-symptom'))
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.symptoms.create') }}"
                                   class="btn btn-primary waves-effect waves-light"
                                   type="button">
                                    <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah
                                    {{ str_replace('Data ', '', $title) }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <div id="table">
                        <table class="table-bordered dt-responsive nowrap w-100 table"
                               id="table-show">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Label</th>
                                    @if (auth()->user()->can('edit-expert-system-symptom') &&
                                            auth()->user()->can('delete-expert-system-symptom'))
                                        <th style="min-width: 100px;">Action</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($symptoms as $symptom)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $symptom->code }}</td>
                                        <td>{{ $symptom->label }}</td>
                                        @if (auth()->user()->can('edit-expert-system-symptom') &&
                                                auth()->user()->can('delete-expert-system-symptom'))
                                            <td>
                                                @if (auth()->user()->can('edit-expert-system-symptom'))
                                                    <a class="btn btn-warning waves-effect waves-light btn-sm"
                                                       role="button"
                                                       href="{{ route('admin.symptoms.edit', $symptom->id) }}">
                                                        <i class="bx bx-edit"></i> Edit
                                                    </a>
                                                @endif
                                                @if (auth()->user()->can('delete-expert-system-symptom'))
                                                    <button class="btn btn-danger waves-effect waves-light btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteItemModal"
                                                            type="button"
                                                            onclick="deleteSymptom('{{ $symptom }}')">
                                                        <i class="bx bx-trash"></i> Hapus
                                                    </button>
                                                @endif
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

    <!-- Modal Delete -->
    <div class="modal fade"
         id="deleteItemModal"
         role="dialog"
         aria-labelledby="deleteItemModalLabel"
         aria-hidden="true"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered"
             role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4 class="mt-4">Apakah Anda yakin ingin menghapus <b class="font-bold"
                           id="deleteName"></b> ?</h4>
                    <input id="deleteId"
                           type="hidden">
                    <div class="d-flex justify-content-center mt-4">
                        <button class="btn btn-sm btn-danger deleteItemConfirmBtn"
                                type="button">Hapus</button>
                        <button class="btn btn-sm btn-secondary ms-2"
                                data-bs-dismiss="modal"
                                type="button">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

    <script src="{{ URL::asset('js/script.js') }}"></script>
    <!-- Datatable init -->
    <script>
        dataTableInit('#table-show');

        function deleteSymptom(symptom) {
            const {
                id,
                code,
                label
            } = JSON.parse(symptom);
            $('#deleteName').text(`${code} - ${label}`);
            $('#deleteId').val(id);
        }

        $('.deleteItemConfirmBtn').click(function() {
            loadBtn($(this));
            const id = $('#deleteId').val();
            deleteData("{{ route('admin.symptoms.destroy', ':id') }}".replace(':id', id));
        });

        function deleteData(url) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == 'success') {
                        toastSuccess(response.message);
                        $('#deleteItemModal').modal('hide');
                        $('.deleteItemConfirmBtn').html('Hapus').removeClass('disabled');
                        $('#deleteId').val('');

                        $('#table-show').html(
                            `@include('components.table-loader')`
                        );

                        $('#table').load(location.href + ' #table-show', function() {
                            dataTableInit('#table-show');
                        });
                    } else {
                        toastError(error.responseJSON.message);
                        $('#deleteItemModal').modal('hide');
                        $('.deleteItemConfirmBtn').html('Hapus').removeClass('disabled');
                    }
                },
                error: function(error) {
                    toastError(error.responseJSON.message);
                    $('#deleteItemModal').modal('hide');
                    $('.deleteItemConfirmBtn').html('Hapus').removeClass('disabled');
                }
            });
        }
    </script>
@endsection
