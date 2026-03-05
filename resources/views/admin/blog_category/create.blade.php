@extends('layouts._comman')
@section('title', 'Blog Categories - Knote')
@section('styles')
<link rel="stylesheet" href="{{ asset('comman/css/cropme.css') }}">
<!-- Summernote css -->
<link href="{{ asset('comman/libs/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="content">
   <!-- Start Content-->
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item active">Blog Categories</li>
                  </ol>
               </div>
               <h4 class="page-title">Create New Blog Categories</h4>
            </div>
         </div>
      </div>
      
      <div class="row">
         <div class="col-lg-12">
            <form action="{{ url()->current() }}" name="blog-categories/create" method="post" onsubmit="return false;" enctype="multipart/form-data">
               <div class="card-box">
                  
                  <div class="form-group mb-3">
                     <label for="">Name<span class="text-danger">*</span></label>
                     <input type="text" id="" name="name" value="" class="form-control" placeholder="Name">
                  </div>

                  <hr>
                  <button class="btn btn-primary mt-3" type="submit" id="blog-categories-add">Submit</button>
                  <button type="reset" class="btn btn-secondary mt-3 ml-2">Cancel</button>
               </div>
            </form>
            <!-- end card-box -->
         </div>
         {{-- <div class="col-lg-4">
            <div class="card-box">
               <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Guidlines</h5>
               <div class="card slimscroll" style="max-height: 450px !important;">
                 
               </div>
            </div>
         </div> --}}
      </div>
      <!-- container -->


      
     

     
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
<script src="{{ asset('comman/js/pages/cropme.js') }}"></script>
<script src="{{ asset('comman/libs/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('comman/js/pages/form-summernote.init.js') }}"></script>
@endsection