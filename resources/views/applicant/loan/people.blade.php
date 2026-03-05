@extends('layouts._comman')
@section('title', 'Create New Loan Application - Knote')
@section('styles')
@if(request()->is('loan*'))
 <link href="{{ cached_asset('comman/css/loan-application.css') }}" rel="stylesheet">
<link href="{{ asset('comman/css/bootstrap-datepicker.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css" media="screen">
    .loan-form-page .select2-container--default .select2-selection--single {height: calc(1.5em + 0.9rem + 2px);padding: 5px;border: 1px solid #ccc;}
	.loan-form-page .select2-container--default .select2-selection--single .select2-selection__arrow{top: 5px;}
	.loan-form-page .select2-container--default .select2-selection--single .select2-selection__rendered {color: #444444b8;}
   .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {background-color: #2eab99 !important;color: white;}
    hr {border-top: 2px solid #1369589e;}
    .datepicker td, .datepicker th{width: 32px;height: 30px;}
</style>
@endif
@endsection
@section('content')
<div class="content loan-form-page">
   <!-- Start Content-->
   <div class="container-fluid">
      <div class="row my-2">
          <div class="col-md-5 col-xl-3 ">
             <div class="card-box color-knote cu-applisidebar cleft">
               <h3 class="text-white text-uppercase">Start application </h3>
               <div class="tab-content">
                   @include('partials.comman.loan.leftsidebar')
               </div>
            </div> 
           
         </div>
         <div class="col-md-7 col-xl-6">
            <div class="card-box">
               <h3 class="">Applicant/Director/Proprietor</h3>
               <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                     <form action="{{ url('create/people') }}" id="loan-application-second" name="loan-application-second" method="post" onsubmit="return false;">
                       
                        
                        @forelse($application->team_sizes as $key_team => $team)
                        <div class="additional_clone">
                           <h4 class="header-title mb-2">{{ $team->position }} Personal Information</h4>
                           <div class="row">
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="bs">Title <span class="text-danger">*</span></label>
                                    <select class="custom-select" name="title[]" id="title-{{ $key_team + 1 }}">
                                       <option value="">Select..</option>
                                       @foreach(config('constants.people_title') as $key => $title)
                                       <option value="{{ $key }}" {{ ($team->title == $key) ? 'selected' : '' }}>{{ $title }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="">First name <span class="text-danger"><span class="text-danger">*</span></span></label>
                                    <input type="text" class="form-control" id="" name="firstname[]" placeholder="First name" value="{{ $team->firstname }}">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">Last name <span class="text-danger"><span class="text-danger">*</span></span></label>
                                    <input type="text" class="form-control" id="" name="lastname[]" placeholder="Last name" value="{{ $team->lastname }}" >
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">Residential Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control buz_address" value="{{ $team->address }}" id="" name="address[]" placeholder="Residential Address">
                                    
                                    <!--<input type="hidden" id="street_number" name="street_number[]" value="{{ $team->street_number }}">
                                    <input type="hidden" id="street_name" name="street_name[]" value="{{ $team->street_name }}">
                                    <input type="hidden" id="street_type" name="street_type[]" value="{{ $team->street_type }}">
                                    <input type="hidden" id="locality" name="locality[]" value="{{ $team->locality }}">
                                    <input type="hidden" id="state" name="state[]" value="{{ $team->state }}">
                                    <input type="hidden" id="postcode" name="postcode[]" value="{{ $team->postcode }}">-->
                                    
                                 </div>
                              </div>
                              
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">Residential Status <span class="text-danger">*</span></label>
                                    <select class="custom-select" name="residential_status[]" id="residential_status-{{ $key_team + 1 }}">
                                       <option value="">Select..</option>
                                       @foreach(config('constants.residential_status') as $key => $ms)
                                       <option value="{{ $key }}" {{ ($team->residential_status == $key) ? 'selected' : '' }}>{{ $ms }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              
                           </div>
                           <div class="row">
                               <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="">DOB <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control p-date-picker date-field" name="dob[]" id="" placeholder="DOB"  value="{{ indian_date_format($team->dob) }}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Gender <span class="text-danger">*</span></label>
                                    <select class="custom-select" name="gender[]" id="gender-{{ $key_team + 1 }}">
                                        <option value="">Select..</option>
                                        @foreach(config('constants.gender') as $keys => $label)
                                            <option value="{{ $keys }}" {{ ($team->gender == $keys) ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="">Marital Status <span class="text-danger">*</span></label>
                                    <select class="custom-select" name="marital_status[]" id="marital_status-{{ $key_team + 1 }}">
                                       <option value="">Select..</option>
                                       @foreach(config('constants.marital_status') as $key => $ms)
                                       <option value="{{ $key }}" {{ ($team->marital_status == $key) ? 'selected' : '' }}>{{ $ms }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                             
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">Mobile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control phone-field" name="mobile[]" id="" placeholder="Mobile" value="{{ $team->mobile }}">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">Landline </label>
                                    <input type="text" class="form-control landline-field" name="landline[]" id="" data-mask="99 9999 9999" placeholder="Landline" value="{{ $team->landline }}">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">License Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="license_number[]" id="" placeholder="License Number" value="{{ $team->license_number }}">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">License Expiry Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control  expire-date-field" name="license_expiry_date[]" id="" value="{{ indian_date_format($team->license_expiry_date) }}" placeholder="License Expiry Date">
                                 </div>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email_address[]" id="" placeholder="Email Address" value="{{ $team->email_address }}">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">License Card Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control license-card-number-field" data-mask="AAAAAAAAAA" name="license_card_number[]" id="" placeholder="License Card Number" value="{{ $team->card_number }}">
                                 </div>
                              </div>
                              
                           </div>
                           
                           
                           <div class="row">
                               <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">Position <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="position[]" id="" placeholder="Position" value="{{ $team->position }}">
                                 </div>
                              </div>
                           
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">Time in Business <span class="text-danger">*</span></label>
                                    <select class="custom-select" name="time_in_business[]" id="time_in_business-{{ $key_team + 1 }}">
                                       <option value="" selected>Select..</option>
                                       @for($i=1; $i<=75; $i++)
                                       <option value="{{ $i }}" {{ ($i == $team->time_in_business) ? 'selected' : '' }}>{{ $i }} Years</option>
                                       @endfor
                                    </select>
                                 </div>
                              </div>
                            </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="">Time at Address <span class="text-danger">*</span></label>
                                    <select class="custom-select" name="time_at_business[]" id="time_at_business-{{ $key_team + 1 }}">
                                       <option value="" selected>Select..</option>
                                       @for($i=1; $i<=75; $i++)
                                       <option value="{{ $i }}" {{ ($i == $team->time_at_business) ? 'selected' : '' }}>{{ $i }} Years</option>
                                       @endfor
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <hr>
                           <div class="row">
                                
                                <div class="col-md-12">
                                    <a href="javascript: void(0);" class="{{ ($application->team_sizes->count() > 0) ? 'd-none' : '' }} remove_add_s btn btn-xs btn-danger float-right text-white">  <i class="mdi mdi-minus"></i>
                                    </a> 
                                    <a href="javascript: void(0);" class="{{ ($loop->last) ? '' : 'd-none' }} mr-2 rm-blk-add btn btn-xs btn-info add_more_additional float-right text-white">  <i class="mdi mdi-plus"></i> Add more Applicant/Director/Proprietor
                                    </a> 
                                </div>
                              
                           </div>
                        </div>
                        <input type="hidden" id="team-{{ $team->id }}" name="team_size_id[]" value="{{ $team->id }}">
                        
                           @if($loop->last)
                           <div class="up_add_clone">
                              
                           </div>
                           @endif
                        @empty

                      
                        <fieldset id="team_member">
                           @include('partials.comman.loan.team_member_add')
                        </fieldset>
                        @endforelse
                        <input type="hidden" name="application_id" value="{{ $application->id }}" >
                        
                        
                        @if($enc_id == "")
                            @php
                                $redirect_url = ($application->apply_for == 1) ? url('loan/create/finance') : url('loan/create/property-security');
                            @endphp
                        
                            <div class="row">
                               <div class="col-md-12 text-center mt-3">
                                  <a href="{{ route('loan.create.business.information') }}" class="btn btn-light waves-effect waves-light mt-2"><i class="fe-arrow-left"></i>
                                  &nbsp;Previous
                                  </a>
                                  <button type="submit" data-url="{{ url()->current() }}" data-redirect="{{ $redirect_url }}" id="pr-second" class="btn btn-success waves-effect waves-light mt-2 ml-2">Next<span class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                               </div>
                            </div>
                        @else
                            @php
                                $redirect_url = ($application->apply_for == 1) ? url('loan/edit/finance/'.$enc_id) : url('loan/edit/property-security/'.$enc_id);
                            @endphp
                        
                            <div class="row">
                               <div class="col-md-12 text-center mt-3">
                                  <a href="{{ url('loan/edit/'.$enc_id) }}" class="btn btn-light waves-effect waves-light mt-2"><i class="fe-arrow-left"></i>
                                  &nbsp;Previous
                                  </a>
                                  <button type="submit" data-url="{{ url('loan/create/people') }}" data-redirect="{{ $redirect_url }}" id="pr-second" class="btn btn-success waves-effect waves-light mt-2 ml-2">Next<span class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                               </div>
                            </div>
                        @endif

                     </form>
                  </div>
                  <!-- end settings content-->
               </div>
               <!-- end tab-content -->
            </div>
         </div>
         <div class="col-md-7 col-xl-3 cu-applisidebar cright">
            @include('partials.comman.loan.right_cardbox', ['application' => $application])
         </div>
      </div>
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
@if(request()->is('loan*'))
{{-- <script src="{{ asset('comman/js/pages/moment.min.js') }}"></script> --}}
<script src="{{ asset('comman/js/pages/bootstrap-datepicker.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.google_map_api_key') }}&libraries=places"></script>
        
<script>
    $('select').select2();
    
    
    /*var options = {
      types: ['geocode'],
      componentRestrictions: { country: 'AU' }
    };
    
    var autocomplete = new google.maps.places.Autocomplete($(".buz_address")[0], options);
    
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
    });*/
    
function initializeAutocomplete_team(inputElement) {
    var options = {
        types: ['geocode'],
        componentRestrictions: { country: 'AU' }
    };

    var autocomplete = new google.maps.places.Autocomplete(inputElement, options);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();

        if (place.address_components) {
            var components = place.address_components;

            var address = {
                street_number: '',
                street_name: '',
                street_type: '',
                locality: '',
                state: '',
                postcode: ''
            };

            components.forEach(function(component) {
                if (component.types.includes("street_number")) {
                    address.street_number = component.long_name;
                }
                if (component.types.includes("route")) {
                    var routeParts = component.long_name.split(' ');
                    address.street_name = routeParts.slice(0, -1).join(' '); // All parts except the last
                    address.street_type = routeParts.slice(-1).join(''); // Last part
                }
                if (component.types.includes("locality")) {
                    address.locality = component.long_name;
                }
                if (component.types.includes("administrative_area_level_1")) {
                    address.state = component.short_name;
                }
                if (component.types.includes("postal_code")) {
                    address.postcode = component.long_name;
                }
            });

            // Populate hidden fields using jQuery
            /*$('#street_number').val(address.street_number);
            $('#street_name').val(address.street_name);
            $('#street_type').val(address.street_type);
            $('#locality').val(address.locality);
            $('#state').val(address.state);
            $('#postcode').val(address.postcode);*/
        }

        console.log('Address Components:', place.address_components);
    });
}

initializeAutocomplete_team($(".buz_address")[0]);  
</script>
@endif
@endsection