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

          <div>
            <form action="{{ route('admin.pest-diseases.store') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="code" class="form-label">Kode</label>
                    <input type="text" class="form-control bg-light" id="code" name="code" placeholder="Code" value="{{ $newCode }}" readonly>
                    @error('code')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="label" class="form-label">Label</label>
                    <input type="text" class="form-control" id="label" name="label" placeholder="Label" value="{{ old('label') }}" autocomplete="off">
                    @error('label')
                      <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                      <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="treatment" class="form-label">Penanganan</label>
                    <table class="w-100">
                        <tbody id="treatBody">
                          @if (old('treatment'))
                            @foreach (old('treatment') as $treat)
                              <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>
                                  <textarea class="form-control" id="treatment{{ $loop->iteration }}" name="treatment[]" rows="2">{{ $treat }}</textarea>
                                  @error('treatment.' . ($loop->iteration - 1))
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                  @enderror
                                </td>
                              </tr>
                            @endforeach
                          @else
                            <tr>
                                <td>1.</td>
                                <td><textarea class="form-control" id="treatment1" name="treatment[]" rows="2"></textarea></td>
                            </tr>
                          @endif
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary mt-3" onclick={{ "addTreatment()" }}>Tambah Penanganan</button>
                    @error('treatment.*')
                      <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="label" class="form-label">Hari</label>
                    <input type="number" min="0" class="form-control" id="day" name="day" placeholder="Hari" value="{{ old('day') }}" autocomplete="off">
                    @error('day')
                      <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              {{-- submit button --}}
                <div class="row">
                    <div class="col-md-12">
                    <div class="mb-3">
                        <a href="{{ route('admin.pest-diseases.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
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

  <script>
    const treatment = document.querySelector('#treatBody');
    let count = 2;
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
