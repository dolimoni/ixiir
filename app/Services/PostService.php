<?php


namespace App\Services;

use App\Models\Post;
use App\Models\PostsDislike;
use App\Models\PostsVue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class PostService extends BaseService{


    function __construct()
    {

    }

    public function getDisliksCount($id){
        return count(PostsDislike::where('post_id',$id)->get());
    }

    public function alreadyDisliked($id){
        return count(PostsDislike::where('post_id',$id)->where('user_id', Auth::user()['id'])->get());
    }

    public function dislikePost($postId)
    {
        if($this->alreadyDisliked($postId)){
            PostsDislike::where('user_id',Auth::user()->id)->where('post_id',$postId)->delete();
        }else {
            $postsDislike=new PostsDislike();
            $postsDislike->user_id=Auth::user()->id;
            $postsDislike->post_id=$postId;
            $postsDislike->save();
        }
    }

    public function bestAuthors(){

        $authors = DB::table('posts_vue','pv')
            ->select('pv.*')
            ->select('users.*')
            ->select("users.*", "pv.*",
                DB::raw("COUNT(pv.id) as vues"),
                'v.'.$this->getCountryLangSelector().' as countryName',
                'p.'.$this->getCityLangSelector().' as cityName',
                'users.image as user_image',
                'users.id as usr_id',
                'posts.*')
            ->join('posts','posts.post_id','=','pv.post_id')
            ->join('users','users.id','=','posts.par')
            ->leftJoin('ville as v','users.ville','=','v.id')
            ->leftJoin('pays as p','users.pays','=','p.id')
            ->whereDate('pv.date_ajout', '>', Carbon::now()->subDays(30))
            ->where('users.best_author_last_win','<',Carbon::now()->subDays(21))
            ->groupBy('users.id')
            ->orderBy(DB::raw('COUNT(pv.id)'), 'desc')
            ->limit('100')
            ->get();

        return $authors;
    }

    public function bestPost(){
        try {
            $posts=Post::with('postsVue','postsJaime','postsComment')
                ->where('date_ajout','>=',Carbon::now()->addHour()->subDays(3))
                ->get();
            $posts->map(function($post){
                $post->postsVue=count($post->postsVue);
                $post->postsJaime=count($post->postsJaime);
                $post->postsComment=count($post->postsComment);
                $post['postsInter']=$post['postsVue']+($post['postsJaime']*2)+($post['postsComment']*3);
                return $post;
            });
            $posts=$posts->sortByDesc('postsInter')->first();

            if(isset($posts->winner)){
                return $posts;
            }else{
                die('fin');
            }
        }catch (Exception $e){
            var_dump($e->getMessage());
        }

    }

    public function setViews($posts,$user_id){
        $posts->each(function($post) use ($user_id){

            if($post['par']!=$user_id){
                Post::setViewPost($post['post_id'],$user_id);
            }

        });
    }

    public function setViewPost($post_id,$user_id){

        if(!isset($_COOKIE['pstlstsn_'.$post_id])){
            setcookie('pstlstsn_'.$post_id,$post_id,time()+300);
            $postsVue=new PostsVue();
            $postsVue->user_id=$user_id;
            $postsVue->post_id=$post_id;
            $postsVue->save();
        }

    }
}
