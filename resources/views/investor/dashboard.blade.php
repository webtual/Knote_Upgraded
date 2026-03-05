@extends('layouts._comman')
@section('title', 'Dashboard - Knote')
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
                     <li class="breadcrumb-item active">Dashboard</li>
                  </ol>
               </div>
               <h4 class="page-title">{{ ucfirst(Auth::user()->roles()->first()->role_name) }} Dashboard</h4>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-3 col-xl-3">
            <div class="card-box">
               <div class="row">
                  <div class="col-6">
                     <div class="avatar-sm bg-blue rounded">
                        <i class="fe-box avatar-title font-22 text-white"></i>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="text-right">
                        <h3 class="text-dark my-1"><span data-plugin="counterup">{{ App\BusinessProposal::count() }}</span></h3>
                        <p class="text-muted mb-1 text-truncate">Business Proposal</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end card-box-->
         </div>
         <!-- end col -->
         <div class="col-md-3 col-xl-3">
            <div class="card-box">
               <div class="row">
                  <div class="col-6">
                     <div class="avatar-sm bg-success rounded">
                        <i class="fe-users avatar-title font-22 text-white"></i>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="text-right">
                        <h3 class="text-dark my-1"><span data-plugin="counterup">{{ App\Resource::count() }}</span></h3>
                        <p class="text-muted mb-1 text-truncate">Resources</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end card-box-->
         </div>
         <!-- end col -->
         <div class="col-md-3 col-xl-3">
            <div class="card-box">
               <div class="row">
                  <div class="col-6">
                     <div class="avatar-sm bg-warning rounded">
                        <i class="fe-users avatar-title font-22 text-white"></i>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="text-right">
                        <h3 class="text-dark my-1"><span data-plugin="counterup">{{ App\User::count_users(4) }}</span></h3>
                        <p class="text-muted mb-1 text-truncate">Entrepreneur</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end card-box-->
         </div>

         <!-- end col -->
         <div class="col-md-3 col-xl-3">
            <div class="card-box">
               <div class="row">
                  <div class="col-6">
                     <div class="avatar-sm bg-info rounded">
                        <i class="fe-users avatar-title font-22 text-white"></i>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="text-right">
                        <h3 class="text-dark my-1"><span data-plugin="counterup">{{ App\User::count_users(5) }}</span></h3>
                        <p class="text-muted mb-1 text-truncate">Investors</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end card-box-->
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <h4 class="page-title">Business Proposal</h4>
            </div>
         </div>
      </div>
      <div class="row mb-2">
         {{-- 
         <div class="col-sm-8">
            <div class="text-sm-left">
               <div class="btn-group mb-3">
                  <button type="button" class="btn btn-primary">All</button>
               </div>
               <div class="btn-group mb-3 ml-1">
                  <button type="button" class="btn btn-light">Latest</button>
               </div>
            </div>
         </div>
         --}}
         <!-- end col-->
         {{-- 
         <div class="col-sm-4 text-right">
            <button type="button" class="btn btn-danger btn-rounded mb-3"><i class="mdi mdi-plus"></i> Create New Business Proposal</button>
         </div>
         --}}
      </div>
      <div class="row">
         @php
         $business_proposals = App\BusinessProposal::limit(6)->orderBy('id', 'DESC')->get();
         @endphp
         @if(!empty($business_proposals))
         @foreach($business_proposals as $bs)
         <div class="col-xl-4">
            @include('partials.comman.block.business_proposal', ['bs' => $bs])
         </div>
         @endforeach
         @endif
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="text-center">
               <a href="{{ url('business-proposals') }}" class="text-success font-18">{{-- <i class="mdi mdi-spin mdi-loading mr-1"></i> --}} View All </a>
            </div>
         </div>
      </div>
      <div class="row mb-2">
         {{-- 
         <div class="col-sm-8">
            <div class="text-sm-left">
               <div class="btn-group mb-3">
                  <button type="button" class="btn btn-primary">All</button>
               </div>
               <div class="btn-group mb-3 ml-1">
                  <button type="button" class="btn btn-light">Latest</button>
               </div>
            </div>
         </div>
         <div class="col-sm-4 text-right">
            <button type="button" class="btn btn-danger btn-rounded mb-3"><i class="mdi mdi-plus"></i> Create New Resource</button>
         </div>
         --}}
      </div>
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <h4 class="page-title">Resources</h4>
            </div>
         </div>
      </div>
      <div class="row">
         @php
         $resources = App\Resource::limit(6)->orderBy('id', 'DESC')->get();
         @endphp
         @if(!empty($resources))
         @foreach($resources as $resource)
         <div class="col-xl-4">
            @include('partials.comman.block.resource', ['resource' => $resource])
         </div>
         @endforeach
         @endif
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="text-center">
               <a href="{{ url('resource') }}" class="text-success font-18 ">{{-- <i class="mdi mdi-spin mdi-loading mr-1"> --}}</i> View All </a>
            </div>
         </div>
      </div>
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
@endsection