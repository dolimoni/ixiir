<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;
use App\Models\PostsJaime;
use App\Models\PostsVue;
use App\Models\PostsComment;
use App\Models\Pays;
use App\Models\Metier;
use App\Models\MetierSpecialite;
use App\Models\User;
use App\Models\Message;
use App\Models\UserAbonne;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use DB;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $pays=Pays::get();
        $villes=Pays::with('villes')->find(1)->villes;
        $metiers=Metier::get();

        $specialites=MetierSpecialite::get();


        $user=User::with('country','city','metierSpecialite')->find(Auth::user()->id);
        $posts=Post::showPosts(false,$request->user()->id);
        $topics=Tag::where('created_at','>=',Carbon::now()->subDays(10))->get();
        $params = array(
            'showComments' => false,
            'isHotTopic' => false
        );


        $posts_odd=$posts['posts_odd'];
        $posts_even=$posts['posts_even'];
        $postsInteractive_odd=$posts['postsInteractive_odd'];
        $postsInteractive_even=$posts['postsInteractive_even'];
        $postsTopFive_odd=$posts['postsTopFive_odd'];
        $postsTopFive_even=$posts['postsTopFive_even'];
        Post::updatePosition();
        $topTopics=DB::table('tags')->select('tags.tag',DB::raw('count(posts.post_id)+count(posts_comment.post_id) as word'))->where('tags.created_at','>=',Carbon::now()->subDays(10))->join('posts','tags.id','=','posts.tag_id')->leftJoin('posts_comment','posts.post_id','=','posts_comment.post_id')->groupBy('tags.tag')->get()->sortByDesc('word')->take(5);
        return view('index',compact('user','topTopics','topics','pays','villes','metiers','specialites','posts_odd','posts_even','postsTopFive_odd','postsTopFive_even','postsInteractive_odd','postsInteractive_even','params'));
    }


    public function templatePost($id){
        $post=Post::find($id);
        if(!empty($post)){
            $post['userDetails']=$post->userDetails($post->par);
            return view('templatePostShared',['post'=>$post]);
        }

    }

    public function show($id){
        $pays=Pays::get();
        $villes=Pays::with('villes')->find(1)->villes;
        $metiers=Metier::get();
        $specialites=MetierSpecialite::get();
        $post=Post::find($id);
        if(!empty($post)){
            $post['userDetails']=$post->userDetails($post->par);
            return view('templatePostShared',compact('pays','villes','metiers','specialites','post'));
        }

    }


    public function updatePost(Request $request){
        $postId = $request->txt_updpost_id;
        $post=Post::find($postId);
        if(is_null($post)){
            return false;
        }
        $post->detail=$request->detail;
        $post->youtube=$request->txt_youtube;
        if(!empty($request->image)){
            $filename = "ixiir-post-".$request->user()->id."-".time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('upload/posts', $filename);
            $post->image='/upload/posts/'.$filename;
        }

        if(!empty($request->txt_hashModal)){
            $tag=Tag::where('id',$request->txt_hashModal)->first();
            if(empty($tag)){
                $tag=new Tag();
                $tag->tag=$request->txt_hashModal;
                $tag->created_at=Carbon::now();
                $tag->save();
            }
            $post->tag_id=$tag->id;
        }else if(!empty($request->txt_hash_selectModal)){
            $post->tag_id=$request->txt_hash_selectModal;
        }
        $post->save();
        return redirect('/');
    }


}
