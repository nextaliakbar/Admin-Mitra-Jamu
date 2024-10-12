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

                    <div class="card-title mb-3">
                        <h4>{{ $title }}</h4>
                    </div>

                    <div id="table">
                        <table class="table-bordered dt-responsive nowrap w-100 table"
                               id="table-show">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama User</th>
                                    <th>
                                        Hama / Penyakit
                                    </th>
                                    <th>Gejala</th>
                                    <th>
                                        Status
                                    </th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($diagnose as $diagnose)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $diagnose->customer_name }}</td>
                                        <td>{{ $diagnose->pest_disease_label }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($diagnose->history->symptoms as $symptom)
                                                    <li>{{ $symptom->code }} - {{ $symptom->label }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            {{ count(
                                                array_filter($diagnose->history->treatment, function ($item) {
                                                    return $item->treatment == null;
                                                }),
                                            ) > 0
                                                ? 'Butuh Konfirmasi'
                                                : 'Selesai' }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($diagnose->created_at)->format('d M Y, H:i') }}
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
    </script>
@endsection
