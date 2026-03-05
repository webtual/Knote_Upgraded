
<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="dripicons-cross noti-icon"></i>
        </a>
        <h5 class="m-0 text-white">Settings</h5>
    </div>
    <div class="slimscroll-menu">
        <!-- User box -->
        <div class="user-box">
            <div class="user-img">
                <img src="{{ asset('storage/'.Auth::user()->avtar) }}" alt="user-img" title="{{ ucfirst(Auth::user()->name) }}" class="rounded-circle img-fluid user-avtar ">
                @if(Auth::user()->roles()->first()->type == 0)
                    <a href="{{ url('my-profile') }}" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                @else
                    <a href="{{ url('admin/my-profile') }}" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                @endif

            </div>
    
            <h5><a href="javascript: void(0);">{{ ucfirst(Auth::user()->name) }}</a> </h5>
            <p class="text-muted mb-0"><small>{{ ucfirst(Auth::user()->roles()->first()->role_name) }}</small></p>
        </div>

        <!-- Settings -->
        <hr class="mt-0" />
        <h5 class="pl-3">Basic Settings</h5>
        <hr class="mb-0" />

        <div class="p-3">
            <div class="checkbox checkbox-success mb-2">
                <input id="Rcheckbox1" type="checkbox" checked>
                <label for="Rcheckbox1">
                    Notifications
                </label>
            </div>
            <div class="checkbox checkbox-success mb-2">
                <input id="Rcheckbox2" type="checkbox" checked>
                <label for="Rcheckbox2">
                    Email Alert
                </label>
            </div>
            <div class="checkbox checkbox-success mb-2">
                <input id="Rcheckbox3" type="checkbox">
                <label for="Rcheckbox3">
                    SMS Alert
                </label>
            </div>
        </div>

    </div> <!-- end slimscroll-menu-->
</div>
