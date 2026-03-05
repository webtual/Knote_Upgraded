@extends('layouts._comman')
@section('title', 'Business Proposals Favourite - Knote')
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
                     <li class="breadcrumb-item active">Business Proposals</li>
                  </ol>
               </div>
               <h4 class="page-title">Favourites</h4>
            </div>
         </div>
      </div>
     
      @include('partials.comman.alert.message')

      <div class="tab-content bs-list">
         <div class="tab-pane active" id="all">
            <div class="row" id="my-list">
               @if(!empty($business_proposals))
                  @foreach($business_proposals as $bs)
                  <div class="col-xl-4" id="{{ $bs->id }}" data-fvr-id="{{ $bs->user_is_favourite->id }}">
                     @include('partials.comman.block.business_proposal', ['bs' => $bs])
                  </div>
                  @endforeach
               @endif
            </div>
            
            @if($business_proposals->count() >= 9)
            <div class="row mb-5 d-none" id="my-loadmore">
               <div class="col-md-12">
                  <div class="text-center">
                     <a href="javascript:;" id="bs-loadmore" data-url="{{ url()->current() }}"  class="text-success font-18 my-fvr"><i class="mdi mdi-spin mdi-loading mr-1 my-loader d-none"></i> LoadMore </a>
                  </div>
               </div>
            </div>
            @endif
         </div>
      </div>
     
   
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
@endsection