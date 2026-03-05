<div class="modal fade conditionally_approved" id="conditionally_approved" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Conditionally Approved Details</h5>
                <button type="button" class="close close-conditionally-approved" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/conditionally-approved-update') }}" id="conditionally_approved_form" method="post" role="form" class="conditionally_approved_form" onsubmit="return false;">
                    
                    <input type="hidden" name="conditionally_approved_application_id" id="conditionally_approved_application_id" value="{{ ($application) ? $application->id : '' }}">
                    
                    <input type="hidden" name="is_edit_val" id="is_edit_val" value="">
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Facility Limit (Approval) <span class="text-danger">*</span></label>
                                <input type="text" name="facility_limit" class="form-control numbersOnlyAllowPoint facility_limit" id="facility_limit" placeholder="Facility Limit (Approval)" value="{{ ($application) ? $application->facility_limit : '' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Facility Term (Approval) [Months]<span class="text-danger">*</span></label>
                                <input type="text" name="facility_term" class="form-control numbersOnlyAllow facility_term" id="facility_term" placeholder="Facility Term (Approval)" value="{{ ($application) ? $application->facility_term : '' }}" maxlength="15" >
                                
                                <input type="hidden" name="interest_capitalized" class="form-control numbersOnlyAllow interest_capitalized" id="interest_capitalized" value="{{ ($application) ? $application->interest_capitalized : '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Applied Interest Rate <span class="text-danger">*</span></label>
                                <input type="text" name="applied_interest_rate_per_month" class="form-control numbersOnlyAllowPoint applied_interest_rate_per_month" id="applied_interest_rate_per_month" placeholder="Applied Interest Rate" value="{{ ($application) ? $application->applied_interest_rate_per_month : '' }}" maxlength="15" >
                                <span class="pers-symbol">%</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Applied annual Interest <span class="text-danger">*</span></label>
                                <input type="text" name="applied_annual_interest" class="form-control numbersOnlyAllowPoint applied_annual_interest" id="applied_annual_interest" placeholder="Applied annual Interest" value="{{ ($application) ? $application->applied_annual_interest : '' }}" maxlength="15" >
                                <span class="pers-symbol">%</span>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Application Fee <span class="text-danger">*</span></label>
                                <input type="text" name="application_fee" class="form-control numbersOnlyAllowPoint application_fee" id="application_fee" placeholder="Application Fee" value="{{ ($application) ? $application->application_fee : '' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Documentation Fee <span class="text-danger">*</span></label>
                                <input type="text" name="documentation_fee" class="form-control numbersOnlyAllowPoint documentation_fee" id="documentation_fee" placeholder="Documentation Fee" value="{{ ($application) ? $application->documentation_fee : '' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Valuation Fee <span class="text-danger">*</span></label>
                                <input type="text" name="valuation_fee" class="form-control valuation_fee" id="valuation_fee" placeholder="Valuation Fee" value="{{ ($application) ? $application->valuation_fee : '' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Disbursement Fee <span class="text-danger">*</span></label>
                                <input type="text" name="disbursement_fees" class="form-control numbersOnlyAllowPoint disbursement_fees" id="disbursement_fees" placeholder="Disbursement Fee" value="{{ ($application) ? $application->disbursement_fees : '' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Other Fee <span class="text-danger">*</span></label>
                                <input type="text" name="other_fee" class="form-control numbersOnlyAllowPoint other_fee" id="other_fee" placeholder="Other Fee" value="{{ ($application) ? $application->other_fee : '' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Monthly Acc Fee <span class="text-danger">*</span></label>
                                <input type="text" name="monthly_acc_fee" class="form-control numbersOnlyAllowPoint monthly_acc_fee" id="monthly_acc_fee" placeholder="Monthly Acc Fee" value="{{ ($application) ? $application->monthly_acc_fee : '25' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Discharge Fee <span class="text-danger">*</span></label>
                                <select class="custom-select" name="discharge_fee" id="discharge_fee">
                                    <option value="" selected>Select..</option>
                                    <option value="495" {{ $application->discharge_fee == '495' ? 'selected' : '' }}>$495</option>
                                    <option value="199" {{ $application->discharge_fee == '199' ? 'selected' : '' }}>$199</option>
                                    <option value="noval" {{ $application->discharge_fee == 'noval' ? 'selected' : '' }}>Enter Number Value</option>
                                    <option value="N/A" {{ $application->discharge_fee == 'N/A' ? 'selected' : '' }}>Not Applicable</option>
                                 </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3 discharge_fee_2" style="display:{{ $application->discharge_fee == 'noval' ? 'block' : 'none' }};">
                            <div class="form-group input-pos-relative">
                                <label for="">Discharge Fee (Number Value)</label>
                                <input type="text" name="discharge_fee_val" class="form-control numbersOnlyAllowPoint discharge_fee_val" id="discharge_fee_val" placeholder="Discharge Fee (Number Value)" value="{{ ($application) ? $application->discharge_fee_val : '' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">PPSR <span class="text-danger">*</span></label>
                                <input type="text" name="ppsr_value" class="form-control ppsr_value" id="ppsr_value" placeholder="PPSR" value="{{ ($application) ? $application->ppsr_value : '' }}" maxlength="15" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">LVR current <span class="text-danger">*</span></label>
                                <input type="text" name="lvr_current" class="form-control lvr_current" id="lvr_current" placeholder="LVR current" value="{{ ($application) ? $application->lvr_current : '' }}" maxlength="15" >
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Payment Type <span class="text-danger">*</span></label>
                                <select class="custom-select" name="payment_type" id="payment_type">
                                    <option value="" selected>Select..</option>
                                    <option value="1" {{ $application->payment_type == 1 ? 'selected' : '' }}>Principal And Interest</option>
                                    <option value="2" {{ $application->payment_type == 2 ? 'selected' : '' }}>Interest Only</option>
                                    <option value="3" {{ $application->payment_type == 3 ? 'selected' : '' }}>Interest Capitalized</option>
                                 </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Repayment Amount <span class="text-danger">*</span></label>
                                <input type="text" name="repayment_amount" class="form-control numbersOnlyAllowPoint repayment_amount" id="repayment_amount" placeholder="Repayment Amount" value="{{ ($application) ? $application->repayment_amount : '' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-pos-relative">
                                <label for="">Total Payment</label>
                                <input type="text" name="total_repayment_amount" class="form-control numbersOnlyAllowPoint total_repayment_amount" id="total_repayment_amount" placeholder="Total Payment" value="{{ ($application) ? $application->total_repayment_amount : '' }}" maxlength="15" >
                                <span class="currency-symbol">$</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group input-pos-relative">
                                <label for="">Repayment Description <span class="text-danger">*</span></label>
                                <textarea type="text" name="repayment_description" style="height: 150px !important;" class="form-control repayment_description" id="repayment_description" placeholder="Repayment Description">{{ ($application) ? $application->repayment_description : '' }}</textarea>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="form-group input-pos-relative">
                                <label for="">Settlement Conditions <span class="text-danger">*</span></label>
                                <textarea type="text" name="settlement_conditions_descriptions" class="form-control settlement_conditions_descriptions" id="settlement_conditions_descriptions" placeholder="Settlement Conditions">{{ ($application) ? $application->settlement_conditions_descriptions : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-pos-relative">
                                <label for="">Security Descriptions</label>
                                <textarea type="text" name="security_descriptions" class="form-control security_descriptions" id="security_descriptions" placeholder="Security Description">{{ ($application) ? $application->security_descriptions : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-pos-relative">
                                <label for="">Mortgage Type</label>
                                <textarea type="text" name="mortgage_type_descriptions" class="form-control mortgage_type_descriptions" id="mortgage_type_descriptions" placeholder="Mortgage Type">{{ ($application) ? $application->mortgage_type_descriptions : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-pos-relative">
                                <label for="">Land Address [Volume & Folio]</label>
                                <textarea type="text" name="land_address_descriptions" class="form-control land_address_descriptions" id="land_address_descriptions" placeholder="Land Address [Volume & Folio]">{{ ($application) ? $application->land_address_descriptions : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-pos-relative">
                                <label for="">Grantor</label>
                                <textarea type="text" name="grantor_descriptions" class="form-control grantor_descriptions" id="grantor_descriptions" placeholder="Grantor">{{ ($application) ? $application->grantor_descriptions : '' }}</textarea>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2 submit-conditionally-approved" id="submit-conditionally-approved">Update</button>
                        <button type="button" class="btn btn-info mr-2 close-conditionally-approved" data-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>