@extends('layouts._comman')
@section('title', 'Blog Categories - Knote')
@section('styles')
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
            <h4 class="page-title">{{ $result->name }}</h4>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-12">
         <form action="{{ url()->current() }}" id="" name="" method="put" onsubmit="return false;" enctype="multipart/form-data">
            <div class="card-box">
               <div class="form-group mb-3">
                  <label for="">Name<span class="text-danger">*</span></label>
                  <input type="text" id="" name="name" value="{{ $result->name }}" class="form-control" placeholder="Name" required="required">
               </div>

              
               <hr>
               <button class="btn btn-primary mt-3" type="submit" id="blog-categories-update">Update</button>
               <button type="reset" class="btn btn-secondary mt-3 ml-2">Cancel</button>
            </div>
         </form>
         <!-- end card-box -->
      </div>
      {{-- <div class="col-lg-4">
         <div class="card-box">
            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Guidlines</h5>
            <div class="card slimscroll" style="max-height: 450px !important;" >
              
            </div>
         </div>
      </div> --}}
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
@endsection