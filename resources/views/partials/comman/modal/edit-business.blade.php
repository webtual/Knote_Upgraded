<div class="modal fade edit_business_model" id="edit_business_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Business Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $business_structures = \App\BusinessStructure::get();
                $business_types = \App\BusinessType::wheretype(3)->get();
                $check_status_array = [1,3];
                $application_id = $application->id;
            @endphp
            <div class="modal-body">
                <form action="{{ route('loan.details.update.business.information') }}" name="form_loan_application_update" id="form_loan_application_update" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    
                    <input type="hidden" id="user_id" name="user_id" value="{{$application->user_id}}">
                    <input type="hidden" id="loan_amount_requested" name="loan_amount_requested" value="{{ ($application) ? $application->amount_request : '90000' }}">
                    <input type="hidden" name="postcode" value="{{ ($application) ? $application->postcode : '' }}">
                    <input type="hidden" name="application_id" value="{{ ($application) ? $application->id : '' }}">
                    <input type="hidden" name="apply_for" value="{{ ($application) ? $application->apply_for : '1' }}">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label for="">How much you would like to borrow? <span class="text-danger">*</span></label>
                                <div class="input-group flex-nowrap gap-2">
                                    <div class="input-pos-relative w-100">
                                    <input type="text" maxlength="15" class="form-control currency-input" id="m_loan_amount" placeholder="Amount" value="{{ ($application) ? number_format($application->amount_request) : '' }}" name="m_loan_amount" data-max="100000}}">
                                    <span class="currency-symbol currency-symbol-one">$</span>
                                    </div>
                                    <span class="input-group-btn plus-minus-btn-wrapper">
                                        <div>
                                        <button class="btn btn-success plus-minus-btn text-nowrap  mb-1" type="button" id="increment-amount">+</button>
                                        <button class="btn btn-success plus-minus-btn text-nowrap" type="button" id="decrement-amount">-</button>
                                        </div>
                                        <b>$10K</b>
                                    </span>
                                </div>
                            </div>
                       </div>
                       
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>ABN OR ACN <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="abn_acn" name="abn_acn" placeholder="ABN OR ACN" aria-label="" data-action="{{ url('search/abn-acn') }}" maxlength="11" value="{{ ($application) ? $application->abn_or_acn : '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                          <div class="form-group new-select">
                             <label for="bs">Year Established <span class="text-danger">*</span></label>
                             <select class="custom-select" name="year_established" id="year_established">
                                <option value="" selected>Select..</option>
                                @for($i=1970; $i<=date('Y'); $i++)
                                <option value="{{ $i }}" 
                                @if($application)
                                   {{ ($application->years_of_established == $i) ? 'selected' : '' }}
                                @endif
                                >{{ $i }}</option>
                                @endfor
                             </select>
                          </div>
                       </div>
                       
                       <div class="col-md-4">
                          <div class="form-group new-select">
                             <label for="bs">Business Structure <span class="text-danger">*</span></label>
                             <select class="custom-select" name="business_structure" id="business_structure">
                                <option value="" selected>Select..</option>
                                @foreach($business_structures as $bs)
                                <option value="{{$bs->id}}"
                                @if($application)
                                   {{ ($application->business_structures_id == $bs->id) ? 'selected' : '' }}
                                @endif
                                >{{ $bs->structure_type }}</option>
                                @endforeach
                             </select>
                          </div>
                       </div>
                       
                       <div class="col-md-4">
                          <div class="form-group">
                             <label for="">Business Name <span class="text-danger">*</span></label>
                             <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Business Name" value="{{ ($application) ? $application->business_name : '' }}">
                          </div>
                       </div>
                       
                       <div class="col-md-4">
                          <div class="form-group">
                             <label for="">Business Address <span class="text-danger">*</span></label>
                             <input type="text" name="business_address" class="form-control business_address" id="business_address" placeholder="Business Address" value="{{ ($application) ? $application->business_address : '' }}" >
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="form-group">
                             <label for="bs">Business Email <span class="text-danger">*</span></label>
                             <input type="text" name="business_email" class="form-control" id="business_email" placeholder="Business Email" value="{{ ($application) ? $application->business_email : '' }}" >
                          </div>
                       </div>
                       
                       <div class="col-md-4">
                          <div class="form-group new-select">
                             <label for="bs">Your industry of trade <span class="text-danger">*</span></label>
                             <select class="custom-select" name="trade" id="trade">
                                <option value="" selected>Select..</option>
                                @foreach($business_types as $bt)
                                <option value="{{$bt->id}}"
                                @if($application)
                                   {{ ($application->business_type_id == $bt->id) ? 'selected' : '' }}
                                @endif
                                >{{ $bt->business_type }}</option>
                                @endforeach
                             </select>
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="form-group">
                             <label for="">Mobile <span class="text-danger">*</span></label>
                             <input type="text" name="mobile_no" class="form-control phone-field" id="mobile_no" placeholder="Mobile" value="{{ ($application) ? $application->business_phone : '' }}">
                          </div>
                       </div>
                       
                       <div class="col-md-4">
                          <div class="form-group">
                             <label for="bs">Landline</label>
                             <input type="text" name="landline_phone" data-mask="99 9999 9999" value="{{ ($application) ? $application->landline_phone : '' }}" class="form-control landline-field" id="landline_phone" placeholder="Landline">
                          </div>
                       </div>
                       
                       
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Add Brief notes (What’s the loan for , give us a little background of requirement and proposal)<span class="text-danger">*</span></label>
                                <textarea name="brief_notes" class="form-control" id="brief_notes" placeholder="Add Brief notes">{{ ($application) ? $application->brief_notes : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2" id="form_loan_application_update_btn">Update</button>
                        <button type="button" class="btn btn-info mr-2" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>