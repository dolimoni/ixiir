<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pays;
use App\Models\Metier;
use App\Models\MetierSpecialite;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;

class SignInController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(Request $request){
        
        $pays=Pays::get();
        $villes=Pays::with('villes')->find(1)->villes;
        $metiers=Metier::get();
        $specialites=MetierSpecialite::get();
        $posts=Post::showPosts(true);
        $posts_odd=$posts['posts_odd'];
        $posts_even=$posts['posts_even'];
        $postsTopFive_odd=$posts['postsTopFive_odd'];
        $postsTopFive_even=$posts['postsTopFive_even'];
        $params = array(
            'showComments' => false
        );
        $topTopics=DB::table('tags')->select('tags.tag',DB::raw('count(posts.post_id)+count(posts_comment.post_id) as word'))->where('tags.created_at','>=',Carbon::now()->subDays(10))->join('posts','tags.id','=','posts.tag_id')->leftJoin('posts_comment','posts.post_id','=','posts_comment.post_id')->groupBy('tags.tag')->get()->sortByDesc('word')->take(5);
        return view('sign-in',compact('topTopics','pays','villes','metiers','specialites','posts_odd','posts_even','postsTopFive_odd','postsTopFive_even','params'));
    }
    
    public function forgetPass(){
        return view('Auth.passwords.email');
    }
}
