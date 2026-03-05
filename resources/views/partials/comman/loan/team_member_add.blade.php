<div class="additional_clone">
   <h4 class="header-title"></h4>
   <div class="row mt-1">
      <div class="col-md-2">
         <div class="form-group">
            <label for="bs">Title <span class="text-danger">*</span></label>
            <select class="custom-select" name="title[]" id="title-1">
               <option value="">Select..</option>
               @foreach(config('constants.people_title') as $key => $title)
                  <option value="{{ $key }}">{{ $title }}</option>
               @endforeach
            </select>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">First name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="" name="firstname[]" placeholder="First name" >
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="">Last name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="" name="lastname[]" placeholder="Last name" >
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="">Residential Address <span class="text-danger">*</span></label> @if($application->business_address != null)<span class="float-right"><a href="javascript:;" class="paste-ev text-success" data-text="{{ $application->business_address }}"><i class="fa fa-paste"></i> Business Addesss</a></span>@endif
            <input type="text" class="form-control buz_address" id="" name="address[]" placeholder="Residential Address">
            
            <!--<input type="hidden" id="street_number" name="street_number[]" value="">
            <input type="hidden" id="street_name" name="street_name[]" value="">
            <input type="hidden" id="street_type" name="street_type[]" value="">
            <input type="hidden" id="locality" name="locality[]" value="">
            <input type="hidden" id="state" name="state[]" value="">
            <input type="hidden" id="postcode" name="postcode[]" value="">-->
         </div>
      </div>
      
        
      <div class="col-md-6">
         <div class="form-group">
            <label for="">Residential Status <span class="text-danger">*</span></label>
            <select class="custom-select" name="residential_status[]" id="residential_status-1">
               <option value="">Select..</option>
               @foreach(config('constants.residential_status') as $key => $ms)
               <option value="{{ $key }}">{{ $ms }}</option>
               @endforeach
            </select>
         </div>
      </div>
      
      
      
   </div>
   <div class="row">
      <div class="col-md-4">
        <div class="form-group">
            <label for="">Gender <span class="text-danger">*</span></label>
            <select class="custom-select" name="gender[]" id="gender-1">
                <option value="">Select..</option>
                @foreach(config('constants.gender') as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
      </div>

      <div class="col-md-4">
         <div class="form-group">
            <label for="">Marital Status <span class="text-danger">*</span></label>
            <select class="custom-select" name="marital_status[]" id="marital_status-1">
               <option value="">Select..</option>
               @foreach(config('constants.marital_status') as $key => $ms)
               <option value="{{ $key }}">{{ $ms }}</option>
               @endforeach
            </select>
         </div>
      </div>
      
      <div class="col-md-4">
         <div class="form-group">
            <label for="">DOB <span class="text-danger">*</span></label>
            <input type="text" class="form-control p-date-picker date-field" name="dob[]" id="" placeholder="DOB">
         </div>
      </div>
      
     
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="">Mobile <span class="text-danger">*</span></label> @if($application->business_phone != null)<span class="float-right"><a href="javascript:;" class="paste-ev text-success" data-text="{{ display_aus_phone($application->business_phone) }}"><i class="fa fa-paste"></i> Business Mobile</a></span>@endif
            <input type="text" class="form-control" data-mask="9999 999 999" name="mobile[]" id="" placeholder="Mobile">
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="">Landline</label> @if($application->landline_phone != null)<span class="float-right"><a href="javascript:;" class="paste-ev text-success" data-text="{{ display_aus_landline($application->landline_phone) }}"><i class="fa fa-paste"></i> Business Landline</a></span>@endif
            <input type="text" class="form-control landline-field" name="landline[]" data-mask="99 9999 9999" id="" placeholder="Landline">
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="">License Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="license_number[]" id="" placeholder="License Number">
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="">License Expiry Date <span class="text-danger">*</span></label>
            <input type="text" class="form-control expire-date-field" name="license_expiry_date[]" id="" placeholder="License Expiry Date">
         </div>
      </div>
   </div>
   <div class="row">
       <div class="col-md-6">
         <div class="form-group">
            <label for="">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email_address[]" id="" placeholder="Email Address" value="">
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label for="">License Card Number <span class="text-danger">*</span></label>
            <input type="text" data-mask="AAAAAAAAAA" class="form-control license-card-number-field" name="license_card_number[]" id="" placeholder="License Card Number">
         </div>
      </div>
   </div>
   
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="">Position <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="position[]" id="" placeholder="Position">
         </div>
      </div>
   
      <div class="col-md-6">
         <div class="form-group">
            <label for="">Time in Business <span class="text-danger">*</span></label>
            <select class="custom-select" name="time_in_business[]" id="time_in_business-1">
               <option value="" selected>Select..</option>
               @for($i=1; $i<=75; $i++)
               <option value="{{ $i }}">{{ $i }} Years</option>
               @endfor
            </select>
         </div>
      </div>
    </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label for="">Time at Address <span class="text-danger">*</span></label>
            <select class="custom-select" name="time_at_business[]" id="time_at_business-1">
               <option value="" selected>Select..</option>
               @for($i=1; $i<=75; $i++)
               <option value="{{ $i }}">{{ $i }} Years</option>
               @endfor
            </select>
         </div>
      </div>
   </div>
   <hr class="mt-0 mt-sm-2">
   <input type="hidden" id="" name="team_size_id[]" value="">


   <div class="row mb-2">
      <div class="col-md-12">
         <a href="javascript: void(0);" class="remove_add_s d-none btn btn-xs btn-danger float-right text-white">  <i class="mdi mdi-minus"></i>
         </a>    
         <a href="javascript: void(0);" class="mr-2 rm-blk-add btn btn-xs btn-info add_more_additional float-right text-white">  <i class="mdi mdi-plus"></i> Add more Applicant/Director/Proprietor
         </a>                          
      </div>
   </div> 


</div>


