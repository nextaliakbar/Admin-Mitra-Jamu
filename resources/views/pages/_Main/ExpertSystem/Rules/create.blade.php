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
                        <form action="{{ route('admin.rules.store') }}"
                              method="POST">
                            @csrf
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
                                               value="{{ $newCode }}"
                                               readonly>
                                        @error('code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pest_disease_id"
                                               class="form-label">Hama / Penyakit</label>
                                        <select type="text"
                                                class="form-control select2-pestDisease"
                                                id="pest_disease_id"
                                                name="pest_disease_id"
                                                value="{{ old('pest_disease_id') }}"
                                                autocomplete="off">
                                            <option></option>
                                        </select>
                                        @error('pest_disease_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="symptom_id"
                                               class="form-label">Gejala</label>
                                        <select type="text"
                                                class="form-control select2-symptoms"
                                                id="symptom_id"
                                                name="symptom_id[]"
                                                value="{{ old('symptom_id[]') }}"
                                                autocomplete="off">
                                        </select>
                                        @error('symptom_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- submit button --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <a href="{{ route('admin.rules.index') }}"
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

@section('css')
    <style>
        .select2-container {
            z-index: 999 !important;
        }
    </style>
@endsection

@section('script')
    <script src="{{ URL::asset('js/script.js') }}"></script>
    <script>
        const dataPestDiseases = @json($pestDiseases).map((item) => {
            const selected = @json(old('pest_disease_id')) ? {
                selected: @json(old('pest_disease_id')) === item.id ? true : false
            } : {};
            return {
                id: item.id,
                text: `${item.code} - ${item.label}`,
                ...selected
            }
        });
        $('.select2-pestDisease').select2({
            placeholder: 'Pilih Hama / Penyakit',
            multiple: false,
            data: dataPestDiseases,
        });

        const dataSymptoms = @json($symptoms).map((item) => {
            const selected = oldSymptoms().length > 0 ? {
                selected: oldSymptoms().includes(item.id) ? true : false
            } : {};
            return {
                id: item.id,
                text: `${item.code} - ${item.label}`,
                ...selected
            }
        });
        $('.select2-symptoms').select2({
            placeholder: 'Pilih Gejala',
            multiple: true,
            closeOnSelect: false,
            data: dataSymptoms,
        });

        function oldSymptoms() {
            const oldSymptoms = @json(old('symptom_id'));
            return oldSymptoms ? oldSymptoms : [];
        }
    </script>
@endsection
