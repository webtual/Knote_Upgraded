<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

use App\User;
use App\Resource;
use App\BusinessType;
use App\BusinessTypeResource;

use Auth;
use Carbon\Carbon;

class ResourceController extends Controller
{
   
    public function index(){
        $resources = Resource::whereis_approved(1)->orderBy('id', 'desc')->limit(9)->get();
        $business_types = BusinessType::wheretype(2)->get();
    	if(Gate::allows('isAdmin')){
    		return view('resources.index', compact('business_types', 'resources'));
    	}else{
    		return view('resources', compact('business_types', 'resources'));
    	}
    }

    public function create(){
        $business_types = BusinessType::wheretype(2)->get();
    	return view('resources.create', compact('business_types'));
    }

    public function store(Request $request){
        
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'category' => 'required|array',
            'category.*' => 'required',
            'resource_image' => 'required',
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.',
            'category.required' => 'The category field is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $data = New Resource;
        $data->user_id = auth()->user()->id;
        $data->title = $request->title;
        $data->amount = $request->amount;
        $data->description = $request->description;
        $data->location = $request->location;
        if($request->filled('resource_image')){
            $image = $request->resource_image; 
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'resource/'.str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if($status) { $data->banner_image = $imageName; }
        }
        $data->save();
        $data->business_types()->attach($request->category);

        return response()->json(['status' => 200, 'message' => 'Your resource has been successfully added.']);

    }

    public function favourites(){
        $resources = auth()->user()->favourite_resources()->limit(9)->orderBy('favourites.id', 'desc')->get();
    	return view('resources.favourites', compact('resources'));
    }

    public function filterFavourite(Request $request){

        $query = auth()->user()->favourite_resources()->limit(9)->orderBy('favourites.id', 'desc');
        
        if(Gate::allows('isUser')){
            $query->whereis_approved(1);
        }
        
        if($request->id != ""){
            $post = Resource::whereid($request->id)->whereis_approved(1)->first();
            $query->where('favourites.id', '<', $post->user_is_favourite->id);
        }

        $result = $query->get();
        if($result->count() == 0){
            //return response()->json(['status' => 401, 'message' => 'Resources not found.']);
        }else{
            $data = "";
            foreach ($result as $key => $value) {
                $data .= '<div class="col-xl-4 ad-id" id="'.$value->id.'" data-fvr-id="'.$value->user_is_favourite->id.'">';
                $data .= view('partials.comman.block.resource', ['resource' => $value]);
                $data .= '</div>';   
            }
            return response()->json(['status' => 201, 'data' => $data, 'count'=> $result->count()]);   
        }

    }




   	public function show($slug){
        $id = get_id_in_slug($slug);
        $result = Resource::find($id);
        //$this->authorize('view', $result);

        $businss_types = BusinessTypeResource::select('business_type_id')->whereresource_id($result->id)->pluck('business_type_id')->toArray();
        $similar_post =  Resource::where('id', '!=', $id)->where('user_id', '=', $result->user_id)->limit(6)->orderBy('id', 'DESC')->get();

        $recent_post = Resource::limit(6)->orderBy('id', 'DESC')->get();

        if(Gate::allows('isAdmin')){
    		return view('resources.show', compact('result', 'similar_post', 'recent_post'));
    	}else{
    		return view('resources-show', compact('result', 'similar_post', 'recent_post'));
    	}
    }

    public function myResource(){
        $resources = Resource::whereuser_id(auth()->user()->id)->orderBy('id', 'desc')->limit(9)->get();
        return view('resources.my', compact('resources'));
    }

    public function filter(Request $request){
        $query = Resource::orderBy('id', 'desc')->limit(9);
        
        if(Gate::allows('isUser')){
            $query->whereis_approved(1);
        }
        if($request->category != ""){
            $category = $request->category;
            $query->whereHas('business_types', function($q) use ($category){
                $q->where('business_type_id', '=', $category);
            });
        }
        if($request->keyword != ""){
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');   
        }
        if($request->id != ""){
            $query->where('id', '<', $request->id);
        }
        if($request->my_resource != ""){
            $query->whereuser_id(auth()->user()->id);
        }
        $result = $query->get();
        if($result->count() == 0){
            //return response()->json(['status' => 401, 'message' => 'Resources not found.']);
        }else{
            $data = "";
            foreach ($result as $key => $value) {
                if(Gate::allows('isAdmin')){
                    if($request->has('active_list')){
                        if($request->active_list == '#grid-view'){
                            $data .= '<div class="col-xl-4 ad-id" id="'.$value->id.'">';
                            $data .= view('partials.comman.block.resource', ['resource' => $value]);
                            $data .= '</div>';
                        }else{
                            $data .= '<div class="col-xl-12 ad-id" id="'.$value->id.'">';
                            $data .= view('partials.comman.block.resource_list', ['resource' => $value]);
                            $data .= '</div>';
                        }
                    }else{
                        $data .= '<div class="col-xl-4 ad-id" id="'.$value->id.'">';
                        $data .= view('partials.comman.block.resource', ['resource' => $value]);
                        $data .= '</div>';
                    }
                }else{
                    $data .= '<div class="col-lg-4 col-xl-4" id="'.$value->id.'">';
                    $data .= '<div class="item box wow">';
                    $data .= view('partials.block.resource', ['resource' => $value]);
                    $data .= '</div>';
                    $data .= '</div>';
                }
            }
            return response()->json(['status' => 201, 'data' => $data, 'message' => '', 'count'=> $result->count()]);   
        }
    }

    public function edit($slug){
        $id = get_id_in_slug($slug);
        $result = Resource::whereid($id)->first();
        $this->authorize('update', $result);
        $business_types = BusinessType::wheretype(2)->get();
        return view('resources.edit', compact('result', 'business_types'));
    }

    public function update($slug, Request $request){
        $id = get_id_in_slug($slug);
        $result = Resource::whereid($id)->first();
        $this->authorize('update', $result);

        $rules = [
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'category' => 'required|array',
            'category.*' => 'required',
            'resource_image' => 'required',
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.',
            'category.required' => 'The category field is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $data = Resource::find($id);
        $data->title = $request->title;
        $data->amount = $request->amount;
        $data->description = $request->description;
        $data->location = $request->location;
        if($request->resource_image != $result->banner_image){
            $image = $request->resource_image; 
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'resource/'.str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if($status) { $data->banner_image = $imageName; }
        }
        $data->save();
        $data->business_types()->sync($request->category);

        return response()->json(['status' => 200, 'message' => 'Your resources has been update successfully.']);
    }


     public function destroy($id){
        $result = Resource::find($id);
        $this->authorize('delete', $result);
        $data = Resource::find($id);
        $data->business_types()->detach();
        $data->delete();
        return back()->with('success','Record has been removed successfully.');
    }


    /**
    Admin Methods
    ************/
    public function adminIndex(){
        $resources = Resource::orderBy('id', 'desc')->limit(9)->get();
        $business_types = BusinessType::wheretype(2)->orderBy('id', 'desc')->get();
        return view('admin.resources.index', compact('business_types', 'resources'));
    }

    public function status($slug, $status){
        $id = get_id_in_slug($slug);
        $result = Resource::find($id);
        $result->is_approved = $status;
        $result->save();
        return response()->json(['status' => 200, 'message' => 'Your resource status has been successfully updated.']);
    }
  
}
