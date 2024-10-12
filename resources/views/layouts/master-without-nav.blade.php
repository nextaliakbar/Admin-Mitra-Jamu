<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <title> @yield('title') | SI-MOP Mitra Jamur Indonesia</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
  @include('layouts.head-css')
  <style>
    .side-bg {
      background: url("{{ URL::asset('assets/images/bg-auth-overlay.png') }}") no-repeat center center;
      background-size: cover;
      height: 100%;
    }

    .bg-img {
      background-image: url("{{ URL::asset('assets/images/authBg.webp') }}");
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      width: 100%;
      height: 100vh;
    }

    .titleAuth {
      /* d-flex justify-content-end flex-column align-items-end */
      display: flex;
      justify-content: flex-end;
      flex-direction: column;
      align-items: flex-end;
    }

    @media (max-width: 991px) {
      .leftBanner {
        display: none !important;
      }

      .titleAuth {
        justify-content: center;
        align-items: center;
      }
    }
  </style>
</head>

@yield('body')

@yield('content')

@include('layouts.vendor-scripts')
</body>

</html>
