<div class="additional_clone">
   <h4 class="header-title"></h4>
   <div class="row mt-1">
      <div class="col-md-2">
         <div class="form-group">
            <label for="bs">Title <span class="text-danger">*</span></label>
            <select class="custom-select title-1" name="title[]" id="title-1">
               <option value="">Select..</option>
               @foreach(config('constants.people_title') as $key => $title)
                  <option value="{{ $key }}">{{ $title }}</option>
               @endforeach
            </select>
         </div>
      </div>
      <div class="col-md-3">
         <div class="form-group">
            <label for="">First name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="firstname" name="firstname[]" placeholder="First name" >
         </div>
      </div>
      <div class="col-md-3">
         <div class="form-group">
            <label for="">Last name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="lastname" name="lastname[]" placeholder="Last name" >
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Residential Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control buz_address" id="address" name="address[]" placeholder="Residential Address">
         </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
            <label for="">Gender <span class="text-danger">*</span></label>
            <select class="custom-select gender-1" name="gender[]" id="gender-1">
                <option value="">Select..</option>
                @foreach(config('constants.gender') as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Residential Status <span class="text-danger">*</span></label>
            <select class="custom-select residential_status-1" name="residential_status[]" id="residential_status-1">
               <option value="">Select..</option>
               @foreach(config('constants.residential_status') as $key => $ms)
               <option value="{{ $key }}">{{ $ms }}</option>
               @endforeach
            </select>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Marital Status <span class="text-danger">*</span></label>
            <select class="custom-select marital_status-1" name="marital_status[]" id="marital_status-1">
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
            <input type="text" class="form-control p-date-picker date-field" name="dob[]" id="dob" placeholder="DOB">
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Mobile <span class="text-danger">*</span></label>
            <input type="text" class="form-control" data-mask="9999 999 999" name="mobile[]" id="mobile" placeholder="Mobile">
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Landline</label>
            <input type="text" class="form-control landline-field landline" name="landline[]" data-mask="99 9999 9999" id="landline" placeholder="Landline">
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">License Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control license_number" name="license_number[]" id="license_number" placeholder="License Number">
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">License Expiry Date <span class="text-danger">*</span></label>
            <input type="text" class="form-control expire-date-field" name="license_expiry_date[]" id="license_expiry_date" placeholder="License Expiry Date">
         </div>
      </div>
       <div class="col-md-4">
         <div class="form-group">
            <label for="">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email_address[]" id="email_address" placeholder="Email Address" value="">
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">License Card Number <span class="text-danger">*</span></label>
            <input type="text" data-mask="AAAAAAAAAA" class="form-control license-card-number-field license_card_number" name="license_card_number[]" id="license_card_number" placeholder="License Card Number">
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Position <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="position[]" id="position" placeholder="Position">
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Time in Business <span class="text-danger">*</span></label>
            <select class="custom-select time_in_business-1" name="time_in_business[]" id="time_in_business-1">
               <option value="" selected>Select..</option>
               @for($i=1; $i<=75; $i++)
               <option value="{{ $i }}">{{ $i }} Years</option>
               @endfor
            </select>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Time at Address <span class="text-danger">*</span></label>
            <select class="custom-select time_at_business-1" name="time_at_business[]" id="time_at_business-1">
               <option value="" selected>Select..</option>
               @for($i=1; $i<=75; $i++)
               <option value="{{ $i }}">{{ $i }} Years</option>
               @endfor
            </select>
         </div>
      </div>
   </div>
   <hr class="mt-0 mt-sm-2">
   <input type="hidden" id="team_size_id" name="team_size_id[]" value="">
</div>