@extends('layouts._comman')
@section('title', 'Business Proposals - Knote')
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
                     <li class="breadcrumb-item active">Business Proposal</li>
                  </ol>
               </div>
               <h4 class="page-title">{{ $result->title }}</h4>
            </div>
         </div>
      </div>
      @include('partials.comman.alert.message')
      <div class="row">
         <div class="col-8">
            @include('partials.comman.block.business_proposal', ['bs' => $result])
         </div>
         <div class="col-4">
            <div class="card-box">
               <div class="media mb-3">
                  <img class="d-flex mr-3 rounded-circle avatar-lg" src="{{ asset('storage/'.$result->user->first()->avtar) }}" alt="">
                  <div class="media-body">
                     <h4 class="mt-0 mb-1">{{ $result->user->first()->name }}</h4>
                     <p class="text-muted">{{ $result->user->first()->about }}</p>
                     <p class="text-muted"><i class="mdi mdi-office-building"></i> {{ $result->user->roles()->first()->role_name }}</p>
                     <a href="{{ prep_url($result->website) }}" target="blank" class="btn- btn-xs btn-info">Go to Website</a>
                  </div>
               </div>
            </div>
            <div class="card-box">
               <h4 class="header-title mb-3">Similar Post</h4>
               @foreach($similar_post as $sp)
               <a href="{{ url('business-proposal/'.$sp->slug()) }}">
                  <div class="media mb-3">
                     <img class="d-flex align-self-start rounded mr-3" src="{{ asset('storage/'.$sp->banner_image) }}" alt="" height="64">
                     <div class="media-body">
                        <h5 class="mt-0">{{ $sp->title }}</h5>
                        <p class="mb-1 text-muted">{{ $sp->time_ago() }}</p>
                     </div>
                  </div>
               </a>
               @endforeach

            </div>
            <div class="card-box">
               <h4 class="header-title mb-3">Share</h4>
               <div class="text-center">
                  <ul class="social-list list-inline mt-3 mb-0">
                     <li class="list-inline-item">
                        <a target="blank" href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $result->title }}" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                     </li>
                     <li class="list-inline-item">
                        <a  target="blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                     </li>
                     <li class="list-inline-item">
                        <a target="blank" href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $result->title }}" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-linkedin"></i></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
@endsection