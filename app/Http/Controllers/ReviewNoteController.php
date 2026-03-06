<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;
use App\Models\ReviewNote;
use App\Models\Application;
use App\Models\AssessorReviewNote;
use App\Models\StatusHistory;

use Validator;
use Response;
use Auth;
use App\Traits\Loggable;
use App\Jobs\LoanApplicationStatusUpdate;

class ReviewNoteController extends Controller
{
    use Loggable;
    
    public function store(Request $request){
        $request->validate([
		    'note' => 'required',
		]);
		$data = new ReviewNote;
		$data->note = $request->note;
        $data->application_id = Crypt::decrypt($request->application_id);
		$data->reviewer_id = Auth::id();
		$data->save();
		
		$this->store_logs('admin', 'Add Note', $request->note);
		
        /*if($request->filled('status')):
            $update = Application::whereid(Crypt::decrypt($request->application_id))->update(['status_id' => $request->status]);
        endif;*/
        $html = '<div class="post-user-comment-box p-2 mb-2 mt-0">
                     <div class="media">
                        <div class="media-body p-1">
                           <h5 class="mt-0"> '.$data->user->name.' <small class="text-muted">1 sec ago</small></h5>
                           '.$data->note.'
                           <br>
                        </div>
                     </div>
                 </div>';
		return response()->json(['status' => 201, 'message' => 'Your review has been sucessfully added.', 'html' => $html]);
    }
    
    public function update(Request $request){
        $request->validate([
		    'status' => 'required',
		]);
		
		
        if($request->filled('status')){
            
            /*if (in_array($request->status, [7, 8, 11])) {
                $application_count = AssessorReviewNote::where('application_id', Crypt::decrypt($request->application_id))->where('status_id', $request->status)->count();
                
                if($application_count == 0){
                    return response()->json(['status' => 422, 'message' => "Kindly include an assessor's note for these statuses."]);
                }
            }*/
            
            $update = Application::whereid(Crypt::decrypt($request->application_id))->update(['status_id' => $request->status]);
            
            // Dispatch the job without delay
            $application = Application::find(Crypt::decrypt($request->application_id));
            $application->reminder_sent_at = null;
            $application->save();
            //$status_send_mail = (new LoanApplicationStatusUpdate($application))->handle();
            
            //ADMIN LOG START
                $status = $application->current_status->status;
                $body = 'The status of Loan Application Number '.$application->application_number.' has been updated to '.$status;
                $title = 'Loan Application Status Update To - '.$status;
                $this->store_logs('admin', $title, $body, $application->id);
            //ADMIN LOG END
            
            //Declined, Archived, Settled
            if (in_array($application->status_id, [8, 10, 11])) {
                $data_stage = Application::find($application->id);
                $data_stage->stage = null;
                $data_stage->save();
            }
            
            //Approved, Declined, Settled, Fast Track, 
            if (in_array($application->status_id, [7, 8, 9, 11, 12])) {
                dispatch(new LoanApplicationStatusUpdate($application))->delay(now()->addSeconds(10));
            }
            
            //Status History Added Code Start
            $statushistory = new StatusHistory;
            $statushistory->user_id = $application->user_id;
            $statushistory->application_id = $application->id;
            $statushistory->status_id = $application->status_id;
            $statushistory->body = "Status Update To - ".$status;
            $statushistory->save();
            //Status History Added Code End
        }
        
		return response()->json(['status' => 201, 'message' => 'Your loan application status has been successfully update.']);
    }
    
    
    public function assessorupdate(Request $request){
        $request->validate([
		    'popup_status_id' => 'required',
		]);
		
		
        if($request->filled('popup_status_id')){
            
            $update = Application::whereid($request->popup_application_id)->update(['status_id' => $request->popup_status_id]);
            
            // Dispatch the job without delay
            $application = Application::find($request->popup_application_id);
            $application->reminder_sent_at = null;
            $application->save();
            
            //ADMIN LOG START
                $status = $application->current_status->status;
                $body = 'The status of Loan Application Number '.$application->application_number.' has been updated to '.$status;
                $title = 'Loan Application Status Update To - '.$status;
                $this->store_logs('admin', $title, $body, $application->id);
            //ADMIN LOG END
            
            
            $data = new AssessorReviewNote;
    		$data->assessor_note = $request->popup_assessor_note;
            $data->application_id = $request->popup_application_id;
    		$data->reviewer_id = Auth::id();
    		$data->status_id = $request->popup_status_id;
    		$data->save();
    		
    		$this->store_logs('admin', 'Add Assessor Note', $request->popup_assessor_note);
            
            if (in_array($application->status_id, [8, 10, 11])) {
                $data_stage = Application::find($application->id);
                $data_stage->stage = null;
                $data_stage->save();
            }
            
            if (in_array($application->status_id, [7, 8, 9, 11, 12])) {
                dispatch(new LoanApplicationStatusUpdate($application))->delay(now()->addSeconds(10));
            }
            
            //Status History Added Code Start
            $statushistory = new StatusHistory;
            $statushistory->user_id = $application->user_id;
            $statushistory->application_id = $application->id;
            $statushistory->status_id = $application->status_id;
            $statushistory->body = "Status Update To - ".$status;
            $statushistory->save();
            //Status History Added Code End
        }
        
		return response()->json(['status' => 201, 'message' => 'Your loan application status has been successfully update.']);
    }

}
