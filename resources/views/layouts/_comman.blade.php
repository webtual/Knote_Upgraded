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
      <link href="{{ cached_asset('comman/css/app.min.css') }}" rel="stylesheet" type="text/css" />
      <link href="{{ asset('user/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
      <link href="{{ cached_asset('user/css/menu.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>
        .gocover {position: fixed;left: 0;top: 0;z-index: 999;width: 100%;height: 100%;overflow: visible;}
        .gocover_modal {position: fixed;left: 0;top: 0;z-index: 999;width: 100%;height: 100%;overflow: visible;}
      </style>
      @if(request()->is('loan*') || request()->is('edit-profile*'))
        <link href="{{ cached_asset('comman/css/loans-style.css') }}" rel="stylesheet" type="text/css" />
      @endif
      
      @yield('styles')
   </head>
    @php
        $loan_applicant_class = '';
    @endphp
    @if(request()->is('loan*') || request()->is('edit-profile*'))
        @php
            $loan_applicant_class = 'loan-applicant-class';
        @endphp
    @endif
   <body class="{{$loan_applicant_class}}">
       <div class="gocover" style="background: url({{ asset('loader.gif') }}) center center no-repeat scroll rgba(45, 45, 45, 0.5); display: none;"></div>
       
        @if( (request()->is('admin/*') == false ) && (request()->is('broker/*') == false ))
        <div id="overlay">
          <img src="{{ asset('loader.svg') }}">
        </div>
        @endif
        
        @if(request()->is('loan*') || request()->is('edit-profile*'))
            @include('partials.comman.navbar-loan')
        @endif
        <!-- Begin page -->
        <div id="wrapper">
             <!--Start Preloader area-->
                @if(request()->is('loan*') || request()->is('edit-profile*'))
                @else
                    @include('partials.comman.navbar')
                    @include('partials.comman.leftsidebar')
                @endif
             <div class="content-page">
                @yield('content')
                @if(request()->is('loan*') || request()->is('edit-profile*'))
                
                @else
                    @include('partials.comman.footer')
                @endif
             </div>
          </div>
          
        @if(request()->is('loan*') || request()->is('edit-profile*'))
            @include('partials.comman.footer-loan')
        @endif
      
      <!-- Right bar overlay-->
      <div class="rightbar-overlay"></div>
      
      <!-- Vendor js -->
      <script src="{{ asset('comman/js/vendor.min.js') }}"></script>
      
      <script src="{{ asset('user/js/toastr.min.js') }}"></script>

      @yield('scripts')

      <!-- App js-->
      <script src="{{ asset('comman/js/app.min.js') }}"></script>
      
      <script src="{{ cached_asset('user/js/custom.js') }}"></script>
      
      @if(request()->is('loan*') || request()->is('edit-profile*'))
        <script src="{{ cached_asset('comman/js/loans-custom.js') }}"></script>
      @endif
   </body>
</html>