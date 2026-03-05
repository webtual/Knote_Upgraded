<div class="modal fade status_notes" id="status_notes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Write Assessor Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/review/status/assessorupdate') }}" id="popup_assessor_note_form" method="post" role="form" class="popup_assessor_note_form" onsubmit="return false;">
                    <div class="form-group">
                        <textarea class="form-control" name="popup_assessor_note" id="popup_assessor_note" placeholder="Assessor Note*" required=""></textarea>
                    </div>
                    <input type="hidden" name="popup_application_id" id="popup_application_id" value="">
                    <input type="hidden" name="popup_status_id" id="popup_status_id" value="">
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2" id="submit-assessor-notes">Save</button>
                        <button type="button" class="btn btn-info mr-2 close-notestag" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>