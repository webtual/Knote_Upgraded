<a href="{{ url('business-proposal/'.$bs->slug()) }}" id="{{ $bs->id }}">
   
   <div class="icon call-closest" data-url="{{ url('business-proposal/'.$bs->slug()) }}" style=" background-image: url({{ asset('storage/'.$bs->banner_image) }}); background-size: cover; background-repeat: no-repeat; cursor: pointer;">
      <img src="{{ asset('storage/'.$bs->logo_image) }}" />
      <div class="bs-cat d-none">
         <i class="fa fa-folder-o"></i>
         <span class="categories-links">
            <a href="javascript:;" rel="category tag">{{-- {{ $bs->business_type->business_type }} --}}</a>
         </span>
      </div>
   </div>
   <div class="text-part call-closest cursor-pointer"  data-url="{{ url('business-proposal/'.$bs->slug()) }}">
      
      <h4 class="title">{{ $bs->title }}</h4>
      
      <p class="location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $bs->location }}</p>
      <p class="description">
      @if(Route::currentRouteName() == 'root')
            {!! str_limit(strip_tags($bs->description), $limit = 115, $end = '...') !!}
      @elseif( (Route::currentRouteName() == 'business.proposals') || (Route::currentRouteName() == 'business.proposals.filter') || (Route::currentRouteName() == 'dashboard')  )
            {!! str_limit(strip_tags($bs->description), $limit = 55, $end = '...') !!}
      @else
            {!! $bs->description !!}
      @endif
      </p>
      <div class="row amount-target">
         <div class="col-6 col-md-6">
            <div class="r-n">
               <strong>{{ $bs->money_format_target() }}</strong><br/>
               <span>Target</span>
            </div>
         </div>
         <div class="col-6 col-md-6">
            <div class="r-n">
               <strong>{{ $bs->money_format_min_per_investor() }}</strong><br/>
               <span>Min per Investor</span>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-6 col-md-6">
            <i class="fa fa-clock-o"></i>
            <span class="categories-links">
               <span rel="time tag" class="text-muted">{{ $bs->time_ago() }}</span>
            </span>
         </div>
         <div class="col-6 col-md-6 text-right read-txt">
            <a href="{{ url('business-proposal/'.$bs->slug()) }}">READ <i class="fa fa-long-arrow-right"></i></a>  
         </div>
      </div>

      {{--  
      <div class="btn-part">
         <a class="btn btn-primary more-btn" href="{{ url('business-proposal/'.$bs->slug()) }}">Find Out More</a>
      </div> --}}
   </div>
</a>