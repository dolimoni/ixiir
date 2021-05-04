<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{


    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function delete($id,Request $request)
    {

        if(!$this->isAdmin()){
            return false;
        }
        Post::where('tag_id',$id)->delete();

        $tag = Tag::findOrFail($id);
        $tag->delete();

        return response()->json(array('status'=>"success"), 204);
    }

    function isAdmin(){

        $isAdmin = false;
        if(Auth::user()->id === 1822 || Auth::user()->id === 1){
            $isAdmin = true;
        }
        return $isAdmin;
    }
}
