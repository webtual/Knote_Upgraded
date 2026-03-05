<div class="card" id="{{ $resource->id }}">
   <div class="img-container">
      <img class="card-img-top img-fluid" src="{{ asset('storage/'.$resource->banner_image) }}" alt="{{ $resource->slug() }}">
      
      @if( (auth()->user()->id == $resource->user_id) && (Route::currentRouteName() != 'resource.show') && (!Gate::allows('isAdminUser'))  )
         <div class="overlay">
             <div class="d-inline">
               <form id="form-{{ $resource->id }}" action="{{url('resource/'.$resource->id)}}" class="cu-inline-block" method="POST">
                 {{ method_field('DELETE') }}
                 {{ csrf_field() }}
                 
               </form>
               <a title="Delete" href="javascript:;" class="btn btn-xs btn-danger del-confirm mr-2" data-id="{{ $resource->id }}"> <i class="mdi mdi-delete"></i></a>
             
             </div>
             <div class="d-inline">
               <a title="Edit" href="{{ url('resource/'.$resource->slug().'/edit') }}" class="btn btn-xs btn-success"><i class="mdi mdi-pencil"></i></a>
             </div>
         </div>
      @elseif( (Gate::allows('isAdminUser')) && (Route::currentRouteName() != 'resource.show') )
        <div class="overlay">
             <div class="d-inline">
               <form id="form-{{ $resource->id }}" action="{{url('admin/resource/'.$resource->id)}}" class="cu-inline-block" method="POST">
                 {{ method_field('DELETE') }}
                 {{ csrf_field() }}
                 
               </form>
               <a title="Delete" href="javascript:;" class="btn btn-xs btn-danger del-confirm mr-2" data-id="{{ $resource->id }}"> <i class="mdi mdi-delete"></i></a>
             
             </div>
             <div class="d-inline">
               <a title="Edit" href="{{ url('admin/resource/'.$resource->slug().'/edit') }}" class="btn btn-xs btn-success"><i class="mdi mdi-pencil"></i></a>
             </div>
         </div>
      @endif

   </div>

  <div class="card-body">
      <h5 class="card-title text-capitalize">
        @if(Gate::allows('isAdminUser'))
          <a style="color: #343a40;" href="{{ url('admin/resource/'.$resource->slug()) }}">{{ $resource->title }}</a>
        @else
          <a style="color: #343a40;" href="{{ url('resource/'.$resource->slug()) }}">{{ $resource->title }}</a>
        @endif

        
        @if( (auth()->user()->id == $resource->user_id) || (Gate::allows('isAdminUser')) )
            <span class="badge font-10 bg-soft-dark float-right text-dark p-1"> {{ config('constants.approval_status')[$resource->is_approved] }} </span>
        @else
          @canany(['isLoanApplicant', 'isEntrepreneur', 'isInvestor'])
             @if($resource->user_is_favourite == null)
                <a href="javascript:void(0);" data-url="{{ url('resource/favourite/create') }}" class="card-link text-custom fvr-resource">
                   <i class="mdi mdi-star-outline mdi-24px float-right"></i> 
                </a>
             @else
                <a href="javascript:void(0);" data-url="{{ url('resource/favourite/create') }}" class="card-link text-custom fvr-resource">
                   <i class="mdi mdi-star mdi-24px float-right"></i> 
                </a>
             @endif
          @endcanany
        @endif

      </h5>
      {{-- <h6 class="card-subtitle text-muted mb-3">{{ $resource->business_type->business_type }}</h6> --}}
      <div class="description"> 
         <p class="card-text">
            @if(Route::currentRouteName() != 'resource.show')
               {!! str_limit(strip_tags($resource->description), $limit = 150, $end = '...') !!}
            @else
            {!! $resource->description !!}
            @endif
         </p>
      </div>

      <p class="card-text">
         <span ><b>{{ $resource->location }}</b> </span> 
         <span class="float-right"><b>{{ $resource->money_format_amount() }}</b> </span>
      </p>
      <p class="card-text">
         <small class="text-muted"><i class="mdi mdi-timer"></i> {{ $resource->time_ago() }}</small>
      </p>         
  </div>
</div>
   
