@extends('layouts.master-without-nav')

@section('title')
  @lang('translation.Login')
@endsection

@php
  $local = App::environment('local');
@endphp

@section('body')

  <body>
  @endsection

  @section('content')
    <div class="account-pages overflow-hidden" style="width: 100vw;">
      <div class="row">
        <div class="col-md-0 col-lg-7 leftBanner">
          <div class="bg-img">
            <div class="side-bg">
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-5 overflow-hidden">
          <div class="px-8 my-5">
            <div class="text-primary">
              <div class="p-4 titleAuth">
                <h2 class="fw-bold mb-0">Selamat Datang!</h2>
                <h3 class="fw-bold mb-0">SIM-OP</h3>
                <h4 class="fw-bold">Sistem Manajemen & Operasional</h4>
              </div>
            </div>
            <div class="pt-0">
              <div class="p-4">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="text-primary">
                    <h5 class="mb-1">Masuk dengan akun anda</h5>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="username">Email</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="username" name="email"
                      type="email" value="{{ $local ? old('email', 'super@mitrajamur.com') : old('email') }}" placeholder="Enter Email"
                      autocomplete="email" autofocus>
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                      <input class="form-control @error('password') is-invalid @enderror" id="userpassword"
                        name="password" type="password" aria-label="Password" {{ $local ? 'value=password' : '' }}
                        aria-describedby="password-addon" placeholder="Enter Password">
                      <button class="btn btn-light" id="password-addon" type="button"><i
                          class="mdi mdi-eye-outline"></i></button>
                      @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" id="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                      Ingat saya
                    </label>
                  </div>

                  <div class="d-grid mt-3">
                    <button class="btn btn-primary waves-effect waves-light" type="submit">Masuk</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
          <div class="mt-5 text-center">

            <div>
              ©
              <script>
                document.write(new Date().getFullYear())
              </script> SIM-OP Mitra Jamur Indonesia, Dibangun dengan <i
                class="mdi mdi-heart text-danger"></i>
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- end account-pages -->
  @endsection
