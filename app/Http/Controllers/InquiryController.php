<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Mail;

use App\User;
use App\Inquiry;
use Hash;

//use App\Mail\PopUpInquiry;
use App\Jobs\SendInquiryEmail;
use App\Jobs\CallBackInquiryEmailToAdmin;
use App\Jobs\CallBackInquiryEmailToClient;
use DataTables;
use App\Traits\Loggable;

class InquiryController extends Controller
{
    use Loggable;

    public function inquiries_export(Request $request)
    {
        $t = time();

        $filename = "inquiries-Export-" . $t;

        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM

        $data = Inquiry::select('*');

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }

        if ($request->has('search_name') && $request->filled('search_name')) {
            $data->where('name', 'like', '%' . $request->search_name . '%');
        }

        if ($request->has('search_email') && $request->filled('search_email')) {
            $data->where('email', 'like', '%' . $request->search_email . '%');
        }

        if ($request->has('search_contact') && $request->filled('search_contact')) {
            $data->where('contact', 'like', '%' . $request->search_contact . '%');
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

        $apply_for = config('constants.apply_for');
        $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;

        $columns = array('Customer No', 'Title', 'Know About Us', 'Full Name', 'Email', 'Phone', 'Message', 'Created Date');

        $callback = function () use ($data, $columns, $bom, $apply_for) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $customer_no = $row->user->customer_no;
                $apply_for_val = $apply_for[$row->apply_for];
                $know_about_us_val = $row->know_about_us == 8 ? $row->know_about_us_others : ($KNOW_ABOUT_US_VAL[$row->know_about_us] ?? '');
                $name = $row->name;
                $email = $row->email;
                $contact = $row->contact;
                $message = $row->message;
                $created_at = display_date_format($row->created_at);

                fputcsv($file, array($customer_no, $apply_for_val, $know_about_us_val, $name, $email, $contact, $message, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    public function get_inquiries_msg(Request $request)
    {
        $inq_id = $request->inquiry_id;
        $data = Inquiry::find($inq_id);

        return response()->json(['status' => 200, 'message' => 'success.', 'data' => $data]);
    }

    public function inquiries_msg_update(Request $request)
    {

        $rules = [
            'message_val' => 'required',
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $inq_id = $request->inquiry_id;

        $update = Inquiry::find($inq_id);
        $update->message = $request->message_val;
        $update->save();

        //ADMIN LOG START
        $data = Inquiry::select('*')->where('id', $inq_id)->first();
        $body = 'Inquiry notes has been updated for: ' . $data->contact;
        $title = 'Inquiry Notes Updated';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        return response()->json(['status' => 200, 'message' => 'Your message has been updated successfully.', 'data' => '']);
    }

    public function inquiries_add(Request $request)
    {

        $rules = [
            'fullname' => 'required',
            'phone' => 'required|min:12',
            'email' => 'required|email',
        ];

        $customMessages = [
            'phone.min' => 'The contact format is invalid.'
        ];

        $this->validate($request, $rules, $customMessages);

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
        $n->page_url = url('admin/inquiries');
        $n->name = $request->fullname;
        $n->know_about_us = $request->know_about_us;
        $n->know_about_us_others = $request->know_about_us_others ?? null;
        $n->contact = str_replace(' ', '', $request->phone);
        $n->email = $request->email;
        $n->message = $request->message;
        $n->ip_address = get_user_ip();
        $n->apply_for = $request->apply_for;
        $n->save();



        //New Inquiry Email Send to Admin & Client
        dispatch(new CallBackInquiryEmailToAdmin($n))->delay(now()->addSeconds(10));
        if ($request->email != "") {
            //dispatch(new CallBackInquiryEmailToClient($n))->delay(now()->addSeconds(10));
        }

        //ADMIN LOG START
        $data = Inquiry::select('*')->where('id', $n->id)->first();
        $body = 'Inquiry has been added for: ' . $data->contact;
        $title = 'New Inquiry Added';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        return response()->json(['status' => 200, 'message' => 'Your request has been successfully submited.', 'data' => '']);

    }

    public function store(Request $request)
    {

        /*$request->validate([
            'name' => 'required',
            'contact' => 'required|regex:/^[0-9]+$/|min:10',
            'email' => 'required|email',
            'purpose_of_visit' => 'required',

        ]);
        */

        $rules = [
            'name' => 'required',
            'contact' => 'required|regex:/^[0-9]+$/|min:10',
            'email' => 'required|email',
            'purpose_of_visit' => 'required',
        ];

        $customMessages = [
            'contact.min' => 'The contact format is invalid.'
        ];

        $this->validate($request, $rules, $customMessages);

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

        $inq = new Inquiry;
        $inq->user_id = $user->id;
        $inq->name = $request->name;
        $inq->contact = $request->contact;
        $inq->email = $request->email;
        $inq->message = $request->message;
        $inq->purpose_of_visit_id = $request->purpose_of_visit;
        $inq->know_about_us = $request->know_about_us;
        $inq->know_about_us_others = $request->know_about_us_others ?? null;
        $inq->page_url = $request->page_url;
        $inq->ip_address = get_user_ip();
        $inq->save();

        $status = dispatch(new SendInquiryEmail($inq))->delay(now()->addSeconds(10));

        return response()->json(['status' => 201, 'message' => 'Your request has been successfully submited.', 'data' => '']);

    }

    public function index()
    {
        $inquiry = [];
        return view('admin.inquiry.index', compact('inquiry'));
    }

    public function ajax_list(Request $request)
    {

        $data = Inquiry::select('*');

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }

        if ($request->has('search_name') && $request->filled('search_name')) {
            $data->where('name', 'like', '%' . $request->search_name . '%');
        }

        if ($request->has('search_email') && $request->filled('search_email')) {
            $data->where('email', 'like', '%' . $request->search_email . '%');
        }

        if ($request->has('search_contact') && $request->filled('search_contact')) {
            $data->where('contact', 'like', '%' . $request->search_contact . '%');
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

        $apply_for = config('constants.apply_for');
        $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('apply_for', function ($row) use ($apply_for) {
                return $apply_for[$row->apply_for];
            })
            ->addColumn('customer_no', function ($row) {
                $customer_no = $row->user->customer_no;
                return $customer_no;
            })
            ->addColumn('contact_no', function ($row) {
                return $row->contact;
            })
            ->addColumn('know_about_us', function ($row) use ($KNOW_ABOUT_US_VAL) {
                return $row->know_about_us == 8 ? $row->know_about_us_others : ($KNOW_ABOUT_US_VAL[$row->know_about_us] ?? '');
            })
            ->addColumn('created_at', function ($row) {
                return display_date_format_time($row->created_at);
            })
            ->addColumn('order_by_val', function ($row) {
                return strtotime($row->created_at);
            })
            ->addColumn('msg_val', function ($row) {
                $html = '';
                $html .= '<a href="javascript:;" title="Edit" data-id="' . $row->id . '" class="action-icon inquiry-edit"><i class="fa fa-edit text-success"></i></a>' . nl2br(e($row->message));
                return $html;
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<a href="javascript:;" title="Delete" data-action="' . url('admin/inquiries-delete') . '" data-id="' . $row->id . '" class="action-icon inquiry-delete"><i class="mdi mdi-delete text-danger"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'apply_for', 'action', 'contact_no', 'msg_val', 'customer_no', 'know_about_us'])
            ->make(true);
    }

    public function destroy(Request $request)
    {
        $data = Inquiry::find($request->id);

        //ADMIN LOG START
        $body = 'Inquiry has been deleted for: ' . $data->contact;
        $title = 'Inquiry Deleted';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $data->delete();
        return response()->json(['status' => 201, 'message' => "Record has been removed successfully.", 'data' => []]);
        //return back()->with('success','Record has been removed successfully.');
    }


}
