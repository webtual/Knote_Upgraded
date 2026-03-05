<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

use App\User;
use App\BusinessProposal;
use App\BusinessType;
use App\Favourite;

use Auth;

class BusinessProposalController extends Controller
{
    public function index(){
        $business_proposals = BusinessProposal::whereis_approved(1)->orderBy('id', 'desc')->limit(9)->get();
      
        $business_types = BusinessType::wheretype(1)->orderBy('id', 'desc')->get();
    	if(Gate::allows('isAdmin')){
    		return view('business_proposals.index', compact('business_proposals', 'business_types'));
    	}else{
    		return view('business-proposals', compact('business_proposals', 'business_types'));
    	}
    }

    public function myProposal(){
        $business_proposals = BusinessProposal::whereuser_id(auth()->user()->id)->orderBy('id', 'desc')->limit(9)->get();
        return view('business_proposals.my', compact('business_proposals'));
    }

    public function filter(Request $request){
        
        $query = BusinessProposal::orderBy('id', 'desc')->limit(9);
        
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
        if($request->my_proposal != ""){
            $query->whereuser_id(auth()->user()->id);
        }
        $result = $query->get();
        if($result->count() == 0){
            //return response()->json(['status' => 401, 'message' => 'Business proposal not found.']);
        }else{
            $data = "";
            foreach ($result as $key => $value) {
                if(Gate::allows('isAdmin')){
                    if($request->has('active_list')){
                        if($request->active_list == '#grid-view'){
                            $data .= '<div class="col-xl-4 ad-id" id="'.$value->id.'">';
                            $data .= view('partials.comman.block.business_proposal', ['bs' => $value]);
                            $data .= '</div>';
                        }else{
                            $data .= '<div class="col-xl-12 ad-id" id="'.$value->id.'">';
                            $data .= view('partials.comman.block.business_proposal_list', ['bs' => $value]);
                            $data .= '</div>';
                        }
                    }else{
                        $data .= '<div class="col-xl-4 ad-id" id="'.$value->id.'">';
                        $data .= view('partials.comman.block.business_proposal', ['bs' => $value]);
                        $data .= '</div>';
                    }
                }else{
                    $data .= '<div class="col-lg-4 col-xl-4" id="'.$value->id.'">';
                    $data .= '<div class="item box wow">';
                    $data .= view('partials.block.business_proposal', ['bs' => $value]);
                    $data .= '</div>';
                    $data .= '</div>';
                }
            }
            return response()->json(['status' => 201, 'data' => $data, 'count'=> $result->count()]);   
        }
    }

    
    public function create(){
        $business_types = BusinessType::wheretype(1)->get();
    	return view('business_proposals.create', compact('business_types'));
    }

    public function store(Request $request){
        
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'category' => 'required|array',
            'category.*' => 'required',
            'target' => 'required|regex:/^[0-9]+$/',
            'min_per_investor' => 'regex:/^[0-9]+$/',
            'business_logo_image' => 'required',
            'business_banner_image' => 'required'
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.',
            'category.required' => 'The category field is required.'
        ];
        $this->validate($request, $rules, $customMessages);
        
        $data = New BusinessProposal;
        $data->user_id = auth()->user()->id;
        $data->title = $request->title;
        $data->location = $request->location;
        $data->target = $request->target;
        $data->website = $request->website;
        $data->min_per_investor = $request->min_per_investor;
        $data->description = $request->description;

        if($request->filled('business_logo_image')){
            $image = $request->business_logo_image; 
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'business-proposal/'.str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if($status) { $data->logo_image = $imageName; }
        }

        if($request->filled('business_banner_image')){
            $image = $request->business_banner_image; 
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'business-proposal/'.str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if($status) { $data->banner_image = $imageName; }
        }
        $data->save();
        $data->business_types()->attach($request->category);
        
