<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Application;
use App\Models\ApprovedDocuments;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Models\Setting;
use App\Traits\Loggable;

class ApprovedDocumentsController extends Controller
{
    use Loggable;
    
   	public function index(){
        return view('admin.approved_documents.index');
    }
    
    public function ajax_list(Request $request){
        
        $data = ApprovedDocuments::where('status', 1);
        
        if ($request->has('search_document_name') && $request->filled('search_document_name')) {
            $data->where('document_name', 'like', '%' . $request->search_document_name . '%');
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
        
        $data = $data->orderBy('updated_at', 'DESC')->get();
        
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('created_at', function($row){
            return display_date_format_time($row->created_at);
        })
        ->addColumn('updated_at', function($row){
            return display_date_format_time($row->updated_at);
        })
        ->addColumn('order_by_val', function($row){
            return strtotime($row->updated_at);
        })
        ->addColumn('status', function($row){
            return $row->status == 1 ? 'Active' : 'InActive';
        })
        ->addColumn('action', function($row){
            $html = '';
            $url_1 = url('admin/approveddocuments/edit/'.\Crypt::encrypt($row->id));
            $html .= '<a href="'.$url_1.'" title="Edit" class="action-icon"><i class="fa fa-edit text-success"></i></a>';
            if($row->document_file){
                $url_2 = asset('storage'.$row->document_file);
                $html .= '<a href="'.$url_2.'" title="Download" class="action-icon"><i class="fa fa-download text-success"></i></a>';
            }
            return $html;
	    })
        ->rawColumns(['order_by_val','action','status','updated_at','created_at'])
        ->make(true);
    }
    
    public function create(Request $request){
        return view('admin.approved_documents.create');
    }

    public function store(Request $request){
        
        //dd($request->all());
        
        $rules = [
            'document_name' => 'required',
            'document_file' => [
                'required',
                'file',
                function ($attribute, $value, $fail) {
                    if (request()->hasFile('document_file')) {
                        $file = request()->file('document_file');
                        $allowedMimeTypes = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']; // .doc & .docx
                        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                            $fail('The document file must be a file of type: doc, docx.');
                        }
                        if ($file->getSize() > 4048 * 1024) {
                            $fail('The document file size should not exceed 4MB.');
                        }
                    }
                }
            ],
        ];
        
        $customMessages = [
            'document_name.required' => 'The document name field is required.',
            'document_file.required' => 'The document file field is required.',
            'document_file.file' => 'The uploaded document must be a valid file.',
            'document_file.mimes' => 'The document file must be a file of type: .doc, .docx.',
            'document_file.max' => 'The document file size should not exceed 4MB.',
        ];
    
        $validator = \Validator::make($request->all(), $rules, $customMessages);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $data = new ApprovedDocuments;
       	$data->document_name = $request->document_name;
       	
       	// Get the highest document_number and increment it
        $last_sort_by = ApprovedDocuments::orderBy('sort_by', 'desc')->first();
        $data->sort_by = $last_sort_by ? $last_sort_by->sort_by + 1 : 1;
        
        if ($request->hasFile('document_file')) {
            $originalName = $request->document_file->getClientOriginalName();
            
            // Convert spaces to underscores and remove special characters except underscore
            $document_file = preg_replace('/[^A-Za-z0-9_]/', '', str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME)));
        
            // Append the original extension
            $extension = $request->document_file->getClientOriginalExtension();
            $document_file = $document_file . '.' . $extension;
        
            // Store the file
            $request->document_file->storeAs('public/document_file', $document_file);
            $data->document_file = '/document_file/' . $document_file;
        }

        $data->created_at = now();
        $data->updated_at = now();
       	$data->status = 1;
       	$data->save();
        
        return response()->json(['status' => 200, 'message' => 'Your conditionally approved documents has been successfully added.']);
    }
   
    public function edit(Request $request, $enc_id){
        $id = Crypt::decrypt($enc_id);
        $result = ApprovedDocuments::find($id);
        return view('admin.approved_documents.edit', compact('result'));
    }
    
    public function update(Request $request){
        $rules = [
            'document_name' => 'required',
            'document_file' => [
                'nullable',
                'file',
                function ($attribute, $value, $fail) {
                    if (request()->hasFile('document_file')) {
                        $file = request()->file('document_file');
                        $allowedMimeTypes = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']; // .doc & .docx
                        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                            $fail('The document file must be a file of type: doc, docx.');
                        }
                        if ($file->getSize() > 4048 * 1024) {
                            $fail('The document file size should not exceed 4MB.');
                        }
                    }
                }
            ],
        ];
        
        $customMessages = [
            'document_name.required' => 'The document name field is required.',
            'document_file.required' => 'The document file field is required.',
            'document_file.file' => 'The uploaded document must be a valid file.',
            'document_file.mimes' => 'The document file must be a file of type: .doc, .docx.',
            'document_file.max' => 'The document file size should not exceed 4MB.',
        ];
    
        $validator = \Validator::make($request->all(), $rules, $customMessages);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $data = ApprovedDocuments::find($request->document_id);
       	$data->document_name = $request->document_name;
       	$data->updated_at = now();
       	if ($request->hasFile('document_file')) {
            $originalName = $request->document_file->getClientOriginalName();
            
            // Convert spaces to underscores and remove special characters except underscore
            $document_file = preg_replace('/[^A-Za-z0-9_]/', '', str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME)));
        
            // Append the original extension
            $extension = $request->document_file->getClientOriginalExtension();
            $document_file = $document_file . '.' . $extension;
        
            // Store the file
            $request->document_file->storeAs('public/document_file', $document_file);
            $data->document_file = '/document_file/' . $document_file;
        }
       	$data->save();
        
        return response()->json(['status' => 200, 'message' => 'Your conditionally approved documents has been successfully updated.']);
    }
   
}
