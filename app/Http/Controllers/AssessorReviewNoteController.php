<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\User;
use App\AssessorReviewNote;
use App\AssessorReviewDocuments;
use App\Application;

use Validator;
use Response;
use Auth;
use App\Traits\Loggable;

class AssessorReviewNoteController extends Controller
{
    use Loggable;
    
    public function assessor_store(Request $request){
        $request->validate([
		    'assessor_note' => 'required',
		]);
		
		$data = new AssessorReviewNote;
		$data->assessor_note = $request->assessor_note;
        $data->application_id = Crypt::decrypt($request->assessor_application_id);
		$data->reviewer_id = Auth::id();
		$data->status_id = $request->status_vals;
		$data->save();
		
		$this->store_logs('admin', 'Add Assessor Note', $request->assessor_note);
		
		if ($request->hasFile('assessor_file')) {
            foreach ($request->file('assessor_file') as $file) {
                $new_record = new AssessorReviewDocuments;
                $assessor_file = \Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/assessor', $assessor_file);
                $new_record->assessor_file = 'assessor/' . $assessor_file;
                $new_record->assessor_review_note_id = $data->id;
                $new_record->save();
            }
        }
        
        $html = '<div class="post-user-comment-box p-2 mb-2 mt-0">
             <div class="media">
                <div class="media-body p-1">
                   <h5 class="mt-0"> '.$data->user->name.' <small class="text-muted">1 sec ago</small></h5>
                   '.$data->assessor_note.'
                   <br>
                </div>
             </div>
        </div>';
		return response()->json(['status' => 201, 'message' => 'Your review has been sucessfully added.', 'html' => $html]);
    }

}
