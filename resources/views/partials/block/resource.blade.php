<a href="{{ url('resource/'.$resource->slug()) }}" id="{{ $resource->id }}">
   <div class="icon">
      <a href="{{ url('resource/'.$resource->slug()) }}">
         <img src="{{ asset('storage/'.$resource->banner_image) }}" />
      </a>
      {{-- 
      <div class="bs-cat">
         <i class="fa fa-folder-o"></i> 
         <span class="categories-links">
            <a href="javascript:;" rel="category tag">{{ $resource->business_type->business_type }}</a>
         </span>
      </div> --}}
   </div>
   <div class="text-part">
      <a href="{{ url('resource/'.$resource->slug()) }}">
         <h4 class="title">
            {{ $resource->title }}
         </h4>
      </a>
      <p class="description">
         @if(Route::currentRouteName() == 'root')
         {!! str_limit(strip_tags($resource->description), $limit = 115, $end = '...') !!}
         @elseif( (Route::currentRouteName() == 'resource') || (Route::currentRouteName() == 'resource.filter') || (Route::currentRouteName() == 'dashboard') )
            {!! str_limit(strip_tags($resource->description), $limit = 55, $end = '...') !!}
         @else
         {!! $resource->description !!}
         @endif
      </p>
      <div class="row cat-time">
         <div class="col-6 col-md-6">
            <span class="categories-links"><i class="fa fa-clock-o"></i> {{ $resource->time_ago() }}</span>
         </div>
         <div class="col-6 text-right">
            <div class="r-n">
               <span>{{ $resource->money_format_amount() }}</span>
            </div>
         </div>
      </div>
      <div class="row amount-target">
         <div class="col-6">
            <h4 class="title">
               <div class="logo-sec">
                  <img src="{{ asset('storage/'.$resource->user->first()->avtar) }}" />
               </div>
               <a href="{{ url('resource/'.$resource->slug()) }}">{{ $resource->user->first()->name }}</a>
            </h4>
         </div>
         <div class="col-6 col-md-6 text-right read-txt">
            <a href="{{ url('resource/'.$resource->slug()) }}">READ <i class="fa fa-long-arrow-right"></i></a>  
         </div>
      </div>
   </div>
</a>