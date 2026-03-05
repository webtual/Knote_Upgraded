<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\TokenIdentifiers;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Setting;
use App\Traits\Loggable;

class TokenIdentifiersController extends Controller
{
    use Loggable;
    
   	public function index(){
        return view('admin.tokenidentifiers.index');
    }
    
    public function tokenidentifiers_export(Request $request){
        $t = time();

        $filename = "Token-Identifiers-Export-" . $t;

        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        
        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM
        
        $data = TokenIdentifiers::where('status', 1);
        
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

        $columns = array('Token Key','Token Identifiers', 'Token Description', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;
            
            fputcsv($file, $columns);

            foreach ($data as $row) {
                $title = $row->title;
                $token_identifiers = "\${{$row->title}}";
                $description = $row->description;
                $created_at = display_date_format($row->created_at);

                fputcsv($file, array($title, $token_identifiers, $description, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }
    
    public function ajax_list(Request $request){
        
        $data = TokenIdentifiers::where('status', 1);
        
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
        ->addColumn('token_identifiers', function($row){
           return "\${{$row->title}}";
        })
        ->addColumn('order_by_val', function($row){
            return strtotime($row->created_at);
        })
        ->addColumn('status', function($row){
            return $row->status == 1 ? 'Active' : 'InActive';
        })
        ->addColumn('action', function($row){
            $html = '';
            $url_1 = url('admin/tokenidentifiers/edit/'.\Crypt::encrypt($row->id));
            $html .= '<a href="'.$url_1.'" title="Edit" class="action-icon"><i class="fa fa-edit text-success"></i></a>';
            return $html;
	    })
        ->rawColumns(['order_by_val','action','status','token_identifiers'])
        ->make(true);
    }
    
    public function create(Request $request){
        return view('admin.tokenidentifiers.create');
    }

    public function store(Request $request){
        $rules = [
            'title' => [
                'required',
                'unique:token_identifiers,title',
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'description' => 'required',
        ];
    
        $customMessages = [
            'title.required' => 'The token key field is required.',
            'title.unique' => 'The token key must be unique.',
            'title.regex' => 'The token key must only contain letters, numbers, and underscores (_). Spaces are not allowed.',
            'description.required' => 'The token description field is required.',
        ];
    
        $validator = \Validator::make($request->all(), $rules, $customMessages);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        $data = new TokenIdentifiers();
        $data->title = $request->title;
        $data->description = $request->description;
        $data->status = 1;
        $data->save();
    
        return response()->json(['status' => 200, 'message' => 'Your token identifier has been successfully added.']);
    }

   
    public function edit(Request $request, $enc_id){
        $id = Crypt::decrypt($enc_id);
        $result = TokenIdentifiers::find($id);
        return view('admin.tokenidentifiers.edit', compact('result'));
    }
    
    public function update(Request $request){
        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];
    
        $customMessages = [
            'title.required' => 'The token key field is required.',
            'description.required' => 'The token description field is required.',
        ];
    
        $validator = \Validator::make($request->all(), $rules, $customMessages);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $data = TokenIdentifiers::find($request->id);
       	$data->title = $request->title;
       	$data->description = $request->description;
       	$data->save();
        
        return response()->json(['status' => 200, 'message' => 'Your token identifiers has been successfully updated.']);
    }
   
}
