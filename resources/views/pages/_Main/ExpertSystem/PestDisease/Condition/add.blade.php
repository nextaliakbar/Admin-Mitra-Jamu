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

                    <div>
                        <form action="{{ route('admin.conditions.store') }}"
                              method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden"
                                           name="pest_disease_id"
                                           value="{{ $pestDiseaseId }}">
                                    <div class="mb-3">
                                        <label for="code"
                                               class="form-label">Kode <span class="text-danger">*</span></label>
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
                                        <label for="value"
                                               class="form-label">Kondisi <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control"
                                               id="value"
                                               name="value"
                                               placeholder="Kondisi"
                                               value="{{ old('value') }}"
                                               autocomplete="off">
                                        @error('value')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status_condition"
                                               class="form-label">Status <span class="text-danger">*</span></label>
                                        <select type="text"
                                                class="form-control select2-status"
                                                id="status_condition"
                                                name="status"
                                                value="{{ old('status') }}"
                                                autocomplete="off">
                                            <option></option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="treatment"
                                               class="form-label">Penanganan <span class="text-danger">*</span></label>
                                        <table class="w-100">
                                            <tbody id="treatBody">
                                                @if (old('treatment'))
                                                    @foreach (old('treatment') as $treat)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}.</td>
                                                            <td>
                                                                <textarea class="form-control"
                                                                          id="treatment{{ $loop->iteration }}"
                                                                          name="treatment[]"
                                                                          rows="3">{{ $treat }}</textarea>
                                                                @error('treatment.' . ($loop->iteration - 1))
                                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>1.</td>
                                                        <td>
                                                            <textarea class="form-control"
                                                                      id="treatment1"
                                                                      name="treatment[]"
                                                                      rows="3"></textarea>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button"
                                                class="btn btn-secondary mt-3"
                                                onclick={{ 'addTreatment()' }}>Tambah Penanganan</button>
                                        @error('treatment.*')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="label"
                                               class="form-label">Hari</label>
                                        <input type="number"
                                               min="0"
                                               class="form-control"
                                               id="day"
                                               name="day"
                                               placeholder="Hari"
                                               value="{{ old('day') }}"
                                               autocomplete="off">
                                        @error('day')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="is_after"
                                               class="form-label">Tampil Setelah</label>
                                        <select type="text"
                                                class="form-control select2-isAfter"
                                                id="is_after"
                                                name="is_after"
                                                value="{{ old('is_after') }}"
                                                autocomplete="off">
                                            <option></option>
                                        </select>
                                        @error('is_after')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- submit button --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <a href="{{ route('admin.pest-diseases.show', $pestDiseaseId) }}"
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
        $('.select2-status').select2({
            placeholder: 'Pilih Status',
            multiple: false,
            data: [{
                    id: 'WORSENED',
                    text: 'Memburuk',
                },
                {
                    id: 'IMPROVED',
                    text: 'Membaik',
                }
            ],
        });

        $('.select2-isAfter').select2({
            placeholder: 'Pilih Tampil Setelah',
            multiple: false,
            data: @json($isAfterOptions),
        });

        const treatment = document.querySelector('#treatBody');
        const treatCount = treatment.dataset.count;
        let count = parseInt(treatCount) + 1;

        function addTreatment() {
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td>${count}.</td>
            <td><textarea class="form-control" id="treatment${count}" name="treatment[]" rows="2"></textarea></td>
        `;
            treatment.appendChild(tr);
            count++;
        }

        function removeTreatment() {
            treatment.removeChild(treatment.lastChild);
            count--;
        }
    </script>
@endsection
