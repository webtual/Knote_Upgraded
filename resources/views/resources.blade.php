@extends('layouts._landing_master')
@section('title', 'Knote - Resources')
@section('content')
<main id="main">
   <div id="header-banner" style="background-image: url({{ asset('/storage/resource/dchi_bg.jpg') }})">
      @include('partials.user.header_menu')
      <div class="bs-prop-bg pt-5 pb-5">
         <div class="container text-center">
            <h2 class="title">Resources</h2>
            <div class="breadcrumbs">
               <span>
               <a href="{{ url('/') }}"><span>Home</span></a>  
               </span>
               <span><i class="fa fa-angle-right"></i></span>
               <span>
               <a href="javascript:;"><span class="active">Resources </span></a>   
               </span>
            </div>
         </div>
      </div>
   </div>
   <section class="rs-details" id="rs-listing-page" data-auth-check="{{ (Auth::check()) ? '1' : '0' }}">
      <div class="container pt-5 pb-5">
         <div class="row">
            <div class="col-lg-3">
               <div class="left-side-form mb-4">
                  <div class="form-group">
                     <select class="form-control" name="category">
                        <option value="">Resource Categories</option>
                        @foreach($business_types as $key => $bs)
                        <option value="{{ $bs->id }}" data-slug="{{ $bs->slug }}">{{ $bs->business_type }}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group">
                     <input type="text" name="keyword" class="form-control" value="" placeholder="Keyword">
                  </div>
                  <div class="btn-part">
                     <button class="btn btn-primary more-btn btn-block" id="filter-resource">Search</button>
                  </div>
               </div>
            </div>
            <div id="resources" class="col-lg-9">
               <div class="row" id="my-list" data-current-url="{{  url()->current() }}">
                  @if(!empty($resources))
                  @foreach($resources as $resource)
                  <div class="col-lg-4 col-xl-4" id="{{ $resource->id }}">
                     <div class="item box wow">
                        @include('partials.block.resource', ['resource' => $resource])
                     </div>
                  </div>
                  @endforeach
                  @endif 
               </div>
               @if($resources->count() >= 9)
               <div class="text-center read-txt d-none" id="my-loadmore">
                  <a class="" id="resource-loadmore" data-url="{{ url('resource') }}"  href="javascript:;">LOAD MORE <i class="fa fa-long-arrow-right"></i></a>
               </div>
               @endif
            </div>
         </div>
      </div>
   </section>
</main>

@endsection