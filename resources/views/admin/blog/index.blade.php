@extends('layouts._comman')
@section('title', 'Blogs - Knote')
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
                     <li class="breadcrumb-item active">Blogs</li>
                  </ol>
               </div>
               <h4 class="page-title">Blogs ({{ App\Blog::count() }})</h4>
            </div>
         </div>
      </div>
      
      @include('partials.comman.alert.message')
      

      <div class="row blog-list" id="my-list">
         @if(!empty($blogs))
            @foreach($blogs as $blog)
               <div class="col-lg-6 col-xl-3 blog-row" id={{ $blog->id }}>
                  @include('partials.comman.block.blog', ['blog' => $blog])
               </div>
            @endforeach
         @endif
      </div>
      <div class="row mb-5 d-none" id="my-loadmore">
         <div class="col-md-12">
            <div class="text-center">
               <a href="javascript:;" id="blog-loadmore" data-url="{{ url()->current() }}" class="text-success font-18 "><i class="mdi mdi-spin mdi-loading mr-1 my-loader d-none"></i> LoadMore </a>
            </div>
         </div>
      </div>

   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
@endsection