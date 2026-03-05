<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\BusinessProposal;
use App\Resource;
use App\Favourite;


class FavouriteController extends Controller
{
   
    public function store(Request $request){
        if($request->type == 'business-proposal'){
            $post = BusinessProposal::find($request->id);
        }else{
            $post = Resource::find($request->id);
        }
        if($post->user_is_favourite == null){
            $fvr = new Favourite;
            $fvr->user_id = auth()->user()->id;
            $post->favourites()->save($fvr);
            $message = 'Successfully added in favorites.';
        }else{
            $fvr = new Favourite;
            $post->favourites()->where('id', '=', $post->user_is_favourite->id)->delete();
            $message = 'Your favourite has been successfully removed.';
        }
        return response()->json(['status' => 201, 'message' => $message, 'data' => '']);
    }

  
}
