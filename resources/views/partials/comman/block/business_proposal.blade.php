<div class="card" id="{{ $bs->id }}">
   <div class="card-body">
      <h5 class="card-title text-capitalize">
         @if(Gate::allows('isAdminUser'))
         <a style="color: #343a40;" href="{{ url('admin/business-proposal/'.$bs->slug()) }}">{{ $bs->title }}</a>
         @else
         <a style="color: #343a40;" href="{{ url('business-proposal/'.$bs->slug()) }}">{{ $bs->title }}</a>
         @endif
         
         @if( (auth()->user()->id == $bs->user_id) || (Gate::allows('isAdminUser')) )
            <span class="badge font-10 bg-soft-dark float-right text-dark p-1"> {{ config('constants.approval_status')[$bs->is_approved] }} </span>
         @else
            @canany(['isLoanApplicant', 'isEntrepreneur', 'isInvestor'])
               @if($bs->user_is_favourite == null)
               <a href="javascript:void(0);" class="card-link text-custom fvr-bs" data-url="{{ url('business-proposal/favourite/create') }}">
               <i class="mdi mdi-star-outline mdi-24px float-right"></i> 
               </a>
               @else
               <a href="javascript:void(0);" data-url="{{ url('business-proposal/favourite/create') }}" class="fvr-bs card-link text-custom">
               <i class="mdi mdi-star mdi-24px float-right"></i> 
               </a>
               @endif
            @endcanany
         @endif
         
      </h5>
      {{-- <h6 class="card-subtitle text-muted">{{ $bs->business_type->business_type }}</h6> --}}
   </div>
   <div class="img-container">
      <img class="img-fluid" src="{{ asset('storage/'.$bs->banner_image) }}" alt="{{ $bs->slug() }}">
      @if( (auth()->user()->id == $bs->user_id) && (Route::currentRouteName() != 'business.proposals.show') && (!Gate::allows('isAdminUser')) )
      <div class="overlay">
         <div class="d-inline">
            <form id="form-{{ $bs->id }}" action="{{url('business-proposals/'.$bs->id)}}" class="cu-inline-block" method="POST">
               {{ method_field('DELETE') }}
               {{ csrf_field() }}
            </form>
            <a title="Delete" href="javascript:;" class="btn btn-xs btn-danger del-confirm mr-2" data-id="{{ $bs->id }}"> <i class="mdi mdi-delete"></i></a>
         </div>
         <div class="d-inline">
            <a title="Edit" href="{{ url('business-proposals/'.$bs->slug().'/edit') }}" class="btn btn-xs btn-success"><i class="mdi mdi-pencil"></i></a>
         </div>
      </div>
      


      @elseif( (Gate::allows('isAdminUser')) && (Route::currentRouteName() != 'business.proposals.show') )
      <div class="overlay">
         <div class="d-inline">
            <form id="form-{{ $bs->id }}" action="{{url('admin/business-proposals/'.$bs->id)}}" class="cu-inline-block" method="POST">
               {{ method_field('DELETE') }}
               {{ csrf_field() }}
            </form>
            <a title="Delete" href="javascript:;" class="btn btn-xs btn-danger del-confirm mr-2" data-id="{{ $bs->id }}"> <i class="mdi mdi-delete"></i></a>
         </div>
         <div class="d-inline">
            <a title="Edit" href="{{ url('admin/business-proposals/'.$bs->slug().'/edit') }}" class="btn btn-xs btn-success"><i class="mdi mdi-pencil"></i></a>
         </div>
      </div>
      @endif
   </div>
   <div class="card-body">
      <div class="description">
         <p class="card-text">
            @if(Route::currentRouteName() != 'business.proposals.show')
            {!! str_limit(strip_tags($bs->description), $limit = 150, $end = '...') !!}
            @else
            {!! $bs->description !!}
            @endif
         </p>
      </div>
      <p class="card-text">
         <span><b>{{ $bs->money_format_target() }}</b> Target</span>
         <span class="float-right"><b>{{ $bs->money_format_min_per_investor() }}</b> Min per Investor</span> 
      </p>
   </div>
   <ul class="list-group list-group-flush">
      <li class="list-group-item"><i class="fe-map-pin"></i> {{ $bs->location }} <span><small class="text-muted  float-right"><i class="mdi mdi-timer"></i> {{ $bs->time_ago() }}</small></span></li>
   </ul>
</div>