<!doctype html>
<html lang="{{ str_replace('_', '-',  app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') Laravel 11 CRUD  Application</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"">
	<link rel="stylesheet" href="{{ asset('assets/css/alertify.css') }}"">
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}"">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.css') }}" >
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/common.css') }}" >
	<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
	
</head>
<body>
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
          <a class="navbar-brand" href="{{ route('login') }}" title="{{ trans('messages.navbar') }}">{{ trans('messages.navbar') }}</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ config('constants.PRODUCT_URL') }}" title="{{ trans('messages.product') }}" >{{ trans('messages.product') }}</a>
              </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger" type="submit" title="{{ trans('messages.logout') }}">{{ trans('messages.logout') }}</button>
            </form>
          </div>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
	<script type="text/javascript" src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/alertify.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/common.js') }}"></script>
</body>
</html>