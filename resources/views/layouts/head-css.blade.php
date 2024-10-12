@yield('css')
<!-- Select2 Css-->
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
<!-- Bootstrap Css -->
<link id="bootstrap-style" type="text/css" href="{{ URL::asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
<!-- Icons Css -->
<link type="text/css" href="{{ URL::asset('/assets/css/icons.min.css') }}" rel="stylesheet" />
<!-- App Css-->
<link id="app-style" type="text/css" href="{{ URL::asset('assets/css/app.css') }}" rel="stylesheet" />
<!-- Toastify Css-->
<link type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
@yield('bottom-css')
