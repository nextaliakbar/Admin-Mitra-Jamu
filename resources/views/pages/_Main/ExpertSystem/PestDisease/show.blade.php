@extends('layouts.master')

@section('title')
    {{ $title }}
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

    {{-- back button --}}
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.pest-diseases.index') }}"
               class="btn btn-secondary waves-effect waves-light">
                <i class="bx bx-arrow-back font-size-16 me-2 align-middle"></i> Kembali
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <div class="card-title">
                        <h4>{{ $title }}</h4>
                    </div>

                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Kode</h5>
                                <p>{{ $pestDisease->code }}</p>

                                <h5>Label</h5>
                                <p>{{ $pestDisease->label }}</p>

                                <h5>Deskripsi</h5>
                                <p>{{ $pestDisease->description }}</p>

                                <h5>Hari</h5>
                                <p>{{ $pestDisease->day }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Penanganan</h5>
                                <ol class="list-group list-group-numbered">
                                    @foreach ($pestDisease->treatment as $treatment)
                                        <li class="list-group-item">
                                            {{ $treatment }}
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4>Kondisi Jamur Tiram setelah Penanganan</h4>
                        @if (auth()->user()->can('edit-expert-system-pestdisease'))
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.conditions.create', $pestDisease->id) }}"
                                   class="btn btn-primary waves-effect waves-light"
                                   type="button">
                                    <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah Kondisi
                                </a>
                            </div>
                        @endif
                    </div>

                    <div id="table">
                        <table class="table-bordered w-100 dt-responsive table"
                               id="table-show">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Kondisi</th>
                                    <th>Status</th>
                                    <th>Hari</th>
                                    <th>Penanganan</th>
                                    <th>Tampil Setelah</th>
                                    @if (auth()->user()->can('edit-expert-system-pestdisease'))
                                        <th style="min-width: 100px;">Action</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pestDisease->conditions as $condition)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $condition->code }}</td>
                                        <td>{{ $condition->value }}</td>
                                        <td>{{ conditionStatus($condition->status) }}</td>
                                        <td>{{ $condition->day }}</td>
                                        <td>
                                            <ol>
                                                @foreach ($condition->treatment as $treatment)
                                                    <li>{{ $treatment }}</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td>{{ $condition->is_after_code }}</td>
                                        @if (auth()->user()->can('edit-expert-system-pestdisease'))
                                            <td class="d-flex flex-column gap-2">
                                                <a class="btn btn-warning waves-effect waves-light btn-sm edit"
                                                   type="button"
                                                   href="{{ route('admin.conditions.edit', $condition->id) }}">
                                                    <i class="bx bx-edit"></i> Edit
                                                </a>

                                                @if (!(explode('-', $condition->code)[1] == 1 || explode('-', $condition->code)[1] == 2))
                                                    <button class="btn btn-danger waves-effect waves-light btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteItemModal"
                                                            type="button"
                                                            onclick="deleteCondition('{{ $condition->id }}', '{{ $condition->value }}')">
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

    @include('pages._Main.ExpertSystem.PestDisease.Condition.delete')
@endsection

@section('css')
    <link type="text/css"
          href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}"
          rel="stylesheet" />
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

    <script src="{{ URL::asset('js/script.js') }}"></script>

    <script>
        dataTableInit('#table-show');

        function deleteCondition(id, value) {
            $('#deleteItemModal').modal('show');
            $('#deleteItemTitle').html('Hapus Kondisi');
            $('#deleteItemBody').html(`Apakah anda yakin ingin menghapus kondisi <b>${value}</b> ?`);
            $('#deleteId').val(id);
        }

        $('.deleteItemConfirmBtn').click(function() {
            loadBtn($(this));
            let id = $('#deleteId').val();
            deleteData("{{ route('admin.conditions.destroy', ':id') }}".replace(':id', id));
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
