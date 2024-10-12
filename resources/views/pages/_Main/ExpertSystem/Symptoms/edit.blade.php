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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="card-title">
                        <h4>{{ $title }}</h4>
                    </div>

                    <div class="pt-4">
                        <form action="{{ route('admin.symptoms.update', $symptom->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code"
                                               class="form-label">Kode</label>
                                        <input type="text"
                                               class="form-control bg-light"
                                               id="code"
                                               name="code"
                                               placeholder="Code"
                                               value="{{ $symptom->code }}"
                                               readonly>
                                        @error('code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="label"
                                               class="form-label">Label</label>
                                        <input type="text"
                                               class="form-control"
                                               id="label"
                                               name="label"
                                               placeholder="Label"
                                               value="{{ $symptom->label }}"
                                               autocomplete="off">
                                        @error('label')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- submit button --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <a href="{{ route('admin.symptoms.index') }}"
                                           class="btn btn-secondary">Cancel</a>
                                        <button type="submit"
                                                class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('js/script.js') }}"></script>

@endsection
