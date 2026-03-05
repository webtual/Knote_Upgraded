<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8"/>
      <title>@yield('title')</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta content="width=device-width, initial-scale=1" name="viewport"/>
      <meta content="" name="description"/>
      <meta content="" name="author"/>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="shortcut icon" href="{{ asset('favicon.png') }}"/>

      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">


      <!-- App favicon -->
      <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
      
      <!-- Bootstrap CSS File -->
      <link href="{{ asset('user/lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

      <!-- Libraries CSS Files -->
      <link href="{{ asset('user/lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
      <link href="{{ asset('user/lib/animate/animate.min.css') }}" rel="stylesheet">
      <link href="{{ asset('user/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
      <link href="{{ asset('user/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
      <link href="{{ asset('user/lib/magnific-popup/magnific-popup.css') }}" rel="stylesheet">
      <link href="{{ asset('user/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

      <!-- Main Stylesheet File -->
      <link href="{{ cached_asset('user/css/style.css') }}" rel="stylesheet">
      <link href="{{ cached_asset('user/css/menu.css') }}" rel="stylesheet">

      <link rel="stylesheet" type="text/css" href="{{ cached_asset('user/css/custom.css') }}" />
      <link href="{{ asset('user/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
      @yield('styles')
   </head>
   <body id="body" class="{{ (Route::currentRouteName() == 'root') ? '' : 'sticky-checker' }}">
      
      @include('partials.user.header')
      @yield('content')
      @include('partials.user.footer')
      
      @if(Route::currentRouteName() != 'dashboard')
      @include('partials.comman.modal.inquiry')
	  @endif

      <!-- JavaScript Libraries -->
      <script src="{{ asset('user/lib/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('user/lib/jquery/jquery-migrate.min.js') }}"></script>
      <script src="{{ asset('user/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('user/lib/easing/easing.min.js') }}"></script>
      <script src="{{ asset('user/lib/superfish/hoverIntent.js') }}"></script>
      <script src="{{ asset('user/lib/superfish/superfish.min.js') }}"></script>
      <script src="{{ asset('user/lib/wow/wow.min.js') }}"></script>
      <script src="{{ asset('user/lib/owlcarousel/owl.carousel.min.js') }}"></script>
      <script src="{{ asset('user/lib/magnific-popup/magnific-popup.min.js') }}"></script>
      <script src="{{ asset('user/lib/sticky/sticky.js') }}"></script>

     

      <!-- Template Main Javascript File -->
      <script src="{{ cached_asset('user/js/main.js') }}"></script>

      
      <script src="{{ asset('user/js/toastr.min.js') }}"></script>
      

      @yield('scripts')
      <script src="{{ cached_asset('user/js/custom.js') }}"></script>

      
   </body>
</html>