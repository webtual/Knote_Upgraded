<div class="modal fade add_business_financial_model" id="add_business_financial_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Business Financial Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $application_id = $application->id;
            @endphp
            <div class="modal-body loan-form-page">
                <form action="{{ route('loan.details.add.business.financial') }}" name="form_business_financial_add" id="form_business_financial_add" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    
                    <input type="hidden" id="user_id" name="user_id" value="{{$application->user_id}}">
                    <input type="hidden" name="application_id" value="{{ ($application) ? $application->id : '' }}">
                    <input type="hidden" name="apply_for" value="{{ ($application) ? $application->apply_for : '1' }}">
                    
                    <div class="row">
                       <div class="col-md-12">
                          <div class="form-group">

                             <label for="" class="">&nbsp;</label>
                             @php
                             $finance_periods = config('constants.finance_periods');
                             @endphp
                             @foreach($finance_periods as $key => $value)
                             <div class="radio form-check-inline">
                                <input type="radio" id="inlineRadio{{ $key }}" value="{{ $key }}" name="finance_periods" {{ ($key == 1) ? 'checked="checked"' : '' }}>
                                <label for="inlineRadio{{ $key }}"> {{ ucfirst($value) }} </label>
                             </div>
                             @endforeach
                          </div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="col-md-6">
                          <div class="form-group">
                             <label for="">Business Trade Year <span class="text-danger">*</span></label>
                             <select class="custom-select business_trade_year" name="business_trade_year" id="business_trade_year">
                                <option value="">Select..</option>
                                @for($i= (date('Y') - 3); $i<=date('Y'); $i++)
                                   <option value="{{ $i }}" >{{ $i }}</option>
                                @endfor
                             </select>
                          </div>
                       </div>
                       
                       <div class="col-md-6">
                          <div class="form-group input-pos-relative">
                             <label for="">Gross Income <span class="text-danger">*</span></label>
                             <input type="text" class="form-control currency-input gross_income" name="gross_income" id="gross_income" placeholder="Gross Income" value="">
                             <span class="currency-symbol">$</span>
                          </div>
                       </div>
                       
                    </div>
                    <div class="row">
                       <div class="col-md-6">
                          <div class="form-group input-pos-relative">
                             <label for="">Total Expenses <span class="text-danger">*</span></label>
                             <input type="text" name="total_expenses" class="form-control currency-input total_expenses" id="total_expenses" placeholder="Total Expenses" value="">
                             <span class="currency-symbol">$</span>
                             <span class="help-block"><small>Including contractor, stock and sale</small></span>
                          </div>
                       </div> 
                       <div class="col-md-6">
                          <div class="form-group input-pos-relative">
                             <label for="">Net Income <span class="text-danger">*</span></label>
                             <input type="text" name="net_income" class="form-control currency-input net_income" id="net_income" placeholder="Net Income" value="">
                             <span class="currency-symbol">$</span>
                          </div>
                       </div>
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2" id="form_business_financial_add_btn">Save</button>
                        <button type="button" class="btn btn-info mr-2" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>