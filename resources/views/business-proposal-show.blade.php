@extends('layouts._landing_master')
@section('title', 'Knote - Business Proposal')
@section('content')
<main id="main">
   <div id="header-banner" style="background-image: url({{ asset('storage/'.$result->banner_image) }})">
      @include('partials.user.header_menu')
      <div class="bs-detail-banner">
         {{-- <img class="pitchcover-image" src="{{ asset('storage/'.$result->banner_image) }}" alt=""> --}}
         <div class="pitchcover-content text-lg-left text-md-left text-sm-left text-center">
            <div class="container">
               <div class="row">
                  <div class="col-lg-8 text-lg-left wow fadeInLeft">
                     <div class="site-logo">
                        <img src="{{ asset('storage/'.$result->logo_image) }}" width="105" height="105" alt=""/>
                     </div>
                     <div class="site-title ml-2 mr-2">
                        <h3>{{ $result->title }}</h3>
                        <div class="site-location">
                           <i class="ion-ios-location-outline"></i> {{ $result->location }}
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 cta-btn-container wow fadeInRight mt-2 mb-md-0 mt-lg-0 mb-3 mb-lg-0">
                     <a target="blank" href="{{ prep_url($result->website) }}" class="btn btn-primary mr-2">
                     Go to Website
                     </a>
                     <a href="{{ url('login') }}" class="btn btn-primary">
                     <i class="fa fa-star-o"></i> Favourite
                     </a>
                  </div>
               </div>
               <div></div>
            </div>
         </div>
      </div>
   </div>
   <section class="bs-details">
      <div class="bs-detail-content mt-5 mb-5">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 wow fadeInLeft">
                  <div class="proposal-blocks short-smmary">
                     <h2>
                        <span class="editableLabel" labelid="proposal_view:short_summary">Description</span>
                     </h2>
                     <p class="overview">
                        {!! $result->description !!}                       
                     </p>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <ul class="cat-blogs">
                           @forelse($result->business_types as $bs)
                           <li class="cat-item">
                              <a href="{{ url('business-proposals/category/'.$bs->slug) }}">
                                 <i class="fa fa-tag" aria-hidden="true"></i> {{ $bs->business_type }}
                              </a>
                           </li>
                           @empty
                           @endforelse
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInRight">
                  <div class="proposal-blocks">
                     <h2><span class="editableLabel" labelid="proposal_view:overview">Overview</span></h2>
                     <div class="investment-summary">
                        <table class="table">
                           <tbody>
                              {{-- 
                              <tr>
                                 <td>Business Area</td>
                                 <td>
                                    <div class="text-right"> <strong>{{ $result->business_type->business_type }}</strong></div>
                                 </td>
                              </tr>
                              --}}
                              <tr>
                                 <td>Target</td>
                                 <td>
                                    <div class="text-right"> <strong>{{ $result->money_format_target() }}</strong></div>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Minimum Per Investor</td>
                                 <td>
                                    <div class="text-right"> <strong class="text-right">{{ $result->money_format_min_per_investor() }}</strong></div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="well ask-question p-4" style="background:#f2f2f2 !important;">
                        <p>
                           <strong><span class="editableLabel" labelid="proposal_view:got_a_question">Got a question about this project?</span></strong>
                           <span><span class="editableLabel" labelid="proposal_details:got_a_question">If you need any more info, you can contact the entrepreneur directly.</span> </span>
                        </p>
                        <a href="javascript:;" class="btn btn-primary" data-toggle="modal" data-target="#ask_a_question" data-auth-check="{{ (Auth::check()) ? '1' : '0' }}" ><span class="editableLabel">Ask a question</span></a>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Button trigger modal -->
            <!-- Modal -->
         </div>
      </div>
   </section>
</main>



@endsection

