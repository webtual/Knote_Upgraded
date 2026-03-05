<div id="sidebar-menu">
    <ul class="metismenu sidebar-menu-color-wt" id="side-menu">
    
        @php
            $fill_business_information = $file_people_information = $fill_finance_information = $fill_document_information = $is_submit = false;
            
            $initial_session_obj = session('otp_verification_obj');
            
            $request_information = json_decode($initial_session_obj->request_information);
            
            $apply_for = isset($application) ? $application->apply_for : $request_information->apply_for;
            
            if(isset($application) ){
                $fill_business_information = $application->progress['fill_business_information'];
                $file_people_information = $application->progress['file_people_information'];
                $fill_finance_information = $application->progress['fill_finance_information'];
                $fill_document_information = $application->progress['fill_document_information'];
                $is_submit = $application->progress['is_submit'];
            }
        @endphp
    
    
        @if($enc_id == "")
    
        <li class="{{ (request()->is('loan/create')) ? 'active' : '' }}">
           <a href="{{  route('loan.create.business.information') }}" class="font-17 confirmation" data-flag="1">
           <i class="fe-{{ ($fill_business_information) ? 'check' : 'briefcase' }}"></i>
           <span> Business Info</span>
           </a>
        </li>
        <li class="{{ (request()->is('loan/create/people')) ? 'active' : '' }}">
           <a href="{{  route('loan.create.people') }}" class="font-17 confirmation" data-flag="0">
          
            <i class="fe-{{ ($file_people_information) ? 'check' : 'users' }}"></i>
           <span> People </span>
           </a>
        </li>
        
        
        @if($apply_for == 1)
        <li class="{{ (request()->is('loan/create/finance')) ? 'active' : '' }}">
           <a href="{{  route('loan.create.finance') }}" class="font-17 confirmation" data-flag="0">
            <i class="fe-{{ ($fill_finance_information) ? 'check' : 'dollar-sign' }}"></i>
           <span> Finance </span>
           </a>
        </li>
        @else 
        <li class="{{ (request()->is('loan/create/property-security')) ? 'active' : '' }}">
            <a href="{{ route('loan.create.property.security') }}" class="font-17 confirmation" data-flag="0">
                <i class="fe-{{ ($fill_finance_information) ? 'check' : 'dollar-sign' }}"></i>
                <span>
                    @if($apply_for == 2)
                        Property/Security
                    @elseif($apply_for == 3)
                        Crypto/Security
                    @endif
                </span>
            </a>
        </li>
        @endif
        
        <li class="{{ (request()->is('loan/create/document')) ? 'active' : '' }}">
           <a href="{{  route('loan.create.document') }}" class="font-17 confirmation" data-flag="0">
           <i class="fe-{{ ($fill_document_information) ? 'check' : 'book-open' }}"></i>
           <span> Document </span>
           </a>
        </li>
        <li class="{{ (request()->is('loan/create/review')) ? 'active' : '' }}">
           <a href="{{  route('loan.create.review') }}" class="font-17 confirmation" data-flag="0">
           <i class="fe-{{ ($is_submit) ? 'check' : 'file-text' }}"></i>
           <span> Submit </span>
           </a>
        </li>
        @else
        
        @php
            $apply_for = isset($application) ? $application->apply_for : 1;
            
            if(isset($application) ){
                $fill_business_information = $application->progress['fill_business_information'];
                $file_people_information = $application->progress['file_people_information'];
                $fill_finance_information = $application->progress['fill_finance_information'];
                $fill_document_information = $application->progress['fill_document_information'];
                $is_submit = $application->progress['is_submit'];
            }
        @endphp
        
        <li class="menu-title">Edit application</li>
        <li class="{{ (request()->is('loan/edit')) ? 'active' : '' }}">
           <a href="{{ route('loan.edit.business.information', ['enc_id' => $enc_id]) }}" class="font-17 confirmation" data-flag="1">
            <i class="fe-{{ ($fill_business_information) ? 'check' : 'briefcase' }}"></i>
            <span> Business Info</span>
           </a>
        </li>
        <li class="{{ (request()->is('loan/edit/people')) ? 'active' : '' }}">
           <a href="{{  route('loan.edit.people', ['enc_id' => $enc_id]) }}" class="font-17 confirmation" data-flag="0">
            <i class="fe-{{ ($file_people_information) ? 'check' : 'users' }}"></i>
           <span> People </span>
           </a>
        </li>
        @if($apply_for == 1)
            <li class="{{ (request()->is('loan/edit/finance')) ? 'active' : '' }}">
           <a href="{{  route('loan.edit.finance', ['enc_id' => $enc_id]) }}" class="font-17 confirmation" data-flag="0">
          <i class="fe-{{ ($fill_finance_information) ? 'check' : 'dollar-sign' }}"></i>
           <span> Finance </span>
           </a>
        </li>
        @else
            <li class="{{ (request()->is('loan/edit/finance')) ? 'active' : '' }}">
               <a href="{{  route('loan.edit.finance', ['enc_id' => $enc_id]) }}" class="font-17 confirmation" data-flag="0">
               <i class="fe-{{ ($fill_finance_information) ? 'check' : 'dollar-sign' }}"></i>
               <span> Finance </span>
               </a>
            </li>
        @endif
        <li class="{{ (request()->is('loan/edit/document')) ? 'active' : '' }}">
           <a href="{{  route('loan.edit.document', ['enc_id' => $enc_id]) }}" class="font-17 confirmation" data-flag="0">
            <i class="fe-{{ ($fill_document_information) ? 'check' : 'book-open' }}"></i>
           <span> Document </span>
           </a>
        </li>
        <li class="{{ (request()->is('loan/edit/review')) ? 'active' : '' }}">
           <a href="{{  route('loan.edit.review', ['enc_id' => $enc_id]) }}" class="font-17 confirmation" data-flag="0">
           <i class="fe-{{ ($is_submit) ? 'check' : 'file-text' }}"></i>
           <span> Submit </span>
           </a>
        </li>
        @endif
        <li class="">
           <a href="javascript:;" data-url="{{ url('register/loan-applicant') }}" data-urlexit="{{ route('loan.save.exit') }}" class="font-17" data-flag="0" id="save-exit-loan-application">
           <i class="mdi mdi-content-save"></i>
           <span> Save & Exit </span>
           </a>
        </li>
    </ul>
</div>