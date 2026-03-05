@extends('layouts._comman')
@section('title', 'My Profile - Knote')
@section('styles')
   <link rel="stylesheet" href="{{ asset('comman/css/cropme.css') }}">
@endsection
@section('content')
   <div class="content">
      <!-- Start Content-->
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="page-title-box">
                  <div class="page-title-right">
                     <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">My Profile</li>
                     </ol>
                  </div>
                  <h4 class="page-title">My Profile</h4>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <form action="{{ route('my.profile.update') }}" id="personal-information" name="personal-information"
                  method="post" onsubmit="return false;" enctype="multipart/form-data">
                  @csrf
                  <div class="card-box d-none" id="my-profile-text">
                     <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Personal Information</h5>
                     <div class="form-group mb-3">
                        <label for="">Fullname<span class="text-danger">*</span></label>
                        <input type="text" id="" name="fullname" value="{{ auth()->user()->name }}" class="form-control"
                           placeholder="Fullname">
                     </div>
                     <div class="form-group mb-3">
                        <label for="">Email Address<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="" class="form-control" placeholder="Email Address"
                           value="{{ auth()->user()->email }}" readonly="readonly">
                     </div>
                     <div class="form-row">
                        <div class="form-group col-md-1">
                           <label for="">Phone<span class="text-danger">*</span></label>
                           <input type="text" class="form-control" name="countrycode" id="country-code" value="+61"
                              readonly="readonly" placeholder="+61">
                        </div>
                        <div class="form-group mb-3 col-md-11">
                           <label for="">&nbsp;</label>
                           <input type="text" name="phone" value="{{ auth()->user()->phone }}" id="" class="form-control"
                              placeholder="Phone" readonly="readonly">
                        </div>
                     </div>
                     <div class="form-group mb-3">
                        <label>Address</label>
                        <textarea class="form-control" rows="3" name="address"
                           placeholder="Address">{{ auth()->user()->address }}</textarea>
                     </div>
                     <div class="form-group mb-3 cropme-div">
                        <label for="example-fileinput">Profile Picture</label>
                        <input type="file" id="profile_picture" class="form-control-file" data-width="200"
                           data-height="200" data-type="square">
                        <input type="hidden" name="profile_picture" class="form-control-file">
                     </div>
                     {{-- <div class="form-group mb-0">
                        <label>About Us</label>
                        <textarea class="form-control" rows="3" name="about"
                           placeholder="About us">{{ auth()->user()->about }}</textarea>
                     </div> --}}
                     <button class="btn btn-primary mt-3" type="submit" id="update-personal-information">Save</button>
                     <!--<button type="reset" class="btn btn-secondary mt-3 ml-2">Cancel</button>-->
                  </div>

                  <div class="card-box" id="my-profile-show">
                     <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Personal Information
                        <a href="javascript:;" class=" font-15" id="personal-info-text"><u>Edit</u></a>
                        <!--<a href="my-profile#change-password" class=" font-15"><u>Change Password</u></a>-->
                     </h5>
                     <img src="{{ asset('storage/' . Auth::user()->avtar) }}" class="rounded-circle avatar-lg img-thumbnail"
                        alt="profile-image">
                     <div class="text-left mt-3">
                        <h4 class="font-13 text-uppercase">About Us :</h4>
                        <p class="text-muted font-13 mb-3">
                           {{ auth()->user()->about }}
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Fullname :</strong> <span class="ml-2">
                              {{ auth()->user()->name }}
                           </span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Email Address :</strong><span
                              class="ml-2">{{ auth()->user()->email }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Phone :</strong><span
                              class="ml-2">{{ auth()->user()->phone }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Address :</strong><span
                              class="ml-2">{{ auth()->user()->address }}</span></p>
                     </div>
                  </div>
               </form>
               <!-- end card-box -->
            </div>
         </div>
         $('#personal-info-text').click(function(){
         $('#my-profile-show').addClass('d-none');
         $('#my-profile-text').removeClass('d-none');
         });
         </script>
@endsection