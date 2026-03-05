@extends('layouts._comman')
@section('title', 'Business Proposals - Knote')
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
                  <li class="breadcrumb-item active">Business Proposal</li>
               </ol>
            </div>
            <h4 class="page-title">{{ $result->title }}</h4>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-8">
         <form action="{{ url()->current() }}" id="" name="" method="put" onsubmit="return false;" enctype="multipart/form-data">
            <div class="card-box">
               <div class="row">
                  
                  <div class="col-md-12">
                     <div class="form-group mb-3">
                        <label for="">Title<span class="text-danger">*</span></label>
                        <input type="text" id="" name="title" value="{{ $result->title }}" class="form-control" placeholder="Title" required="required">
                     </div>
                  </div>
               </div>
               <div class="form-group mb-3">
                  <label>Description<span class="text-danger">*</span></label>
                  <textarea class="form-control summernote-editor" rows="5" name="description" placeholder="Description" required="required">{{ $result->description }}</textarea>
               </div>
               <div class="form-group mb-3">
                  <label for="">Location<span class="text-danger">*</span></label>
                  <input type="text" name="location" value="{{ $result->location }}"  id="" class="form-control algolia-places" placeholder="Location" required="required">
               </div>


               <div class="form-group mb-3">
                  <label for="">Category<span class="text-danger">*</span></label>
                  <div class="ml-1">
                     <div class="row"> 
                     
                     @php
                     $count = 1;
                     $tap = $business_types->count() / 3;
                     $tap = ceil($tap);
                     @endphp

                     @foreach($business_types as $key => $bs)
                        @if ($count%$tap == 1)
                           <div class="col-lg-4">
                        @endif

                        <div class="checkbox checkbox-success pb-1">
                           <input name="category[]" class="my-cu-check-uncheck-array" type="checkbox" id="inlineCheckbox{{ $key }}" value="{{ $bs->id }}" {{ ($result->business_types->contains($bs->id)) ? 'checked="checked"' : '' }} >
                           <label for="inlineCheckbox{{ $key }}"> {{ $bs->business_type }} </label>
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

               <div class="row mb-3">
                  <div class="col-md-6">
                     <label for="">Target<span class="text-danger">*</span></label>
                     <input type="text" name="target" value="{{ $result->target }}"  id="" class="form-control numbers-only" placeholder="Target" required="required">
                  </div>
                  <div class="col-md-6">
                     <label for="">Min per Investor</label>
                     <input type="text" name="min_per_investor" value="{{ $result->min_per_investor }}"  id="" class="form-control numbers-only" placeholder="Min Per Investor">
                  </div>
               </div>
               <div class="form-group mb-3">
                  <label for="">Website</label>
                  <input type="text" id="" name="website" value="{{ $result->website }}" class="form-control" placeholder="Website">
               </div>

               <div class="row cropme-div">
                  <div class="col-md-6">
                     <label for="example-fileinput">Logo Image<span class="text-danger">*</span></label>
                     <input type="file" id="business_logo_image" name="" class="form-control-file" data-width="200" data-height="200" data-type="square">
                     <input type="hidden" name="business_logo_image" value="{{ $result->logo_image }}" class="form-control-file" required="required">

                  </div>
                  <div class="col-md-6">
                     <label for="example-fileinput">Banner Image<span class="text-danger">*</span></label>
                     <input type="file" id="business_banner_image" name="" class="form-control-file"
                     data-width="350" data-height="150" data-type="rectangle">
                     <input type="hidden" name="business_banner_image" value="{{ $result->banner_image }}" class="form-control-file" required="required" >
                  </div>
               </div>
               <hr>
               <button class="btn btn-primary mt-3" type="submit" id="business-proposals-update">Update</button>
               <button type="reset" class="btn btn-secondary mt-3 ml-2">Cancel</button>
            </div>
         </form>
         <!-- end card-box -->
      </div>
      <div class="col-lg-4">
         <div class="card-box">
            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Guidlines</h5>
            <div class="card slimscroll" style="max-height: 450px !important;" >
               {{-- @php
               $business_proposals = App\BusinessProposal::limit(1)->orderBy('id', 'desc')->get();
               @endphp
               @if(!empty($business_proposals))
               @foreach($business_proposals as $bs)
               <div style="border: 1px #e3e7f1 solid !important;" class="mt-3"> 
                  @include('partials.comman.block.business_proposal', ['bs' => $bs])
               </div>
               @endforeach
               @endif --}}
            </div>
         </div>
      </div>
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
<script src="{{ asset('comman/js/pages/cropme.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/places.js@1.17.1"></script>
<!-- Summernote js -->
<script src="{{ asset('comman/libs/summernote/summernote-bs4.min.js') }}"></script>
<!-- Init js -->
<script src="{{ asset('comman/js/pages/form-summernote.init.js') }}"></script>
@endsection