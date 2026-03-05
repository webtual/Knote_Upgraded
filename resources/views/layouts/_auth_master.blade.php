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
		
	  <!-- Plugins css -->
	<link href="{{ asset('comman/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
	
	<!-- App css -->
	<link href="{{ asset('comman/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('comman/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('comman/css/app.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('user/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ cached_asset('comman/css/loan-application.css') }}" rel="stylesheet">
	<link href="{{ asset('comman/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
	
	<link href="{{ asset('user/css/custom.css') }}" rel="stylesheet" type="text/css"/>
	
	<link href="{{ cached_asset('user/css/style.css') }}" rel="stylesheet">
	<link href="{{ cached_asset('user/css/menu.css') }}" rel="stylesheet">

     
      @yield('styles')

</head>

@if( (Route::currentRouteName() == 'loan-applicant') || (Route::currentRouteName() == 'register') )
<body class="authentication-bg authentication-bg-pattern">
@else
<body class="pb-0">
@endif
        
        <div id="overlay">
          <img src="{{ asset('loader.svg') }}">
        </div>
        
    
        @include('partials.master_page.header')
        
        
		@yield('content')
        
        @include('partials.master_page.footer')

		
		<script src="{{ asset('comman/js/vendor.min.js') }}"></script> 
		<script src="{{ asset('user/js/toastr.min.js') }}"></script> 
		
		<!-- App js--> 
		<script src="{{ asset('comman/js/app.min.js') }}"></script> 
		
      	@yield('scripts')
     	<script src="{{ asset('user/js/custom.js') }}?v={{time()}}"></script>


   </body>
</html>