<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Application;
use App\Models\EmailTemplate;
use App\Models\EmailSendAttachment;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Mail\EmailMainTemplates;
use App\Models\Setting;
use App\Models\EmailSend;
use App\Traits\Loggable;

class EmailTemplatesController extends Controller
{
    use Loggable;
    
    public function email_indent_send(Request $request) {
        $application = Application::find($request->application_id_val);
        $application_number = $application->application_number;
        $customer_name = $application->user->name;
        $from_email = Setting::get('MAIL_FROM_ADDRESS');
        $place_holders = ['%CUSTOMER_NAME%'];
        $values = [$customer_name];
        $subject = str_replace($place_holders, $values, $request->subject);
        $message = str_replace($place_holders, $values, $request->message);
        
        $data = new EmailSend;
        $data->application_id = $request->application_id_val;
        $data->to_email = $request->email_to;
        $data->subject = $subject;
        $data->body = $message;
        $data->from_email = $from_email;
        $data->to_name = $customer_name;
        $data->cc_email = Setting::get('CC');
        $data->bcc_email = Setting::get('BCC');
        $data->reply_to_email = Setting::get('MAIL_FROM_ADDRESS');
        $data->user_id = auth()->user()->id;
        $data->save();
        
        if ($request->filled('attachments')) {
            foreach (explode(', ', $request->attachments) as $key => $file) {
                $filename = parse_url($file, PHP_URL_PATH);
                $attachment = new EmailSendAttachment;
                $attachment->email_send_id = $data->id;
                $attachment->file_name = basename($filename);
                $attachment->save();
            }
        }
        
        if (preg_match('/\s/', $request->email_to)) {
            $email_to = str_replace(' ', '', $request->email_to);
        } else {
            $email_to = $request->email_to;
        }
        if (strpos($email_to, ',') !== false) {
            $email_to = explode(',', $email_to);
        }
        $email_data = ["to" => $email_to, "name" => $customer_name, "message" => $message, "subject" => $subject, "attachments" => ($request->filled('attachments')) ? explode(', ', $request->attachments) : '', "from_email" => $from_email, "bcc" => Setting::get('BCC'), "cc" => Setting::get('CC'), "reply_to" => Setting::get('MAIL_FROM_ADDRESS')];
        try {
            Mail::to($email_to)->send(new EmailMainTemplates($email_data));
            \App\SystemEventLog::send_email_log($email_data);
        }
        catch(\Exception $e) {
            $error = $e->getMessage();
            $is_sent = 0;
            \App\SystemEventLog::send_email_log($email_data, $is_sent, $error);
        }
        return response()->json(['status' => '200', 'message' => 'Email has been send successfully.']);
    }
    
    public function get_email_template(Request $request) {
        $email_template = EmailTemplate::find($request->email_template_id);
        $message = "";
        $subject = "";
        if($email_template != null){
            $message = $email_template->body;
            $subject = $email_template->subject;
        }
        return response()->json(['status' => '200', 'message' => '', 'html' => $message, 'subject' => $subject]);
    }
    
   	public function index(){
        return view('admin.email_templates.index');
    }
    
    public function ajax_list(Request $request){
        
        $data = EmailTemplate::where('is_active_email_indent', 1);
        
        if ($request->has('search_title') && $request->filled('search_title')) {
            $data->where('title', 'like', '%' . $request->search_title . '%');
        }
        
        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $to_date = date('Y-m-d', strtotime($to_date . ' + 1 days'));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }
        
        $data = $data->orderBy('id', 'DESC')->get();
        
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('created_at', function($row){
            return display_date_format_time($row->created_at);
        })
        ->addColumn('order_by_val', function($row){
            return strtotime($row->created_at);
        })
        ->addColumn('status', function($row){
            return $row->status == 1 ? 'Active' : 'InActive';
        })
        ->addColumn('action', function($row){
            $html = '';
            $url_1 = url('admin/email-templates/edit/'.\Crypt::encrypt($row->id));
            $html .= '<a href="'.$url_1.'" title="Edit" class="action-icon"><i class="fa fa-edit text-success"></i></a>';
            return $html;
	    })
        ->rawColumns(['order_by_val','action','status'])
        ->make(true);
    }
    
    public function create(Request $request){
        return view('admin.email_templates.create');
    }

    public function store(Request $request){
        $rules = [
            'title' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ];
    
        $customMessages = [
            'title.required' => 'The title field is required.',
            'subject.required' => 'The subject field is required.',
            'body.required' => 'The body field is required.',
        ];
    
        $validator = \Validator::make($request->all(), $rules, $customMessages);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $data = new EmailTemplate;
       	$data->title = $request->title;
       	$data->subject = $request->subject;
       	$data->body = $request->body;
       	$data->is_active_email_indent = 1;
       	$data->status = 1;
       	$data->save();
        
        return response()->json(['status' => 200, 'message' => 'Your email templates has been successfully added.']);
    }
   
    public function edit(Request $request, $enc_id){
        $id = Crypt::decrypt($enc_id);
        $result = EmailTemplate::find($id);
        return view('admin.email_templates.edit', compact('result'));
    }
    
    public function update(Request $request){
        $rules = [
            'title' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ];
    
        $customMessages = [
            'title.required' => 'The title field is required.',
            'subject.required' => 'The subject field is required.',
            'body.required' => 'The body field is required.',
        ];
    
        $validator = \Validator::make($request->all(), $rules, $customMessages);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $data = EmailTemplate::find($request->temp_id);
       	$data->title = $request->title;
       	$data->subject = $request->subject;
       	$data->body = $request->body;
       	$data->save();
        
        return response()->json(['status' => 200, 'message' => 'Your email templates has been successfully updated.']);
    }
   
}
