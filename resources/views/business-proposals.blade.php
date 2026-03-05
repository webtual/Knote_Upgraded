@extends('layouts._landing_master')
@section('title', 'Knote - Business Proposal')
@section('content')
<main id="main">

   <div id="header-banner" style="background-image: url({{ asset('/storage/resource/dchi_bg.jpg') }})">
      @include('partials.user.header_menu')
      <div class="bs-prop-bg pt-5 pb-5">
         <div class="container text-center">
            <h2 class="title">Business Proposals</h2>
            <div class="breadcrumbs">
               <span>
               <a href="{{ url('/') }}"><span>Home</span></a>  
               </span>
               <span><i class="fa fa-angle-right"></i></span>
               <span>
               <a href="javascript:;"><span class="active">Business Proposals </span></a>   
               </span>
            </div>
         </div>
      </div>
   </div>
   
   <section class="rs-details" id="bp-listing-page" data-auth-check="{{ (Auth::check()) ? '1' : '0' }}">
      <div class="container pt-lg-5 pt-4 pb-5">
         <div class="row">
            <div class="col-lg-3">
               <div class="left-side-form mb-4">
                  <div class="form-group">
                     <select class="form-control" name="category">
                        <option value="">Business Categories</option>
                        @foreach($business_types as $key => $bs)
                        <option value="{{ $bs->id }}" data-slug="{{ $bs->slug }}">{{ $bs->business_type }}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group">
                     <input type="text" name="keyword" class="form-control" value="" placeholder="Keyword">
                  </div>
                  {{-- 
                  <div class="form-group"><input type="text" name="contact" class="form-control" id="" placeholder="Location"></div>
                  <div class="form-group"><input type="text" name="contact" class="form-control" id="" placeholder="Target"></div>
                  <div class="form-group"><input type="text" name="contact" class="form-control" id="" placeholder="Min Per Investor"></div>
                  --}}
                  <div class="btn-part">
                     <button class="btn btn-primary more-btn btn-block" id="filter-business-proposal">Search</button>
                  </div>
               </div>
            </div>
            <div id="business-proposals" class="col-lg-9">
               <div class="row" id="my-list" data-current-url="{{ url()->current() }}">
                  @if(!empty($business_proposals))
                  @foreach($business_proposals as $bs)
                  <div class="col-lg-4 col-xl-4" id="{{ $bs->id }}">
                     <div class="item box wow">
                        @include('partials.block.business_proposal', ['bs' => $bs])
                     </div>
                  </div>
                  @endforeach
                  @endif
               </div>
               @if($business_proposals->count() >= 9)
               <div class="text-center read-txt d-none" id="my-loadmore" >
                  <a href="javascript:;" class="" id="bs-loadmore" data-url="{{ url('business-proposals') }}" >LOAD MORE <i class="fa fa-long-arrow-right"></i></a>
               </div>
               @endif
            </div>
         </div>
      </div>
   </section>
</main>

@endsection