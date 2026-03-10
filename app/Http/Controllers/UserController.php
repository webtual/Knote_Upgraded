<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use Image;
use Hash;
use App\Traits\Loggable;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    use Loggable;


    public function get_users(Request $request): \Illuminate\Http\JsonResponse
    {
        $customer_id = $request->customer_id;
        $data = User::find($customer_id);

        return response()->json(['status' => 200, 'message' => 'success.', 'data' => $data]);
    }

    public function users_update(Request $request): \Illuminate\Http\JsonResponse
    {
        $customer_id = $request->customer_id;

        // Remove spaces from the phone field
        $phone = str_replace(' ', '', $request->phone);

        $rules = [
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($customer_id)],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', Rule::unique('users', 'phone')->ignore($customer_id)],
        ];

        $customMessages = [
            'phone.min' => 'The phone format is invalid.',
        ];

        // Update request with the sanitized phone number
        $request->merge(['phone' => $phone]);

        $this->validate($request, $rules, $customMessages);

        $data = User::find($customer_id);
        $data->name = $request->fullname;
        $data->email = $request->email;
        $data->phone = $phone;
        $data->save();

        $body = 'The customer ' . $data->customer_no . ' has been updated';
        //ADMIN LOG START
        $this->store_logs('admin', 'Customer Updated', $body);
        //ADMIN LOG END

        return response()->json(['status' => 200, 'message' => 'User details has been updated successfully.', 'data' => '']);
    }


    public function index(): \Illuminate\View\View
    {
        return view('admin.users.list');
    }

    public function ajax_list(Request $request)
    {

        $data = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('type', '=', 0);
        });

        if ($request->has('search_customer_no') && $request->filled('search_customer_no')) {
            $data->where('customer_no', 'like', '%' . $request->search_customer_no . '%');
        }

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
            ->addColumn('customer_no', function ($row) {
                $application_url = url('admin/users/loan-applications/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a href="' . $application_url . '" class="text-success"><strong>' . $row->customer_no . '</strong></a>';
                return $html;
            })
            ->addColumn('created_at', function ($row) {
                return display_date_format_time($row->created_at);
            })
            ->addColumn('order_by_val', function ($row) {
                return strtotime($row->created_at);
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<a href="javascript:;" title="Edit" data-id="' . $row->id . '" class="action-icon customer-edit"><i class="fa fa-edit text-success"></i></a>';

                $html .= '<a href="javascript:;" title="Delete" data-action="' . url('admin/users-delete') . '" data-id="' . $row->id . '" class="action-icon users-delete"><i class="mdi mdi-delete text-danger"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'customer_no', 'action'])
            ->make(true);
    }

    public function export_data(Request $request)
    {
        $t = time();

        $filename = "Customer-Export-" . $t;

        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM


        $data = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('type', '=', 0);
        });

        if ($request->has('search_customer_no') && $request->filled('search_customer_no')) {
            $data->where('customer_no', 'like', '%' . $request->search_customer_no . '%');
        }

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

        $columns = array('Customer No', 'Name', 'Phone', 'Email Address', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $customer_no = $row->customer_no;
                $name = $row->name;
                $phone = $row->phone;
                $email = $row->email;
                $created_at = display_date_format($row->created_at);

                fputcsv($file, array($customer_no, $name, $phone, $email, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    public function create(Request $request)
    {
        return view('admin.users.create');
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
        $user = User::where('phone', $phone)->first();

        if ($user != null) {
            // Return custom error message with status code 422
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'phone' => ['The entered phone number already exists.']
                ],
            ], 422);
        }

        $users = new User;
        $customer_no = $users->last_customer_no();

        $user = User::create([
            'name' => $request->fullname,
            'email' => $request->email_address,
            'customer_no' => $customer_no,
            'phone' => $phone,
            'password' => Hash::make($phone),
            'email_verified_at' => now(),
        ]);
        $role = 3;
        $user->roles()->attach($role);

        $body = 'The customer ' . $customer_no . ' has been added';
        //ADMIN LOG START
        $this->store_logs('admin', 'New Customer Added', $body);
        //ADMIN LOG END

        return response()->json(['status' => 200, 'message' => 'Your customer has been successfully added.']);
    }

    public function user_profile_update(Request $request)
    {
        $rules = [
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->user()->id],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'unique:users,phone,' . auth()->user()->id],
        ];

        $customMessages = [
            'phone.min' => 'The phone format is invalid.'
        ];

        $this->validate($request, $rules, $customMessages);
        $data = User::find(auth()->user()->id);
        $data->name = $request->fullname;
        $data->email = $request->email;

        /*if($request->filled('profile_picture')){

            $image = $request->profile_picture; 
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'user/'.str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if($status) { $data->avtar = $imageName; }

        }*/

        $data->save();


        return response()->json(['status' => 201, 'message' => 'Your profile has been sucessfully updated.']);
    }

    public function my_profile()
    {
        return view('user-my-profile');
    }

    public function myProfile()
    {
        return view('my-profile');
    }

    public function myProfileUpdate(Request $request)
    {
        /*$request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->user()->id],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'unique:users,phone,'.auth()->user()->id],
            //'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);*/

        $rules = [
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->user()->id],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'unique:users,phone,' . auth()->user()->id],
        ];

        $customMessages = [
            'phone.min' => 'The phone format is invalid.'
        ];
        $this->validate($request, $rules, $customMessages);


        $data = User::find(auth()->user()->id);
        $data->name = $request->fullname;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        //$data->about = $request->about;
        if ($request->filled('profile_picture')) {

            $image = $request->profile_picture;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'user/' . str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            /*$profile_picture = $request->file('profile_picture');
            $name = Storage::disk('public')->putfile('user', $profile_picture);*/
            if ($status) {
                $data->avtar = $imageName;
            }

        }
        $data->save();

        return response()->json(['status' => 201, 'message' => 'Your profile has been sucessfully updated.']);
    }

    public function myProfileChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8',
        ]);
        if (Hash::check($request->old_password, auth()->user()->password)) {
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json(['status' => 201, 'message' => 'Your password has been sucessfully updated.']);
        } else {
            return response()->json(['status' => 404, 'message' => 'Your old password not match our records.']);
        }
    }


    public function destroy($id)
    {
        $data = User::find($id);

        $body = 'The customer ' . $data->name . ' has been deleted';
        //ADMIN LOG START
        $this->store_logs('admin', 'Customer Deleted', $body);
        //ADMIN LOG END

        //$data->roles()->detach($data->roles()->first()->id);
        $data->delete();
        return back()->with('success', 'Record has been removed successfully.');
    }

    public function destroy_users(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);

        $body = 'The customer ' . $data->name . ' has been deleted';
        //ADMIN LOG START
        $this->store_logs('admin', 'Customer Deleted', $body);
        //ADMIN LOG END

        //$data->roles()->detach($data->roles()->first()->id);
        $data->delete();
        return back()->with('success', 'Record has been removed successfully.');
    }

    public function loanApplicants()
    {
        return view('admin.users.loan-applicants');
    }


}
