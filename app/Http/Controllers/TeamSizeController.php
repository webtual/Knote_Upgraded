<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Application;
use App\User;
use App\TeamSize;

use Validator;
use Response;



class TeamSizeController extends Controller
{
    
    public function destory($id, Request $request){
        $application = auth()->user()->stage_application();
        $this->authorize('delete', $application);
        
        $data = TeamSize::find($id);
       	$data->delete();
        return response()->json(['status' => 201, 'message' => 'People has been successfully removed.']);
    }

    public function add(){
    	return view('partials.comman.loan.team_member_add');
    }

}
