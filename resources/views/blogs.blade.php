@extends('layouts._landing_master')
@section('title', 'Knote - Blogs')
@section('content')
<main id="main">
   <div id="header-banner" style="background-image: url({{ asset('/storage/resource/dchi_bg.jpg') }})">
      @include('partials.user.header_menu')
      <div class="bs-prop-bg pt-5 pb-5">
         <div class="container text-center">
            <h2 class="title">Blogs</h2>
            <div class="breadcrumbs">
               <span>
               <a href="{{ url('/') }}"><span>Home</span></a>  
               </span>
               <span><i class="fa fa-angle-right"></i></span>
               <span>
               <a href="javascript:;"><span class="active">Blogs </span></a>   
               </span>
            </div>
         </div>
      </div>
   </div>
   <section id="blog">
      
      <div class="container pt-lg-5 pt-4 pb-5">
         <div class="row">
            <div class="col-lg-3">
               <div id="categories-2" class="widget widget_categories">
                  <div class="section-header">
                     <h4 class="widget-title widget-title-line-bottom line-bottom-theme-colored1">Categories</h4>
                  </div>

                     <div id="sep-checkbox-blogs">
                     @foreach($blog_categories as $key_cat => $category)
                        <div class="checkbox checkbox-success">
                           <input type="checkbox" data-slug="{{ $category->slug }}" name="category[]" id="inlineCheckbox{{ $key_cat }}" value="{{ $category->id }}" class="blog-checkbox my-cu-check-uncheck-array">
                           <label for="inlineCheckbox{{ $key_cat }}"> {{ $category->name }} </label>
                       </div>
                     @endforeach
                  </div>
               </div>
            </div>

            <div class="col-lg-9" id="my-list" data-url="{{ url('blogs') }}" data-current-url="{{ url()->current() }}">
               @if($blogs->count() != 0)
                  @foreach($blogs as $blog)
                     @include('partials.block.blog', ['blog' => $blog])
                  @endforeach
               @endif
               @if($blogs->count() >= 9)
                  <div class="text-center read-txt d-none" id="my-loadmore">
                     <a href="javascript:;" class="" id="blog-loadmore" data-url="{{ url('blogs') }}">LOAD MORE <i class="fa fa-long-arrow-right"></i></a>
                  </div>
               @endif
            </div>
          
         </div>
      </div>
   </section>
</main>
@endsection

