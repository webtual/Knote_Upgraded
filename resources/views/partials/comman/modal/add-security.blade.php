<div class="modal fade add_security_model" id="add_security_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Property / Security</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $application_id = $application->id;
            @endphp
            <div class="modal-body loan-form-page">
                <form action="{{ route('loan.details.add.property.security') }}" name="form_security_add" id="form_security_add" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    
                    <input type="hidden" id="user_id" name="user_id" value="{{$application->user_id}}">
                    <input type="hidden" name="application_id" value="{{ ($application) ? $application->id : '' }}">
                    <input type="hidden" name="apply_for" value="{{ ($application) ? $application->apply_for : '1' }}">
                    
                    <div class="property-sections-container" id="property-sections-container">
                        @php
                            $property_loan_types = config('constants.property_loan_types');
                            $type_of_property = config('constants.type_of_property');
                        @endphp
                        <div class="row d-property-sec">
                            <div class="col-md-6 property-security-check-add">
                                <div class="form-group">
                                    <label for="">Type of Property / Security? <span class="text-danger">*</span></label>
                                    <div class="">
                                        <div>
                                            <h5 class="text-black">Purpose:</h5>
                                        </div>
                                        @foreach($property_loan_types as $key => $value)
                                        <div class="radio mt-1">
                                            <input type="radio" class="purpose" value="{{ $key }}" id="plt_{{ $key }}_{{ $value }}" name="purpose"  
                                            {{ ($key == 1) ? 'checked="checked"' : '' }}>
                                            <label for="plt_{{ $key }}_{{ $value }}"> {{ ucfirst($value) }} </label>
                                        </div>
                                        @endforeach
                                        <input type="hidden" name="hidden_purpose" class="hidden_purpose" value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 property-type-check-add">
                                <div class="form-group">                            
                                    <div>
                                        <div class="mt-3">
                                            <h5 class="text-black">Property Type:</h5>
                                        </div>
                                        
                                        
                                        @foreach($type_of_property as $keys => $values)
                                        <div class="radio  mt-1">
                                            <input type="radio" class="property_type" value="{{ $keys }}" id="tofp_{{ $keys }}_{{ $values }}" value="{{ $keys }}" name="property_type"  {{ ($keys == 1) ? 'checked="checked"' : '' }}>
                                            <label for="tofp_{{ $keys }}_{{ $values }}"> {{ ucfirst($values) }} </label>
                                        </div>
                                        @endforeach
                                        
                                        <input type="hidden" name="hidden_property_type" class="hidden_property_type" value="1">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="">Property Address <span class="text-danger">*</span></label>
                                 <input type="text" name="property_address" class="form-control property_address" id="business_address" placeholder="Property Address" value="" >
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group input-pos-relative">
                                 <label for="">Property Value <span class="text-danger">*</span></label>
                                 <input type="text" name="property_value" class="form-control currency-input" id="property_value" placeholder="Property Value" value="" maxlength="15" >
                                 <span class="currency-symbol">$</span>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="">Property Owner <span class="text-danger">*</span></label>
                                 <input type="text" name="property_owner" class="form-control property_owner" placeholder="Property Owner" value="" >
                              </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2" id="form_security_add_btn">Save</button>
                        <button type="button" class="btn btn-info mr-2" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>