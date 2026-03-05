<div class="modal fade add_director_model" id="add_director_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Applicant/Director/Proprietor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $application_id = $application->id;
            @endphp
            <div class="modal-body loan-form-page">
                <form action="{{ route('loan.details.add.director') }}" name="form_director_add" id="form_director_add" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    
                    <input type="hidden" id="user_id" name="user_id" value="{{$application->user_id}}">
                    <input type="hidden" name="application_id" value="{{ ($application) ? $application->id : '' }}">
                    <input type="hidden" name="apply_for" value="{{ ($application) ? $application->apply_for : '1' }}">
                    
                    <div class="row">
                        <fieldset id="team_member" class="w-100">
                           @include('partials.comman.loan.team_member_add_new_1')
                        </fieldset>
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2" id="form_director_add_btn">Save</button>
                        <button type="button" class="btn btn-info mr-2" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>