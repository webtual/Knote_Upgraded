<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Application;
use App\User;
use App\Document;

use Response;



class DocumentController extends Controller
{
    public function destory(Request $request){
    	$application_id = $request->application_id;
    	$id = $request->document_id;
        $application = auth()->user()->stage_application();
        $this->authorize('delete', $application);
        $document = Document::find($id);
        //Storage::delete('/public/'.$document->file);

        $data = Document::find($id);
       	$data->delete();
        return response()->json(['status' => 201, 'message' => 'Document image has been successfully removed.']);
    }

}
