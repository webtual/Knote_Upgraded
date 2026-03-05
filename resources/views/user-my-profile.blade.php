@extends('layouts._comman')
@section('title', 'My Profile - Knote')
@section('styles')
@if(request()->is('loan*') || request()->is('edit-profile*'))
    <link href="{{ cached_asset('comman/css/loan-application.css') }}" rel="stylesheet">
    <link href="{{ asset('comman/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <style>
        .mh-auto{
            min-height: auto !important;
        }
    </style>
@endif
@endsection
@section('content')
<div class="content">
    <div class="container-fluid document-page">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card-box mh-auto">
                    <!--<h3>Edit Profile</h3>-->
                    <div class="tab-content pt-0">
                        <div class="tab-pane active" id="settings">
                            <form action="{{ route('user.my.profile.update') }}" id="personal-information" name="personal-information" method="post" onsubmit="return false;" enctype="multipart/form-data">
                                @csrf
                               <div class="card-box mh-auto" id="my-profile-text">
                                  <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Personal Information</h5>
                                    <div class="form-group mb-3">
                                        <label for="">Full Name<span class="text-danger">*</span></label>
                                        <input type="text" id="" name="fullname" value="{{ auth()->user()->name }}" class="form-control" placeholder="Fullname">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Email Address<span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="" class="form-control" placeholder="Email Address" value="{{ auth()->user()->email }}">
                                    </div>
                                    <div class="form-row">
                                        <label for="">Phone<span class="text-danger">*</span></label>
                                        <input type="text" name="phone" value="{{ display_aus_phone(auth()->user()->phone) }}"  id="" class="form-control" placeholder="Phone" readonly="readonly">
                                    </div>
                                    <div class="form-row">
                                        <button class="btn btn-success waves-effect waves-light mt-2" type="submit" id="update-personal-information">Update</button>
                                    </div>
                               </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@if(request()->is('loan*') || request()->is('edit-profile*'))
<script src="{{ asset('comman/js/pages/ion.rangeSlider.min.js') }}"></script>
@endif
@endsection