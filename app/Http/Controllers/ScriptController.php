<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Inquiry;
use App\Application;

class ScriptController extends Controller
{
    
    
    public function customer_no_update_inquiry(Request $request){
        
        $data = Inquiry::where('user_id', '=', NULL)->orderBy('id', 'ASC')->get();
        
        $number = 0;
        
        $count = sizeof($data);
        
        foreach ($data as $val){
        	$phone = str_replace(' ', '', $val->contact);
            $user = User::where('phone', $phone)->first();
            
            if ($user == null) {
                $users = new User;
                $customer_no = $users->last_customer_no();
                
                $user = User::create([
                    'name' => $val->name,
                    'email' => $val->email,
                    'customer_no' => $customer_no,
                    'phone' => $phone,
                    'password' => Hash::make($phone),
                    'email_verified_at' => Hash::make($phone),
                ]);
                $role = 3;
                $user->roles()->attach($role);
            }
            
            $n = Inquiry::find($val->id);
            $n->user_id = $user->id;
            $n->save();
        }
        
    	$app_response = [];
    	$app_response['row_count'] = $count;
        return response()->json(['status' => 200, 'message' => 'The customer number has been generated successfully.', 'data' => $app_response]);
    }
    
    public function customer_no_update(Request $request){
        
        $data = User::withTrashed()->select('users.id as userId','users.*')->whereHas('roles', function($q){
            $q->where('type', '=', 0);
        })->where('customer_no', '=', NULL)->orderBy('id', 'ASC')->get();
        
        $number = 0;
        
        $count = sizeof($data);
        
        foreach ($data as $val){
        	$user_id = $val->userId;
        	
        	$pretax = "KN";
        	$year = date('Y');
        	
        	$prefix = $pretax."".$year;
        	
        	$new_number = str_pad($number + 1, 2, 0, STR_PAD_LEFT);
        		
        	$customer_no = $prefix."".$new_number;
        	
        	$user = User::withTrashed()->find($user_id);
    		$user->customer_no = $customer_no;
    		$user->save();
    		
    		$number++;
        }
        
    	$app_response = [];
    	$app_response['row_count'] = $count;
        return response()->json(['status' => 200, 'message' => 'The customer number has been generated successfully.', 'data' => $app_response]);
    }
    
    public function application_no_update(Request $request){
        
        $data = Application::withTrashed()->select('*')->where('application_number', '=', NULL)->orderBy('id', 'ASC')->withTrashed()->get();
        
        $number = 0;
        
        $count = sizeof($data);
        
        foreach ($data as $val){
        	$application_id = $val->id;
        	
        	$pretax = "";
        	$year = date('Y');
        	
        	$prefix = $pretax."".$year;
        	
        	$new_number = str_pad($number + 1, 2, 0, STR_PAD_LEFT);
        		
        	$application_number = $prefix."".$new_number;
        	
        	$application = Application::withTrashed()->find($application_id);
    		$application->application_number = $application_number;
    		$application->save();
    		
    		$number++;
        }
        
    	$app_response = [];
    	$app_response['row_count'] = $count;
        return response()->json(['status' => 200, 'message' => 'The application number has been generated successfully.', 'data' => $app_response]);
    }
    
    
}