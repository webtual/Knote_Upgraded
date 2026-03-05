{{-- <a href="{{ url('blog/'.$blog->slug()) }}" id="{{ $blog->id }}">
   <div class="col-lg-4">
      <div class="box wow fadeInLeft">
         <div class="icon">
            <img src="{{ asset('storage/'.$blog->main_image) }}" />
         </div>
         <div class="text-part">
            <h4 class="title">
               {{ $blog->title }}
            </h4>
            <p class="description">
               {!! $blog->description !!}
            </p>
            <div class="blog-border-ctm">
               <ul class="entry-meta list-inline ">
                  <li class="posted-date pull-left mt-2"><i class="fa fa-calendar-o"></i> <a href="#" rel="bookmark">
                     <time class="entry-date" datetime="2018-11-27T05:56:16+00:00"> November 27, 2018</time>
                     </a>
                  </li>
                  <li class="categories pull-right mt-2"><i class="fa fa-folder-o"></i> <span class="categories-links"><a href="#" rel="category tag"> business</a></span></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</a> --}}

<div class="row mb-5 blog-row" id="{{ $blog->id }}">
   <div class="col-md-5">
      <div class="blog-img">
         <a href="{{ url('blog/'.$blog->slug()) }}">
         <img src="{{ asset('storage/'.$blog->main_image) }}" alt="" class="img-fluid"/>
         </a>
      </div>
   </div>
   <div class="col-md-7">
      <div class="post-right-side blog-style-medium">
         <h4>
            <a href="{{ url('blog/'.$blog->slug()) }}">
            <strong>{{ $blog->title }}</strong>
            </a>
         </h4>
         <ul   class="post-meta post-meta-one list-inline">
            <li class="list-inline-item">
               <span class="post-meta-author">
               By <a href="{{ url('blog/'.$blog->slug()) }}" class="bypostauthor">
               {{ $blog->user->name }}            
               </a>
               </span>
            </li>
            <li class="list-inline-item posted-date">
               <i class="fa fa-calendar-o"></i> 
               <a href="{{ url('blog/'.$blog->slug()) }}" rel="bookmark">
               <time class="entry-date" datetime=""> {{ date('F d, Y', strtotime($blog->created_at))  }}</time>
               </a>
            </li>
         </ul>
         <div class="post-content">
            <p>
              {!! str_limit(strip_tags($blog->description), $limit = 210, $end = '...') !!}
            </p>
         </div>
         <div class="post-meta post-meta-two">
            <div class="sh-columns post-meta-comments">
               <div class="row">
                  <div class="col-6">
                     {{-- <span class="post-meta-categories">
                     <i class="fa fa-folder-o"></i>
                     <span class="categories-links">
                        <a href="javascript:;" rel="category tag"> {{ $blog->category->name }}</a></span>
                     </span> --}}
                  </div>
                  <div class="col-6">
                     <div class="read-txt text-right">
                        <a href="{{ url('blog/'.$blog->slug()) }}">READ <i class="fa fa-long-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>