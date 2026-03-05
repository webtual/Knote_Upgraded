<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\BusinessType;

class BusinessTypeController extends Controller
{
   
   	public function index(){
        $business_types = BusinessType::orderBy('id', 'DESC')->get();
        return view('admin.business_types.index', compact('business_types'));
    }
  
 
    public function create(){
        return view('admin.blog_category.create');
    }

    


    public function store(Request $request){
        $rules = [
            'name' => 'required',
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $data = ($request->has('id')) ? BusinessType::find($request->id) : New BusinessType;
       	$data->business_type = $request->name;
        $data->slug = str_slug($request->name, '-');
        $data->type = $request->type;
        $data->save();
        
        return response()->json(['status' => 200, 'message' => 'Your categories has been '.($request->has('id')) ? 'updated' : 'added'.' successfully.']);
    }

    
    public function edit($slug){
        $id = get_id_in_slug($slug);
        $result = BlogCategory::whereid($id)->first();
        return view('admin.blog_category.edit', compact('result'));
    }

    public function update($slug, Request $request){
        $id = get_id_in_slug($slug);
        $result = BlogCategory::whereid($id)->first();
      
        $rules = [
            'name' => 'required',
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $data = BlogCategory::find($id);
      	$data->name = $request->name;
        $data->slug = str_slug($request->name, '-');
        $data->save();
        return response()->json(['status' => 200, 'message' => 'Your blog categories has been update successfully.']);
    }
    
    public function destroy($id){
        $data = BusinessType::find($id);
       	$data->delete();
        return back()->with('success','Record has been removed successfully.');
    }
  
   
}
