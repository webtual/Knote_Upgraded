<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserLogs;
use Image;
use Hash;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class UserLogsController extends Controller
{

    public function user_log_export(Request $request){
        $t = time();

        $filename = "Activity-Logs-Export-" . $t;

        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        
        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM
        
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        $data = UserLogs::select('*')->with('user')->where('created_at', '>=', $sixMonthsAgo);
        
        if($request->has('search_user_id') && $request->filled('search_user_id')){
            $data->where('user_id',$request->search_user_id);
        }
        
        if ($request->has('search_body') && $request->filled('search_body')) {
            $data->where('body', 'like', '%' . $request->search_body . '%');
        }

        if ($request->has('search_title') && $request->filled('search_title')) {
            $data->where('title', $request->search_title);
        }
        
        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }
        
        $data = $data->orderBy('id', 'DESC')->get();

        $columns = array('Name', 'Phone', 'Title', 'Description', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;
            
            fputcsv($file, $columns);
            
            foreach ($data as $row) {
                $name = $row->user->name;
                $phone_no = $row->user->phone;
                $title = $row->title;
                $body = $row->body;
                $created_at = display_date_format_time($row->created_at);

                fputcsv($file, array($name, $phone_no, $title, $body, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }
    
	/**
    Admin Route Methods
    ******************/
    public function _index(){
        $user_logs = UserLogs::with('user')->orderBy('id', 'DESC')->get();
        
        $users = User::whereHas('roles', function($q){
            $q->where('type', '=', 1);
        })->orderBy('id', 'DESC')->get();
        
        $page_titles = UserLogs::select('title')->distinct()->orderBy('title')->pluck('title');
        
        return view('admin.users.logs', compact('user_logs','users','page_titles'));
    }
    
    
    
    public function indexAjax(Request $request){
            
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        $data = UserLogs::select('*')->with('user')->where('created_at', '>=', $sixMonthsAgo);
        
        if($request->has('search_user_id') && $request->filled('search_user_id')){
            $data->where('user_id',$request->search_user_id);
        }
        
        if ($request->has('search_body') && $request->filled('search_body')) {
            $data->where('body', 'like', '%' . $request->search_body . '%');
        }

        if ($request->has('search_title') && $request->filled('search_title')) {
            $data->where('title', $request->search_title);
        }
        
        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }
        
        $data = $data->orderBy('id', 'DESC')->get();
        
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = "";
	        
	    })
	    ->addColumn('user_name', function($row){
               return $row->user->name;
        })
        ->addColumn('created_at', function($row){
               return display_date_format_time($row->created_at);
        })
        ->addColumn('order_by_val', function($row){
            return strtotime($row->created_at);
        })
        ->rawColumns(['order_by_val','action','user_name'])
        ->make(true);
        
    }
    
    public function index(Request $request){
        
        $page_title = 'Activity Logs';
        
        $users = User::whereHas('roles', function($q){
            $q->where('type', '=', 1);
        })->orderBy('id', 'DESC')->get();
        
        $page_titles = UserLogs::select('title')->distinct()->orderBy('title')->pluck('title');
        
        return view('admin.users.logs', compact('page_title','users','page_titles'));
    }

    public function destroy($id){
        $data = UserLogs::find($id);
        $data->delete();
        return back()->with('success','Record has been removed successfully.');
    }
  
}
