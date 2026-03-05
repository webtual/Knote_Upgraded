@extends('layouts._landing_master')
@section('title', 'Knote - Resources')
@section('content')
<main id="main">
   <div id="header-banner" style="background-image: url({{ asset('storage/'.$result->banner_image) }})">
      @include('partials.user.header_menu')
      <div class="bs-prop-bg resource-show pt-5 pb-5">
         <div class="container text-center">
            <h2 class="title">{{ $result->title }}</h2>
            <div class="breadcrumbs">
               <span>
               <a href="{{ url('/') }}"><span>Home</span></a>   
               </span>
               <span>&nbsp;<i class="fa fa-angle-right"></i></span>
               <span>
               <a href="{{ url('resource') }}">&nbsp;<span>Resources</span></a>  
               </span>
               <span>&nbsp;<i class="fa fa-angle-right"></i></span>
               <span>
               <a href="javascript:;"><span class="active">&nbsp;{{ $result->title }} </span></a>   
               </span>
            </div>
         </div>
      </div>
   </div>
   <section class="rs-details" data-auth-check="{{ (Auth::check()) ? '1' : '0' }}">
      <div class="container pt-5 pb-5">
         <div class="row">
            <div class="col-lg-9 wow fadeInLeft">
               <article>
                  <div class="entry-content mb-5">
                     <div class="text-part">
                        <h4 class="title"> {{ $result->title }} </h4>
                        <p class="description">{!! $result->description !!}</p>
                        <article class="post media-post clearfix">
                           <a class="post-thumb" href="javascript:;">
                           <img src="{{ asset('/storage/'.$result->user->avtar) }}" alt="" class="rounded-circle">
                           </a>
                           <div class="post-right">
                              <div class="row">
                                 <div class="col-md-6">
                                    <h6 class="post-title">
                                       <a href="javascript:;"> {{ $result->user->name }} </a>
                                    </h6>
                                    <span class="post-date">
                                    <time class="entry-date" >Published on {{ date('F d, Y', strtotime($result->created_at)) }}</time>
                                    </span>
                                 </div>
                                 <div class="col-md-6 text-left text-lg-right text-md-right mt-2 mt-lg-0 mt-md-0">
                                    <div class="social-share-icons">
                                       <div class="title">
                                          <i class="fa fa-share-alt"></i> Share On : 
                                       </div>
                                       <ul class="styled-icons">
                                          <li><a target="blank" href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $result->title }}"><i class="fa fa-twitter"></i></a></li>
                                          <li><a target="blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"><i class="fa fa-facebook"></i></a></li>
                                          <li class="pr-0"><a target="blank" href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $result->title }}"><i class="fa fa-linkedin"></i></a></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>

                              <div class="row">
                                 <div class="col-md-12">
                                    <ul class="cat-blogs">
                                       @forelse($result->business_types as $bs)
                                       <li class="cat-item">
                                          <a href="{{ url('resource/category/'.$bs->slug) }}">
                                             <i class="fa fa-tag" aria-hidden="true"></i> {{ $bs->business_type }}
                                          </a>
                                       </li>
                                       @empty
                                       @endforelse
                                    </ul>
                                 </div>
                                 
                              </div>

                           </div>
                        </article>
                     </div>
                  </div>
               </article>
            </div>
            <div class="col-lg-3 wow fadeInRight">
              
               <div class="section-header mt-3">
                  <h4>Other services we offered</h4>
               </div>
               <div class="resources-list mb-5">
                  @foreach($similar_post as $post)
                  <article class="post media-post clearfix">
                     <a class="post-thumb" href="{{ $post->slug() }}"><img src="{{ asset('storage/'.$post->banner_image) }}" alt=""></a>
                     <div class="post-right">
                        <h6 class="post-title"> 
                           <a href="{{ $post->slug() }}">  
                           {{ $post->title }}
                           </a>
                        </h6>
                        <span class="post-date">
                        <time class="entry-date" >{{ date('F d, Y', strtotime($post->created_at)) }} </time>
                        </span>
                     </div>
                  </article>
                  @endforeach
               </div>
               
            </div>
         </div>
      </div>
   </section>
</main>
@endsection