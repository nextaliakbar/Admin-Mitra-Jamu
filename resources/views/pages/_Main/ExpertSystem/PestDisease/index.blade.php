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
                        <div class="d-flex justify-content-end">
                            @if (auth()->user()->can('add-expert-system-pestdisease'))
                                <a href="{{ route('admin.pest-diseases.create') }}"
                                   class="btn btn-primary waves-effect waves-light"
                                   type="button">
                                    <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah
                                    {{ str_replace('Data ', '', $title) }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div id="table">
                        <table class="table-bordered w-100 table"
                               id="table-show">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Label</th>
                                    <th>Deskripsi</th>
                                    <th>Penanganan</th>
                                    <th>Hari</th>
                                    <th style="min-width: 100px;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pestDiseases as $pestDisease)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pestDisease->code }}</td>
                                        <td>{{ $pestDisease->label }}</td>
                                        <td>{{ truncateText($pestDisease->description, 100) }}</td>
                                        <td>
                                            <ol>
                                                @foreach ($pestDisease->treatment as $treatment)
                                                    <li>{{ $treatment }}</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td>{{ $pestDisease->day }}</td>
                                        <td>
                                            @if (auth()->user()->can('edit-expert-system-pestdisease'))
                                                <a class="btn btn-warning waves-effect waves-light btn-sm mb-2"
                                                   role="button"
                                                   href="{{ route('admin.pest-diseases.edit', $pestDisease->id) }}">
                                                    <i class="bx bx-edit"></i> Edit
                                                </a>
                                            @endif

                                            <a class="btn btn-info waves-effect waves-light btn-sm mb-2"
                                               role="button"
                                               href="{{ route('admin.pest-diseases.show', $pestDisease->id) }}">
                                                <i class="bx bxs-detail"></i> Kondisi
                                            </a>

                                            @if (auth()->user()->can('delete-expert-system-pestdisease'))
                                                <button class="btn btn-danger waves-effect waves-light btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteItemModal"
                                                        type="button"
                                                        onclick="deletePestDisease('{{ $pestDisease }}')">
                                                    <i class="bx bx-trash"></i> Hapus
                                                </button>
                                            @endif
                                        </td>
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
                                type="button">Delete</button>
                        <button class="btn btn-sm btn-secondary ms-2"
                                data-bs-dismiss="modal"
                                type="button">Cancel</button>
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

        function deletePestDisease(pestDisease) {
            const {
                id,
                label,
                code
            } = JSON.parse(pestDisease);
            $('#deleteName').text(`${code} - ${label}`);
            $('#deleteId').val(id);
        }

        $('.deleteItemConfirmBtn').click(function() {
            loadBtn($(this));
            let id = $('#deleteId').val();
            deleteData("{{ route('admin.pest-diseases.destroy', ':id') }}".replace(':id', id));
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
