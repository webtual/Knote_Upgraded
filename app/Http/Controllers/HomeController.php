<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\User;
use App\Status;
use App\Application;
use App\Inquiry;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard_application_export(Request $request)
    {
        $t = time();

        $filename = "Current-Loan-Application-Export-" . $t;

        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM

        $data = Application::whereNotIn('status_id', [8, 10, 11]);

        if ($request->has('search_status') && $request->filled('search_status')) {
            $search_status = Status::where('status', $request->search_status)->first();
            $data->where('status_id', $search_status->id);
        }
        $data = $data->orderBy('id', 'DESC')->get();

        $columns = array('Application.No', 'Apply For', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;
                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $apply_for_val = $apply_for[$row->apply_for];
                $created_at = display_date_format($row->created_at);

                $abn_or_acn = $row->abn_or_acn;
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                fputcsv($file, array($application_number, $apply_for_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    public function dashboard()
    {
        if (auth()->user()->roles->first()->type == 1) {
            $application_data = Application::whereNotIn('status_id', [8, 10, 11])->orderBy('id', 'DESC')->orderBy('id', 'DESC')->get();
            $data['application_status'] = Status::whereNotIn('id', [8, 10, 11])->orderBy('order_number', 'ASC')->get();
            $data['applications'] = $application_data;
            $data['application_count'] = $application_data->count();

            $data['application_declined_count'] = Application::whereIn('status_id', [8])->orderBy('id', 'DESC')->orderBy('id', 'DESC')->get()->count();
            $data['application_archived_count'] = Application::whereIn('status_id', [10])->orderBy('id', 'DESC')->orderBy('id', 'DESC')->get()->count();
            $data['application_setteled_count'] = Application::whereIn('status_id', [11])->orderBy('id', 'DESC')->orderBy('id', 'DESC')->get()->count();
            $data['inquiry_count'] = Inquiry::orderBy('id', 'DESC')->orderBy('id', 'DESC')->get()->count();

            $data['applicant_count'] = User::whereHas('roles', function (Builder $query) {
                $query->where('slug', '=', 'loan-applicant');
            })->get()->count();

            return view('admin.dashboard', $data);
        } else if (auth()->user()->roles->first()->slug == 'loan-applicant') {
            return view('applicant.dashboard');
        }
    }



    /**
     * Static Pages
     */
    public function policy()
    {
        return view('policy');
    }

}
