<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\User;
use App\Inquiry;
use App\OtpVerification;


use App\Rules\Captcha;

use Response;
use Auth;

use App\Jobs\BrokerRegisterEmailToAdmin;
use App\Jobs\CallBackInquiryEmailToAdmin;
use App\Jobs\CallBackInquiryEmailToClient;

use App\Jobs\SentOtp;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data){
        /*return Validator::make($data, [
            'type' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'privacy_and_credit_policy' => ['required'],
            'g-recaptcha-response' => new Captcha(),
        ]);*/
    }
    
    public function showRegistrationFormBroker(Request $request){
        $data = array();
        
        return view('auth.broker_register', compact('data'));
    }
    
    public function broker_store(Request $request){
        
        // Retrieve the CSRF token value
        $token = csrf_token();
        
        // Retrieve the CSRF token submitted with the request
        $submittedToken = request()->input('_token');
        
        if ($token === $submittedToken) {
            
                $rules = [
                    'fullname' => 'required|max:50',
                    'email' => 'required|email|max:100',
                    'phone' => 'required|min:12',
                ];
            
                $customMessages = [
                    'fullname.required' => 'Full name is required.',
                    'fullname.max' => 'Full name cannot exceed 50 characters.',
                    'email.required' => 'Email address is required.',
                    'email.email' => 'Enter a valid email address.',
                    'email.max' => 'Email address cannot exceed 100 characters.',
                    'phone.required' => 'Phone number is required.',
                    'phone.min' => 'Phone number must be at least 12 characters.',
                ];
            
                $validator = \Validator::make($request->all(), $rules, $customMessages);
            
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors(),
                    ], 422);
                }
            
                // Process the form if validation passes.
                $phone = str_replace(' ', '', $request->phone);
                
                $users = User::with('roles')->where('phone', $phone)->whereHas('roles', function ($q) {
                    $q->where('type', 1)->where('slug', 'broker');
                })->first();
                
                if ($users !== null) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => [
                            'phone' => ['The entered phone number already exists for a broker.']
                        ],
                    ], 422);
                }
                        
                $user = new User;
                $user->name = $request->fullname;
                $user->address = $request->address;
                $user->register_from = 'Broker';
                $user->email = $request->email;
                $user->phone = $phone;
                $user->is_active = 0;
                $user->password = Hash::make($phone);
                $user->email_verified_at = Hash::make($phone);
                $user->save();
                
                $role = 6;
                $user->roles()->attach($role);
                
                //New Inquiry Email Send to Admin
                dispatch(new BrokerRegisterEmailToAdmin($user))->delay(now()->addSeconds(10));
                
                //Thank you mail sent to broker.
                return response()->json(['status' => '201', 'message' => 'Your broker registration request has been submitted successfully.']);
                
           
        }else{
            return response()->json(['status' => 403, 'message' => "CSRF token mismatch", 'data' => [] ]);
        }
    }

    protected function create(array $data){
        return User::create([
            'name' => $data['fullname'],
            'email' => $data['email'],
            'phone' => str_replace(' ', '', $data['phone']),
            'password' => Hash::make($data['password']),
            'email_verified_at' => Hash::make($data['email'].$data['password']),
        ]);
    }

    public function register(Request $request){
        /*$request->validate([
            'role' => ['required'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'unique:users'],
            'password' => ['required', 'required_with:confirm_password', 'same:confirm_password', 'string', 'min:8'],
            'confirm_password' => ['min:8'],
            'terms_and_condition' => ['required'],
        ]);*/

        $rules = [
            'role' => ['required'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'min:12', 'unique:users'],
            // 'password' => ['required', 'required_with:confirm_password', 'same:confirm_password', 'string', 'min:8'],
            // 'confirm_password' => ['min:8'],
            //'terms_and_condition' => ['required'],
        ];

        $customMessages = [
            'phone.min' => 'The phone format is invalid.'
        ];
        $this->validate($request, $rules, $customMessages);


        $is_exits = User::where('phone', str_replace(' ', '', $request->phone))->get()->count();
        
        if($is_exits == 0)
        {
            $user = $this->create($request->all()); 
            $user->roles()->attach($request->role); //User role
            /*
            if($user->roles->first()->type == '0')
            */
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)){
                 return response()->json(['status' => '201', 'message' => 'Your registration has been successfully complete.']);
            }
        }
        else
        {
            return response()->json(['status' => '401', 'message' => 'That phone no is already registered.']);
        }
    }
    
    public function validateStep2(Request $request){
        
        // Retrieve the CSRF token value
        $token = csrf_token();
        
        // Retrieve the CSRF token submitted with the request
        $submittedToken = request()->input('_token');
        
        if ($token === $submittedToken) {
            if($request->request_a_callback == 1){
                $rules = [
                    'role' => ['required'],
                    'fullname' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    //'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
                    'phone' => ['required', 'min:12'],
                    'know_about_us' => ['required'],
                ];
            }else{
                $rules = [
                    'role' => ['required'],
                    'fullname' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    //'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
                    'phone' => ['required', 'min:12'],
                    'know_about_us' => ['required'],
                    //'password' => ['required', 'required_with:confirm_password', 'same:confirm_password', 'string', 'min:8'],
                    //'confirm_password' => ['min:8'],
                ];
            }
    
            $customMessages = [
                'phone.min' => 'The phone format is invalid.'
            ];
            $this->validate($request, $rules, $customMessages);
            
            
            if($request->request_a_callback == 1){
                
                $is_exit_same_day_count = Inquiry::select('id')->where('ip_address', get_user_ip())->whereDate('created_at', date('Y-m-d'))->get()->count();
                if($is_exit_same_day_count > 10){
                    return response()->json(['status' => '401', 'message' => 'You have reached the maximum number of allowed attempts. Please try again later.']);
                }
                
                $phone = str_replace(' ', '', $request->phone);
                $user = User::where('phone', $phone)->first();
                
                if ($user == null) {
                    $users = new User;
                    $customer_no = $users->last_customer_no();
                    
                    $user = User::create([
                        'name' => $request->fullname,
                        'email' => $request->email,
                        'customer_no' => $customer_no,
                        'phone' => $phone,
                        'password' => Hash::make($phone),
                        'email_verified_at' => Hash::make($phone),
                    ]);
                    $role = 3;
                    $user->roles()->attach($role);
                }
                
                $n = new Inquiry;
                $n->user_id = $user->id;
                $n->purpose_of_visit_id = 0;
                $n->page_url = url('register/loan-applicant');
                $n->name = $request->fullname;
        		$n->contact = str_replace(' ', '', $request->phone);
        		$n->email = $request->email;
        		$n->know_about_us = $request->know_about_us;
        		$n->know_about_us_others = $request->know_about_us_others ?? null;
        		//$n->message = "";
                $n->ip_address = get_user_ip();
                $n->apply_for = $request->apply_for;
                $n->save();
                
                //New Inquiry Email Send to Admin
                dispatch(new CallBackInquiryEmailToAdmin($n))->delay(now()->addSeconds(10));
                if($request->email != ""){
                    dispatch(new CallBackInquiryEmailToClient($n))->delay(now()->addSeconds(10));
                }
                
                //Thank you mail sent to customer.
                return response()->json(['status' => '201', 'message' => 'Your callback request has been successfully sent.']);
            }else{
                
                $is_exit_same_day_count = OtpVerification::select('id')->where('ip_address', get_user_ip())->whereDate('created_at', date('Y-m-d'))->get()->count();
                
                if($is_exit_same_day_count > 10){
                    return response()->json(['status' => '401', 'message' => 'You have reached the maximum number of allowed attempts. Please try again later.']);
                    
                }else{
                    
                    $phone = str_replace(' ', '', $request->phone);
                    
                    // Sent OTP Verification
                    $otp = sprintf("%06d", mt_rand(1, 999999));
                    $sms_text = config('constants.sms_otp_text');
                    $sms_text = str_replace("{OTP}",$otp,config('constants.sms_otp_text'));
                    $sms_status = sent_sms($phone, $sms_text);
                    
                    
                    // Sent Email 
                    $user_object = new \stdClass();
                    $user_object->name = $request->fullname;
                    $user_object->email = $request->email;
                    $user_object->phone = $phone;
                    $user_object->otp = $otp;
                    (new SentOtp($user_object))->handle();
                   
                    
                    $n = new OtpVerification;
                    //$n->mobile_number = $request->countrycode.str_replace(' ', '', $request->phone);
                    $n->mobile_number = str_replace(' ', '', $request->phone);
                    $n->otp = $otp;
                    $n->ip_address = get_user_ip();
                    $n->request_information = json_encode($request->all());
                    $n->sms_response = $sms_status;
                    $n->is_application = 1;
                    $n->save();
                    
                    session()->forget('otp_verification_obj');
                    
                    session(['otp_verification_obj' => $n]);
                    return response()->json(['status' => '201', 'message' => 'OTP has been sent to input mobile number.']);       
                }
            }
        }else{
            return response()->json(['status' => 403, 'message' => "CSRF token mismatch", 'data' => [] ]);
        }
    }

    public function validateStep3(Request $request){
       
        $rules = [
            'otp' => ['required', 'max:6', 'min:6'],
        ];
       
        $customMessages = [
            'otp.min' => 'The OTP format is invalid.',
            'otp.max' => 'The OTP format is invalid.'
        ];
        $this->validate($request, $rules, $customMessages);
        
        $otp_verification_obj = session('otp_verification_obj');
        
        if(config('constants.sms_sent_flag') == 1){
            $exit_otp = $otp_verification_obj->otp;   
        }else{
            $exit_otp = "123456";    
        }
        
        
        $request_otp = $request->otp;
        
        if($exit_otp != $request_otp){
            $error = array(
                "message" => "The given data was invalid.",
                "errors" => array(
                    "otp" => array("Invalid OTP Provided.")    
                )
            );
            return response()->json($error, 422);
        }else{
            
            $reg_form = json_decode($otp_verification_obj->request_information, true);
            
            $fullname = $reg_form['fullname'];
            $email = $reg_form['email'];
            $phone = $reg_form['phone'];
            $role = $reg_form["role"];
            $apply_for = $reg_form["apply_for"];
            $know_about_us = $reg_form["know_about_us"];
            $know_about_us_others = $reg_form["know_about_us_others"];
            
            
            $is_exits = User::where('phone', str_replace(' ', '', $phone))->whereHas('roles', function ($q) {
                $q->whereIn('role_id', [3]);
            })->first();
            
            if($is_exits == null){
                $users = new User;
                $customer_no = $users->last_customer_no();
                
                $user = User::create([
                    'name' => $fullname,
                    'email' => $email,
                    'customer_no' => $customer_no,
                    'phone' => str_replace(' ', '', $phone),
                    'password' => Hash::make($phone),
                    'email_verified_at' => Hash::make($phone),
                ]);
                $user->roles()->attach($role);
                $user_id = $user->id;
            }else{
                $user_id = $is_exits->id;
            }
            
            Auth::loginUsingId($user_id);
            
            return response()->json(['status' => '201', 'message' => 'Your OTP has been successfully verified.']);   
            
        }
        
    }

}
