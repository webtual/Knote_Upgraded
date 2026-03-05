<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\User;
use Image;
use Hash;
use App\Traits\Loggable;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use App\Jobs\BrokerAcceptEmail;
use App\Jobs\BrokerRejectEmail;

class BrokersController extends Controller
{

    use Loggable;

    public function index()
    {
        return view('admin.brokers.list');
    }

    public function ajax_list(Request $request)
    {

        $data = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('type', 1)->where('slug', '=', 'broker');
        });

        if ($request->has('search_name') && $request->filled('search_name')) {
            $data->where('name', 'like', '%' . $request->search_name . '%');
        }

        if ($request->has('search_phone') && $request->filled('search_phone')) {
            $data->where('phone', 'like', '%' . $request->search_phone . '%');
        }

        if ($request->has('search_email') && $request->filled('search_email')) {
            $data->where('email', 'like', '%' . $request->search_email . '%');
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
            ->addColumn('created_at', function ($row) {
                return display_date_format_time($row->created_at);
            })
            ->addColumn('is_active', function ($row) {
                switch ($row->is_active) {
                    case 0:
                        return '<a href="javascript:;" title="Accept" data-action="' . url('admin/brokers/status/accept') . '" data-id="' . $row->id . '" class="action-icon btn btn-success text-white broker-accept"><i class="fa fa-check text-white"></i>Accept</a> <a href="javascript:;" title="Reject" data-id="' . $row->id . '" class="action-icon btn btn-danger text-white broker-reject"><i class="fa fa-times text-white"></i>Reject</a>';
                    case 1:
                        return '<span class="text-success"><b>Accepted</b></span>';
                    case 2:
                        return '<span class="text-danger"><b>Rejected</b></span>';
                    default:
                        return 'Unknown';
                }
            })
            ->addColumn('order_by_val', function ($row) {
                return strtotime($row->created_at);
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<a href="javascript:;" title="Edit" data-id="' . $row->id . '" class="action-icon broker-edit"><i class="fa fa-edit text-success"></i></a>';
                $html .= '<a href="javascript:;" title="Delete" data-action="' . url('admin/brokers-delete') . '" data-id="' . $row->id . '" class="action-icon broker-delete"><i class="mdi mdi-delete text-danger"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'action', 'is_active'])
            ->make(true);
    }

    public function export_data(Request $request)
    {
        $t = time();

        $filename = "Broker-Export-" . $t;

        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM


        $data = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('type', 1)->where('slug', '=', 'broker');
        });

        if ($request->has('search_name') && $request->filled('search_name')) {
            $data->where('name', 'like', '%' . $request->search_name . '%');
        }

        if ($request->has('search_phone') && $request->filled('search_phone')) {
            $data->where('phone', 'like', '%' . $request->search_phone . '%');
        }

        if ($request->has('search_email') && $request->filled('search_email')) {
            $data->where('email', 'like', '%' . $request->search_email . '%');
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

        $columns = array('Name', 'Phone', 'Email Address', 'Created Date', 'Status');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $name = $row->name;
                $phone = $row->phone;
                $email = $row->email;
                $statuses = [
                    0 => 'Pending',
                    1 => 'Accepted',
                    2 => 'Rejected',
                ];
                $status = $statuses[$row->is_active] ?? 'Unknown';
                $created_at = display_date_format($row->created_at);

                fputcsv($file, array($name, $phone, $email, $created_at, $status));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    public function create(Request $request)
    {
        return view('admin.brokers.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'fullname' => 'required',
            'email_address' => 'required|email',
            'phone' => 'required|min:12',
        ];

        $customMessages = [
            'fullname.required' => 'The full name field is required.',
            'email_address.required' => 'The email address field is required.',
            'email_address.email' => 'Please enter a valid email address.',
            'phone.required' => 'The phone number field is required.',
            'phone.min' => 'Please enter a valid phone number.'
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
        $user->register_from = 'Admin';
        $user->email = $request->email_address;
        $user->phone = $phone;
        $user->is_active = 0;
        //$user->account_verified_at = now();
        $user->password = Hash::make($phone);
        $user->email_verified_at = Hash::make($phone);
        $user->save();

        $role = 6;
        $user->roles()->attach($role);

        $body = 'The broker ' . $request->fullname . ' has been added';
        //ADMIN LOG START
        $this->store_logs('admin', 'New Broker Added', $body);
        //ADMIN LOG END

        return response()->json(['status' => 200, 'message' => 'Your broker has been successfully added.']);
    }

    public function get_users(Request $request)
    {
        $broker_id = $request->broker_id;
        $data = User::find($broker_id);

        return response()->json(['status' => 200, 'message' => 'success.', 'data' => $data]);
    }

    public function users_update(Request $request)
    {
        $broker_id = $request->broker_id;

        // Remove spaces from the phone field
        $phone = str_replace(' ', '', $request->phone);

        $rules = [
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($broker_id)],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', Rule::unique('users', 'phone')->ignore($broker_id)],
        ];

        $customMessages = [
            'phone.min' => 'The phone format is invalid.',
        ];

        // Update request with the sanitized phone number
        $request->merge(['phone' => $phone]);

        $this->validate($request, $rules, $customMessages);

        $data = User::find($broker_id);
        $data->name = $request->fullname;
        $data->address = $request->address;
        $data->email = $request->email;
        $data->is_active = $request->is_active;
        $data->phone = $phone;
        $data->save();

        $body = 'The broker ' . $request->fullname . ' has been updated';
        //ADMIN LOG START
        $this->store_logs('admin', 'Broker Updated', $body);
        //ADMIN LOG END

        return response()->json(['status' => 200, 'message' => 'Broker details has been updated successfully.', 'data' => '']);
    }

    public function users_status_reject_update(Request $request)
    {
        $brok_id = $request->brok_id;

        $rules = [
            'brok_id' => ['required'],
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::find($brok_id);
        $user->is_active = 2;
        $user->rejected_reason = $request->rejected_reason;
        $user->account_verified_at = now();
        $user->save();

        $send_mail = dispatch(new BrokerRejectEmail($user))->delay(now()->addSeconds(10));

        $body = 'Broker ' . $user->name . ' has been successfully rejected';
        //ADMIN LOG START
        $this->store_logs('admin', 'broker status rejected', $body);
        //ADMIN LOG END

        return response()->json(['status' => 200, 'message' => 'Broker registration request has been rejected successfully.', 'data' => '']);
    }

    public function users_status_accept_update(Request $request)
    {
        $id = $request->id;

        $rules = [
            'id' => ['required'],
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::find($id);
        $user->is_active = 1;
        $user->account_verified_at = now();
        $user->save();

        $send_mail = dispatch(new BrokerAcceptEmail($user))->delay(now()->addSeconds(10));

        $body = 'Broker ' . $user->name . ' has been successfully accepted';
        //ADMIN LOG START
        $this->store_logs('admin', 'broker status accepted', $body);
        //ADMIN LOG END

        return response()->json(['status' => 200, 'message' => 'Broker registration request has been accepted successfully.', 'data' => '']);
    }

    public function destroy_users(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'phone' => ['User not found.']
                ],
            ], 422);
        }

        // Check if any applications are linked to this broker
        $applicationCount = \DB::table('applications')->where('broker_id', $id)->count();

        $userLogsCount = \DB::table('user_logs')->where('user_id', $id)->count();
        if ($applicationCount != 0) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'phone' => ['Cannot delete. This broker has associated applications.']
                ],
            ], 422);
        } else {
            $body = 'The broker ' . $user->name . ' has been deleted';

            // ADMIN LOG START
            $this->store_logs('admin', 'Broker Deleted', $body);
            // ADMIN LOG END

            //$user->delete();

            \DB::table('user_logs')->where('user_id', $id)->delete();
            $user->forceDelete();

            return response()->json(['status' => 200, 'message' => 'Record has been removed successfully.', 'data' => '']);
        }

    }


}