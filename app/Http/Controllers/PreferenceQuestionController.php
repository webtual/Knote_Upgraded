<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\PreferenceQuestion;
use App\AnswerUser;
use App\QuestionAnswer;
use App\Inquiry;
use App\Role;

use Auth;
use Carbon\Carbon;

class PreferenceQuestionController extends Controller
{
    public function index(){
        $questions = PreferenceQuestion::get();
        return view('admin.prerequisite_questions.list', compact('questions'));
    }

    public function create(){
        $roles = Role::whereIn('id', [4,5])->get();
        return view('admin.prerequisite_questions.create', compact('roles'));
    }

    public function storeAdmin(Request $request){
        $request->validate([
            'role' => ['required', 'string', 'max:255'],
            'question_title' => ['required', 'string', 'max:255'],
            'field_type' => ['required', 'string', 'max:255'],
        ]);

        if($request->field_type != 'input'){
            $rules = [
                "answer_text"    => "required|array",
                "answer_text.*"  => "required",
            ];

            $customMessages = [
                'answer_text.required' => 'The answer text field is required.',
                'answer_text.*' => 'The answer text field is required.'
            ];
            $this->validate($request, $rules, $customMessages);
        }

        $question = New PreferenceQuestion;
        $question->role_id = $request->role;
        $question->title = $request->question_title;
        $question->type = $request->field_type;
        $question->save();

        if($request->field_type != 'input'){
            for($i= 0; $i < count($request->answer_text); $i++){
                if($request->answer_text[$i] != ""){
                    $data_set = [
                        'preference_question_id' => $question->id,
                        'answer_text' => $request->answer_text[$i],
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ];
                    if(!empty($data_set)){
                        QuestionAnswer::insert($data_set);
                    }
                }
            }
        }

        return response()->json(['status' => 201, 'message' => 'Prerequisite Question has been successfully added.']);
    }



    public function store(Request $request){
        /*
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'unique:users'],
            'password' => ['required', 'required_with:confirm_password', 'same:confirm_password', 'string', 'min:8'],
            'confirm_password' => ['min:8'],
        ]);*/


        $rules = [
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'unique:users'],
            //'password' => ['required', 'required_with:confirm_password', 'same:confirm_password', 'string', 'min:8'],
            //'confirm_password' => ['min:8'],
        ];

        $customMessages = [
            'phone.min' => 'The phone format is invalid.'
        ];
        $this->validate($request, $rules, $customMessages);

        /*
        $user = New User;
        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = Hash::make($request->email.$request->password);
        $user->save();
        $user->roles()->attach($request->role_id);*/

        $inq = new Inquiry;
        $inq->name = $request->fullname;
        $inq->contact = $request->phone;
        $inq->email = $request->email;
        //$inq->message = $request->message;
        $inq->purpose_of_visit_id = $request->purpose_of_visit;
        $inq->page_url = $request->page_url;
        $inq->ip_address = get_user_ip();
        $inq->save();


        $request_data = $request->except(array('_token', 'page_url', 'purpose_of_visit', 'fullname', 'email', 'phone', 'password', 'confirm_password', 'role_id', 'countrycode'));

        foreach($request_data as $id => $answer){
            if($answer == ""){ 
                return response()->json(['status' => 401, 'message' => 'The my preferences all field are mandatory.']); 
            }

            $add_question = New AnswerUser;
            $add_question->inquiry_id = $inq->id;
            $add_question->preference_question_id = $id;
            $add_question->question_answer = $answer;
            $add_question->save();
        }

        //Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        return response()->json(['status' => 201, 'message' => 'Your registration has been successfully completed.']);

    }


    public function edit($id){
        $question = PreferenceQuestion::find($id);
        $roles = Role::whereIn('id', [4,5])->get();
        return view('admin.prerequisite_questions.edit', compact('question', 'roles'));
    }


    public function updateAdmin($id, Request $request){
        $request->validate([
            'role' => ['required', 'string', 'max:255'],
            'question_title' => ['required', 'string', 'max:255'],
            'field_type' => ['required', 'string', 'max:255'],
        ]);

        if($request->field_type != 'input'){
            $rules = [
                "answer_text"    => "required|array",
                "answer_text.*"  => "required",
            ];

            $customMessages = [
                'answer_text.required' => 'The answer text field is required.',
                'answer_text.*' => 'The answer text field is required.'
            ];
            $this->validate($request, $rules, $customMessages);
        }

        $question = PreferenceQuestion::find($id);
        $question->role_id = $request->role;
        $question->title = $request->question_title;
        $question->type = $request->field_type;
        $question->save();

        if($request->field_type != 'input'){
            $question->question_answers()->delete();
            for($i= 0; $i < count($request->answer_text); $i++){
                if($request->answer_text[$i] != ""){
                    $data_set = [
                        'preference_question_id' => $question->id,
                        'answer_text' => $request->answer_text[$i],
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ];
                    if(!empty($data_set)){
                        QuestionAnswer::insert($data_set);
                    }
                }
            }
        }

        return response()->json(['status' => 201, 'message' => 'Prerequisite Question has been successfully updated.']);
    }
    


    public function update(Request $request){
        $request_data = $request->except('_token');
        foreach($request_data as $id => $answer){
            if($answer == ""){ 
                return response()->json(['status' => 401, 'message' => 'The my preferences all field are mandatory.']); 
            }
            $count = AnswerUser::wherepreference_question_id($id)->whereuser_id(auth()->user()->id)->count();
            if($count != "0"){
                $update = AnswerUser::wherepreference_question_id($id)->whereuser_id(auth()->user()->id)->update(['question_answer' => $answer]);
            }else{
                $insert = AnswerUser::insert(['question_answer' => $answer, 'user_id' => auth()->user()->id, 'preference_question_id' => $id, 'created_at' => Carbon::now()]);
            }
           
        }
        return response()->json(['status' => 200, 'message' => 'Your preferences has been update successfully.']);
    }

  

    public function destroy($id){
        $data = PreferenceQuestion::find($id);
        $data->question_answers()->delete();
        $data->delete();
        return back()->with('success','Record has been removed successfully.');
    }

  
}
