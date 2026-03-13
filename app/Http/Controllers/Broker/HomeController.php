<?php

namespace App\Http\Controllers\Broker;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

use App\Models\User;
use App\Models\Status;
use App\Models\Application;
use App\Models\Inquiry;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {

        $application_data = Application::whereNotIn('status_id', [8, 10, 11])->where('broker_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $data['application_status'] = Status::whereNotIn('id', [8, 10, 11])->orderBy('order_number', 'ASC')->get();
        $data['applications'] = $application_data;
        $data['application_count'] = $application_data->count();
        $data['application_declined_count'] = Application::whereIn('status_id', [8])->where('broker_id', auth()->user()->id)->orderBy('id', 'DESC')->get()->count();
        $data['application_archived_count'] = Application::whereIn('status_id', [10])->where('broker_id', auth()->user()->id)->orderBy('id', 'DESC')->get()->count();
        $data['application_setteled_count'] = Application::whereIn('status_id', [11])->where('broker_id', auth()->user()->id)->orderBy('id', 'DESC')->get()->count();

        return view('broker.dashboard', $data);
    }

    public function my_profile()
    {
        $data = array();
        return view('broker/user-my-profile', compact('data'));
    }

    public function user_profile_update(Request $request)
    {
        // Sanitize phone and email before validation
        $phone = str_replace(' ', '', $request->phone);
        $email = trim($request->email);
        $request->merge(['phone' => $phone, 'email' => $email]);

        $rules = [
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
        ];

        /*if (auth()->user()->roles[0]->slug != 'broker') {
            $rules['phone'][] = 'unique:users,phone,' . auth()->user()->id;
            $rules['email'][] = 'unique:users,email,' . auth()->user()->id;
        }*/

        $customMessages = [
            'phone.min' => 'The phone format is invalid.'
        ];

        $this->validate($request, $rules, $customMessages);
        $data = User::find(auth()->user()->id);
        $data->name = $request->fullname;
        $data->email = $request->email;
        $data->about = $request->about;
        $data->address = $request->address;

        if ($request->filled('profile_picture')) {

            $image = $request->profile_picture;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'user/' . str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if ($status) {
                $data->avtar = $imageName;
            }

        }

        $data->save();

        return response()->json(['status' => 201, 'message' => 'Your profile has been sucessfully updated.']);
    }

}
