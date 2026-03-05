@extends('layouts._landing_master')
@section('title', 'Knote - Blogs')
@section('content')
<main id="main">
	<section class="rs-details">
         <div class="container pt-5 pb-5">
            <div class="breadcrumbs">
               <span>
               <a href="{{ url('/') }}"><span>Home</span></a>  
               </span>
               <span><i class="fa fa-angle-right"></i></span>
               <span>
               <a href="{{ url('blogs') }}"><span>Blogs </span></a>  
               <span><i class="fa fa-angle-right"></i></span> 
               <a href="javascript:;"><span class="active"> {{ $result->title }} </span></a>   
               </span>
            </div>
            <div class="row">
               <div class="col-lg-9">
                  <article>
                     <div class="entry-header entry-content">
                           <h4 class="title"> {{ $result->title }} </h4>
                           <article class="post media-post clearfix">
                              <a class="post-thumb" href="javascript:;">
                                 <img src="{{ asset('/storage/'.$result->user->avtar) }}" alt="" class="rounded-circle"></a>
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
                                             <li><a  target="blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"><i class="fa fa-facebook"></i></a></li>
                                             <li class="pr-0"><a  target="blank" href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $result->title }}"><i class="fa fa-linkedin"></i></a></li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                           </article>
                        <div class="post-thumb thumb"> 
                           <img src="{{ asset('storage/'.$result->main_image) }}" alt="" class="img-fluid"> 
                        </div>
                     </div>
                     <div class="entry-content mb-1">
                        <div class="text-part mt-4">
                           <p class="description">{!! $result->description !!}</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <ul class="cat-blogs">
                              @forelse($result->category as $category)
                              <li class="cat-item">
                                 <a href="{{ url('blogs/category/'.$category->slug) }}"><i class="fa fa-tag" aria-hidden="true"></i> 
                                    {{ $category->name }}
                                 </a>
                              </li>
                              @empty
                              @endforelse
                           </ul>
                        </div>
                     </div>
                  </article>
               </div>
               <div class="col-lg-3">
                  
                 

                  <div class="section-header mt-4">
                     <h4>Similar Posts</h4>
                  </div>
                  <div class="resources-list mb-5">
                     @foreach($similar_blogs as $blog)
                     <article class="post media-post clearfix">
                        <a class="post-thumb" href="{{ $blog->slug() }}">
                           <img src="{{ asset('storage/'.$blog->main_image) }}" alt="">
                        </a>
                        <div class="post-right">
                           <h6 class="post-title"> 
                              <a href="{{ $blog->slug() }}"> {{ $blog->title }}  </a>
                           </h6>
                        
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