@extends('layouts._comman')
@section('title', 'Blogs - Knote')
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
                     <li class="breadcrumb-item active">Blogs</li>
                  </ol>
               </div>
               <h4 class="page-title">Create New Blog</h4>
            </div>
         </div>
      </div>
      
      <div class="row">
         <div class="col-lg-8">
            <form action="{{ url()->current() }}" name="blog/create" method="post" onsubmit="return false;" enctype="multipart/form-data">
               <div class="card-box">
                  
                  <div class="form-group mb-3">
                     <label for="">Title<span class="text-danger">*</span></label>
                     <input type="text" id="" name="title" value="" class="form-control" placeholder="Title">
                  </div>

                  <div class="form-group mb-3">
                     <label>Description<span class="text-danger">*</span></label>
                     <textarea class="form-control summernote-editor" rows="5" name="description" placeholder="Description"  id=""></textarea>
                  </div>
               
                  <div class="form-group mb-3">
                     <label for="">Category<span class="text-danger">*</span></label>
                     <div class="ml-1"> 
                        <div class="row"> 
                     
                        @php
                        $count = 1;
                        $tap = $blog_categories->count() / 3;
                        $tap = ceil($tap);
                        @endphp
                        @foreach($blog_categories as $key => $bs)
                           @if ($count%$tap == 1)
                           <div class="col-lg-4">
                           @endif

                           <div class="checkbox checkbox-success pb-1">
                              <input name="category[]" class="my-cu-check-uncheck-array" type="checkbox" id="inlineCheckbox{{ $key }}" value="{{ $bs->id }}" >
                              <label for="inlineCheckbox{{ $key }}"> {{ $bs->name }} </label>
                           </div>

                           @if($count%$tap == 0)
                              </div>
                           @endif
                           @php
                              $count++;
                           @endphp  

                        @endforeach
                        @if($count%$tap != 1) </div> @endif 

                        </div>  
                     </div>
                  </div>
                  
                  <div class="row cropme-div">
                     <div class="col-md-12">
                        <label for="example-fileinput">Image<span class="text-danger">*</span></label>
                        <input type="file" id="image" name="" class="form-control-file" data-width="1920" data-height="1080" data-type="rectangle">
                        <input type="hidden" name="image" class="form-control-file">
                     </div>
                  </div>
                  <hr>
                  <button class="btn btn-primary mt-3" type="submit" id="blog-add">Submit</button>
                  <button type="reset" class="btn btn-secondary mt-3 ml-2">Cancel</button>
               </div>
            </form>
            <!-- end card-box -->
         </div>
         <div class="col-lg-4">
            <div class="card-box">
               <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Guidlines</h5>
               <div class="card slimscroll" style="max-height: 450px !important;">
                 
               </div>
            </div>
         </div>
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