<div class="card-box mb-2">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="media">
                <img class="d-flex align-self-center mr-3" src="{{ asset('storage/'.$bs->banner_image) }}" alt="Generic placeholder image" height="64">
                <div class="media-body">
                    <h4 class="mt-0 mb-2 font-16"><a href="{{ url('admin/business-proposal/'.$bs->slug()) }}">{{ $bs->title }}</a>
                    </h4> 
                    <p class="mb-1"><span><b>{{ $bs->money_format_target() }}</b> Target</span></p>
                    <p class="mb-1"><span><b>{{ $bs->money_format_min_per_investor() }}</b> Min per Investor</span></p>
                    <p class="mb-0"><i class="fe-map-pin"></i> {{ $bs->location }} <span></span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="text-center my-3 my-sm-0">
                <p class="mb-0 text-muted">{{ $bs->time_ago() }}</p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="text-center button-list">

                <div class="btn-group btn-xs mb-2">
                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{ config('constants.approval_status')[$bs->is_approved] }} <i class="mdi mdi-chevron-down"></i></button>
                    <div class="dropdown-menu">
                        
                        @foreach(config('constants.approval_status') as $key_status => $status)
                            @if($key_status != $bs->is_approved)
                                <a class="dropdown-item update-status-bs" href="javascript:;" data-url="{{ url('admin/business-proposals/'.$bs->slug().'/status/'.$key_status) }}">{{ $status }}</a>
                            @endif
                        @endforeach

                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="col-sm-2">
            <div class="text-sm-right text-center mt-2 mt-sm-0">
                <form id="form-{{ $bs->id }}" action="{{url('business-proposals/'.$bs->id)}}" class="cu-inline-block" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                </form>
                <a title="Delete" href="javascript:;" class="btn btn-xs btn-danger del-confirm mr-2" data-id="{{ $bs->id }}"> <i class="mdi mdi-delete"></i></a>
                <a title="Edit" href="{{ url('business-proposals/'.$bs->slug().'/edit') }}" class="btn btn-xs btn-success"><i class="mdi mdi-pencil"></i></a>

                


            </div>
        </div> <!-- end col-->
    </div> 
</div>