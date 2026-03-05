<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

use App\User;
use App\Blog;
use App\BlogCategory;
use App\BlogBlogCategory;

use Auth;

class BlogController extends Controller
{
   
    public function index(){
        $blogs = Blog::limit(9)->orderBy('id', 'DESC')->get();
        $blog_categories = BlogCategory::get();
        return view('blogs', compact('blogs', 'blog_categories'));
    }
  
    public function show($slug){
        $id = get_id_in_slug($slug);
        $result = Blog::find($id);
        $blogs = Blog::limit(6)->orderBy('id', 'DESC')->get();

        $blog_categories = BlogBlogCategory::select('blog_category_id')->whereblog_id($result->id)->pluck('blog_category_id')->toArray();
        $similar_blogs =  Blog::where('id', '!=', $result->id)->whereIn('id', $blog_categories)->limit(8)->orderBy('id', 'DESC')->get();
        return view('blog-show', compact('result', 'blogs', 'similar_blogs'));
    }
    
    public function filter(Request $request){
        $query = Blog::orderBy('id', 'desc')->limit(9);
        
        if($request->id != ""){
            $query->where('id', '<', $request->id);
        }
        
        if($request->categories != ""){
            $categories = $request->categories;
            $query->whereHas('category', function($q) use ($categories){
                $q->whereIn('blog_category_id', array($categories));
            });
        }

        $result = $query->get();
        if($result->count() == 0){
            //return response()->json(['status' => 401, 'message' => 'Blog not found.']);
        }else{
            $data = "";
            foreach ($result as $key => $value) {
                if(Auth::check()){
                    if(Gate::allows('isAdminUser')){
                        if ($request->is('admin/*')) {
                            $data .= '<div class="col-lg-6 col-xl-3 blog-row" id='.$value->id.'>';
                            $data .= view('partials.comman.block.blog', ['blog' => $value]);
                            $data .= '</div>';
                        }else{
                            $data .= view('partials.block.blog', ['blog' => $value]);
                        }
                    }else{
                        $data .= view('partials.block.blog', ['blog' => $value]);
                    }
                }else{
                    $data .= view('partials.block.blog', ['blog' => $value]);
                }
            }
            return response()->json(['status' => 201, 'data' => $data, 'count'=> $result->count()]);   
        }
    }

    /**
    Admin Method
    ***********/
    public function adminIndex(){
        $blogs = Blog::limit(12)->orderBy('id', 'desc')->get();
        return view('admin.blog.index', compact('blogs'));
    }

    public function create(){
        $blog_categories = BlogCategory::get();
        return view('admin.blog.create', compact('blog_categories'));
    }

    public function store(Request $request){
        
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'category' => 'required|array',
            'category.*' => 'required',
            'image' => 'required',
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.',
            'category.required' => 'The category field is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $data = New Blog;
        $data->user_id = auth()->user()->id;
        $data->title = $request->title;
        $data->description = $request->description;
        
        if($request->filled('image')){
            $image = $request->image; 
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'blog/'.str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if($status) { $data->main_image = $imageName; }
        }
        $data->save();
        $data->category()->attach($request->category);

        return response()->json(['status' => 200, 'message' => 'Your blog has been successfully added.']);

    }

    public function edit($slug){
        $id = get_id_in_slug($slug);
        $result = Blog::whereid($id)->first();
        $blog_categories = BlogCategory::get();
        return view('admin.blog.edit', compact('result', 'blog_categories'));
    }

    public function update($slug, Request $request){
        $id = get_id_in_slug($slug);
        $result = Blog::whereid($id)->first();
      
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'category' => 'required|array',
            'category.*' => 'required',
            'image' => 'required',
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.',
            'category.required' => 'The category field is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $data = Blog::find($id);
        $data->user_id = auth()->user()->id;
        $data->title = $request->title;
        $data->description = $request->description;

        if($request->image != $result->main_image){
            $image = $request->image; 
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'blog/'.str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if($status) { $data->main_image = $imageName; }
        }

        $data->save();
        $data->category()->sync($request->category);

        return response()->json(['status' => 200, 'message' => 'Your blog has been update successfully.']);

    }
    
    public function destroy($id){
        $data = Blog::find($id);
        $data->category()->detach();
        $data->delete();
        return back()->with('success','Record has been removed successfully.');
    }

}
