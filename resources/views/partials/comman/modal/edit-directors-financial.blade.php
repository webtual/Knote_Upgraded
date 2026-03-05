<div class="modal fade edit_directors_financial_model" id="edit_directors_financial_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Directors Personal Financial Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $application_id = $application->id;
            @endphp
            <div class="modal-body loan-form-page">
                <form action="{{ route('loan.details.update.directors.financial') }}" name="form_directors_financial_edit" id="form_directors_financial_edit" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    
                    <input type="hidden" id="user_id" name="user_id" value="{{$application->user_id}}">
                    <input type="hidden" name="application_id" value="{{ ($application) ? $application->id : '' }}">
                    <input type="hidden" name="apply_for" value="{{ ($application) ? $application->apply_for : '1' }}">
                    <input type="hidden" name="directors_financial_id" class="directors_financial_id" value="">
                    <input type="hidden" name="team_size_id" class="team_size_id" value="">
                    
                    
                    <div class="d-fin-wrapper">
                        <h4 class="text-left">
                           Assets
                        </h4>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group input-pos-relative">
                                 <label for="">Property (Residential Property) <span class="text-danger">*</span></label>
                                 <input type="text" name="asset_property_primary_residence" class="form-control currency-input asset_property_primary_residence" value="" id="asset_property_primary_residence" placeholder="Property (Residential Property)">
                                 <span class="currency-symbol">$</span>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group input-pos-relative">
                                 <label for="">Property (Other) <span class="text-danger">*</span></label>
                                 <input type="text" name="asset_property_other" class="form-control currency-input asset_property_other" id="asset_property_other" value="" placeholder="Property (Other)">
                                 <span class="currency-symbol">$</span>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group input-pos-relative">
                                 <label for="">Bank Account Balance <span class="text-danger">*</span></label>
                                 <input type="text" name="asset_bank_account" class="form-control currency-input asset_bank_account" id="asset_bank_account" placeholder="Bank Account Balance" value="">
                                 <span class="currency-symbol">$</span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group input-pos-relative">
                                 <label for="">Super (s) <span class="text-danger">*</span></label>
                                 <input type="text" name="asset_super" class="form-control currency-input asset_super" id="asset_super" placeholder="Super (s)" value="">
                                 <span class="currency-symbol">$</span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group input-pos-relative">
                                 <label for="">Other Assets <span class="text-danger">*</span></label>
                                 <input type="text" name="asset_other" class="form-control currency-input asset_other" id="asset_other" placeholder="Other Assets" value="">
                                 <span class="currency-symbol">$</span>
                              </div>
                           </div>
                        </div>
                        <h4 class="text-left">
                           Liabilities
                        </h4>

                        <div class="table-responsive mb-2" style="overflow-x: inherit;">
                            <table class="table table-bordered mb-0 table-borderless">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Limit</th>
                                    <th>Repayment/Month</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Home Loan Liabilities</td>
                                    <td class="input-pos-relative"> 
                                       <input type="text" name="liability_homeloan_limit" class="form-control currency-input liability_homeloan_limit" id="liability_homeloan_limit" placeholder="Limit Amount" value="">
                                       <span class="currency-symbol">$</span>
                                    </td>
                                    <td class="input-pos-relative">
                                       <input type="text" name="liability_homeloan_repayment" class="form-control currency-input liability_homeloan_repayment" id="liability_homeloan_repayment" placeholder="Repayment/Month Amount" value="">
                                        <span class="currency-symbol">$</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Other Loan Liabilities</td>
                                    <td class="input-pos-relative">
                                       <input type="text" class="form-control currency-input liability_otherloan_limit" name="liability_otherloan_limit" id="liability_otherloan_limit" placeholder="Limit Amount" value="">
                                        <span class="currency-symbol">$</span>
                                    </td>
                                    <td class="input-pos-relative">
                                       <input type="text" class="form-control currency-input liability_otherloan_repayment" name="liability_otherloan_repayment" id="liability_otherloan_repayment" placeholder="Repayment/Month Amount" value="">
                                        <span class="currency-symbol">$</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Credit Card (All Cards)</td>
                                    <td class="input-pos-relative">
                                       <input type="text" class="form-control currency-input liability_all_card_limit" name="liability_all_card_limit" id="liability_all_card_limit" placeholder="Limit Amount" value="">
                                        <span class="currency-symbol">$</span>
                                    </td>
                                    <td class="input-pos-relative">
                                       <input type="text" class="form-control currency-input liability_all_card_repayment" name="liability_all_card_repayment" id="liability_all_card_repayment" placeholder="Repayment/Month Amount" value="">
                                        <span class="currency-symbol">$</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Car/Personal Loans (All Loans)</td>
                                    <td class="input-pos-relative">
                                       <input type="text" class="form-control currency-input liability_car_personal_limit" id="liability_car_personal_limit" name="liability_car_personal_limit" placeholder="Limit Amount" value="">
                                        <span class="currency-symbol">$</span>
                                    </td>
                                    <td class="input-pos-relative">
                                       <input type="text" class="form-control currency-input liability_car_personal_repayment" id="liability_car_personal_repayment" name="liability_car_personal_repayment" placeholder="Repayment/Month Amount" value="">
                                        <span class="currency-symbol">$</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Any Other Expense</td>
                                    <td class="input-pos-relative">
                                       <input type="text" class="form-control currency-input liability_living_expense_limit" name="liability_living_expense_limit" value="" id="liability_living_expense_limit" placeholder="Limit Amount">
                                        <span class="currency-symbol">$</span>
                                    </td>
                                    <td class="input-pos-relative">
                                       <input type="text" class="form-control currency-input liability_living_expense_repayment" name="liability_living_expense_repayment" value="" id="liability_living_expense_repayment" placeholder="Repayment/Month Amount">
                                        <span class="currency-symbol">$</span>
                                    </td>
                                </tr>
                                 </tbody>
                            </table>
                        </div>

                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2" id="form_directors_financial_edit_btn">Update</button>
                        <button type="button" class="btn btn-info mr-2" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>