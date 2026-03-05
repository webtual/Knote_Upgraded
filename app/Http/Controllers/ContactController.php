<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rules\Captcha;
use App\Inquiry;
use App\User;

use Validator;
use Response;

use App\Jobs\SendContactEmail;
use Carbon\Carbon;

use Mail;
use App\Mail\ContactInquiry;

class ContactController extends Controller
{
    
    public function store(Request $request){
        /*$request->validate([
		    'name' => 'required',
		    'contact' => 'required|regex:/^[0-9]+$/|min:10',
		    'email' => 'required|email',
            'message' => 'required',
		    //'g-recaptcha-response' => new Captcha(),
		]);*/

        $rules = [
            'name' => 'required',
            'contact' => 'required|regex:/^[0-9]+$/|min:10',
            'email' => 'required|email',
            'message' => 'required',
        ];

        $customMessages = [
            'contact.min' => 'The contact format is invalid.'
        ];
        $this->validate($request, $rules, $customMessages);


		$data = New Inquiry;
		$data->name = $request->name;
		$data->contact = $request->contact;
		$data->email = $request->email;
		$data->message = $request->message;
        $data->ip_address = get_user_ip();
		$data->save();
        
        
        
        //$status = Mail::to(config('constants.contact_inquiry_receiver_email'))->send(new ContactInquiry($data)); 
                        
        
        $status = dispatch(new SendContactEmail($data))->delay(now()->addSeconds(10));
        //$status = dispatch(New SendContactEmail($data))->delay(Carbon::now()->setTimezone('Australia/Melbourne')->addSeconds(10));
        /*
            $status = Mail::to(config('constants.contact_inquiry_receiver_email'))
                            ->send(new ContactInquiry($data)); 
        */
		return response()->json(['status' => 200, 'message' => 'Your request has been successfully submited. we will get back to you soon.']);

    }


    /**
    Admin Route Method
    *****************/

    /* 
    public function index(){
        $contacts = Contact::orderBy('id','DESC')->get();
    	return view('admin.contacts.index', compact('contacts'));
    }
    public function destroy($id){
        $data = Contact::find($id);
       	$data->delete();
       	return back()->with('success','Record has been removed successfully.');
    }
    */

}
