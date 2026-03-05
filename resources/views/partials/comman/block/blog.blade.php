<div class="card" id="{{ $blog->id }}">
    <img class="card-img-top img-fluid" src="{{ asset('storage/'.$blog->main_image) }}" alt="Card image cap">
    <div class="card-body">
        <h5 class="card-title text-capitalize">
          <a style="color: #343a40;" href="{{ url('blog/'.$blog->slug()) }}">{{ $blog->title }}</a>
        </h5>
        <div class="description"> 
            <p class="card-text">
                @if(Route::currentRouteName() != 'blog.show')
                    @if(Gate::allows('isAdminUser'))
                        {!! str_limit(strip_tags($blog->description), $limit = 110, $end = '...') !!}
                    @else
                        {!! str_limit(strip_tags($blog->description), $limit = 150, $end = '...') !!}
                    @endif
                @else
                {!! $blog->description !!}
                @endif
            </p>
        </div>
    </div>
    {{-- 
    <ul class="list-group list-group-flush">
        <li class="list-group-item">Admin</li>
    </ul> 
    --}}
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <i class="fe-user"></i> {{ ($blog->user->name) }} 
            <span>
                <small class="text-muted  float-right">
                    <i class="mdi mdi-timer"></i> {{ $blog->time_ago() }}
                </small>
            </span>
        </li>
    </ul>
    
    <form id="form-{{ $blog->id }}" action="{{url('admin/blogs/'.$blog->id)}}" method="POST">
         {{ method_field('DELETE') }}
         {{ csrf_field() }}
    </form>

    <div class="card-body">
        <a title="Edit" href="{{ url('admin/blogs/'.$blog->slug().'/edit') }}" class="card-link text-custom">Edit</a>
        <a title="Delete" href="javascript:;" class="card-link text-custom float-right del-confirm" data-id="{{ $blog->id }}">Delete</a>
    </div>
</div>