        return response()->json(['status' => 200, 'message' => 'Your business proposal has been successfully added.']);
    }

    public function favourites(){
        $business_proposals = auth()->user()->favourite_business_proposals()->limit(9)->orderBy('favourites.id', 'desc')->get();
        return view('business_proposals.favourites', compact('business_proposals'));
    }


    public function filterFavourite(Request $request){

        $query = auth()->user()->favourite_business_proposals()->limit(9)->orderBy('favourites.id', 'desc');
        
        if(Gate::allows('isUser')){
            $query->whereis_approved(1);
        }
        
        if($request->id != ""){
            $post = BusinessProposal::whereid($request->id)->whereis_approved(1)->first();
            $query->where('favourites.id', '<', $post->user_is_favourite->id);
        }

        $result = $query->get();
        if($result->count() == 0){
            //return response()->json(['status' => 401, 'message' => 'Business proposal not found.']);
        }else{
            $data = "";
            foreach ($result as $key => $value) {
                $data .= '<div class="col-xl-4 ad-id" id="'.$value->id.'" data-fvr-id="'.$value->user_is_favourite->id.'">';
                $data .= view('partials.comman.block.business_proposal', ['bs' => $value]);
                $data .= '</div>';   
            }
            return response()->json(['status' => 201, 'data' => $data, 'count'=> $result->count()]);   
        }

    }

    public function show($slug){
        $id = get_id_in_slug($slug);
        $result = BusinessProposal::find($id);
        $category = $result->business_types->pluck('id')->toArray();
        $similar_post =  BusinessProposal::where('id', '!=', $id)->whereHas('business_types', function($q) use ($category){
                $q->whereIn('business_type_id', $category);
        })->limit(6)->orderBy('id', 'DESC')->get();
        
        //$this->authorize('view', $result);
        if(Gate::allows('isAdmin')){
    		return view('business_proposals.show', compact('result', 'similar_post'));
    	}else{
    		return view('business-proposal-show', compact('result'));
    	}
    }

    public function edit($slug){
        $id = get_id_in_slug($slug);
        $result = BusinessProposal::whereid($id)->first();
        $this->authorize('update', $result);
        $business_types = BusinessType::wheretype(1)->get();
        return view('business_proposals.edit', compact('result', 'business_types'));
    }

    public function update($slug, Request $request){
        $id = get_id_in_slug($slug);
        $result = BusinessProposal::whereid($id)->first();
        $this->authorize('update', $result);

        $rules = [
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'category' => 'required|array',
            'category.*' => 'required',
            'target' => 'required|regex:/^[0-9]+$/',
            'min_per_investor' => 'regex:/^[0-9]+$/',
            'business_logo_image' => 'required',
            'business_banner_image' => 'required'
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.',
            'category.required' => 'The category field is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $data = BusinessProposal::find($id);
        $data->title = $request->title;
        $data->location = $request->location;
        $data->target = $request->target;
        $data->website = $request->website;
        $data->min_per_investor = $request->min_per_investor;
        $data->description = $request->description;

        if($request->business_logo_image != $result->logo_image){
            $image = $request->business_logo_image; 
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'business-proposal/'.str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if($status) { $data->logo_image = $imageName; }
        }

        if($request->business_banner_image != $result->banner_image){
            $image = $request->business_banner_image; 
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'business-proposal/'.str_random(40) . '.png';
            $status = Storage::disk('public')->put($imageName, base64_decode($image));
            if($status) { $data->banner_image = $imageName; }
        }

        $data->save();
        $data->business_types()->sync($request->category);

        return response()->json(['status' => 200, 'message' => 'Your business proposal has been update successfully.']);

    }

    public function destroy($id){
        $result = BusinessProposal::find($id);
        $this->authorize('delete', $result);
        $data = BusinessProposal::find($id);
        $data->business_types()->detach();
        $data->delete();
        return back()->with('success','Record has been removed successfully.');
    }

   


    /**
    Admin Methods
    ************/
    public function adminIndex(){
        $business_proposals = BusinessProposal::orderBy('id', 'desc')->limit(9)->get();
        $business_types = BusinessType::wheretype(1)->orderBy('id', 'desc')->get();
        return view('admin.business_proposals.index', compact('business_proposals', 'business_types'));
    }
    
    public function status($slug, $status){
        $id = get_id_in_slug($slug);
        $result = BusinessProposal::find($id);
        $result->is_approved = $status;
        $result->save();
        return response()->json(['status' => 200, 'message' => 'Your business proposal status has been successfully updated.']);
    }


}
