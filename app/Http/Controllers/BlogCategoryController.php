<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\BlogCategory;

class BlogCategoryController extends Controller
{
   
   	public function index(){
        $blog_categories = BlogCategory::orderBy('id', 'DESC')->get();
        return view('admin.blog_category.index', compact('blog_categories'));
    }
  
 
    public function create(){
        return view('admin.blog_category.create');
    }


    public function store(Request $request){
        $rules = [
            'name' => 'required',
        ];
        $customMessages = [
            'required' => 'The :attribute field is required.',
        ];
        $this->validate($request, $rules, $customMessages);
        $data = New BlogCategory;
       	$data->name = $request->name;
        $data->slug = str_slug($request->name, '-');
        $data->save();
        return response()->json(['status' => 200, 'message' => 'Your blog categories has been successfully added.']);
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
        $data = BlogCategory::find($id);
       	$data->delete();
        return back()->with('success','Record has been removed successfully.');
    }
  
   
}
