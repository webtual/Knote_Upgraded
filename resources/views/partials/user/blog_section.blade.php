<section id="blog" class="pt-4 pb-2">
   <div class="container">
      <div class="section-header">
         <h2><a class="sec-title-block" href="{{ url('blogs') }}">Blog</a></h2>
      </div>
      @php
      $blog = App\Blog::orderBy('id', 'Desc')->first();
      @endphp

      @if($blog->count() != 0)
      <div class="row">
         <div class="col-xl-8">
            <a href="{{ url('blog/'.$blog->slug()) }}">
               <div class="blog-image">
                  <img src="{{ asset('storage/'.$blog->main_image) }}" class="img-fluid">
               </div>
            </a>
            <div class="blog-content-area">
               {{-- 
                  <div class="categories">
                     <a href="javascript:;"><i class="fa fa-folder-o"></i> Finance</a>
                  </div> 
               --}}
               <div class="blog-title">
                  <a href="{{ url('blog/'.$blog->slug()) }}">
                     <h4>
                        {{ $blog->title }}
                     </h4>
                  </a>
               </div>
               <div class="blog-desc">
                  {!! str_limit(strip_tags($blog->description), $limit = 270, $end = '...') !!}
               </div>
               <div class="blog-action text-right read-txt">
                  <a href="{{ url('blog/'.$blog->slug()) }}">READ <i class="fa fa-long-arrow-right"></i></a>
               </div>
            </div>
         </div>
         <div class="col-xl-4">
            <div class="latest-blog-section">
               <h5>LATEST BLOG</h5>
               @php
               $blogs = App\Blog::skip(1)->take(5)->orderBy('id', 'Desc')->get();
               @endphp
               @if($blogs->count() != 0)
                  @foreach($blogs as $blog)
                  <div class="blog-list">
                     <div class="blog-item-container">
                        <div class="blog-row">
                           <div class="latest-blog-img">
                              <a class="post-thumb" href="{{ url('blog/'.$blog->slug()) }}">
                                 <img src="{{ asset('storage/'.$blog->main_image) }}" alt="" class="img-fluid">
                              </a>
                           </div>
                           <div class="blog-infor">
                              <div class="latest-blog-content">
                                 <div class="ellipsis">
                                    <h5>
                                       <a href="{{ url('blog/'.$blog->slug()) }}">
                                       {{ $blog->title }}
                                       </a> 
                                    </h5>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="blog-row">
                           <div class="latest-blog-bottom-area">
                              <div class="publication-date">
                                 <div class="latest-blog-date">{{ date('d M, Y', strtotime($blog->created_at))  }}</div>
                                 <div class="read-txt text-right">
                                    <a href="{{ url('blog/'.$blog->slug()) }}">READ <i class="fa fa-long-arrow-right"></i></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               @endif
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12 text-right read-txt mb-5">
            <a class="" href="{{ url('blogs') }}">VIEW MORE <i class="fa fa-long-arrow-right"></i></a>
         </div>
      </div>
      @endif
   </div>
</section>