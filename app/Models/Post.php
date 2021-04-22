<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\PostsComment;
use App\Models\PostsJaime;
use App\Models\PostsVue;

class Post extends Model
{
    protected $fillable=['detail','image','par','pour','date_ajout','youtube','position','pred_position','pred_debut_position','pred_fin_position','debut_position','fin_position','trophy'];
    public $timestamps=false;
    protected $primaryKey='post_id';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function postsComment(){
        return $this->hasMany('App\Models\PostsComment','post_id')->with('user');
    }

    public function postsJaime(){
        return $this->hasMany('App\Models\PostsJaime','post_id');
    }

    public function postsVue(){
        return $this->hasMany('App\Models\PostsVue','post_id');
    }

    public function tag(){
        return $this->belongsTo('App\Models\Tag','tag_id');
    }

    public function userDetails($user_id){
        $user=User::with('country','city')->find($user_id);
        return $user;
    }

    public static function setTrophy($post){
        $trophy=0;
        $time = Carbon::createFromFormat('Y-m-d H:i:s',$post['debut_position']);
        $current=Carbon::now();
        $hours = $time->diffInHours($current);
        if(is_null($post['fin_position']) && $hours>=12 && (is_null($post['trophy']) || $post['trophy']>$post['position'])){
            Post::where('post_id',$post['post_id'])->update(['trophy'=>$post['position']]);
            $trophy=1;
        }else if($post['pred_position']>$post['position']) {
            $time = Carbon::createFromFormat('Y-m-d H:i:s',$post['pred_debut_position']);
            $hours = $time->diffInhours($current);
            $hoursFin=!empty($post['fin_position'])?$time->diffInHours(Carbon::createFromFormat('Y-m-d H:i:s',$post['fin_position'])):0;

            if((is_null($post['fin_position']) || $hoursFin>=12) && ($hours>=12 || $hoursFin>=12) && (is_null($post['trophy']) || $post['trophy']>$post['pred_position'])){
                Post::where('post_id',$post['post_id'])->update(['trophy'=>$post['pred_position']]);
                $trophy=1;
            }
        }
        return $trophy;
    }

    public static function updatePosition() {
        $posts=Post::with('postsVue','postsJaime','postsComment')
            ->where('date_ajout','>=',Carbon::now()->subDays(3))
            ->get();
        $posts->map(function($post){
            $post->postsVue=count($post->postsVue);
            $post->postsJaime=count($post->postsJaime);
            $post->postsComment=count($post->postsComment);
            $post['postsInter']=$post['postsVue']+($post['postsJaime']*2)+($post['postsComment']*3);
            return $post;
        });
        $posts=$posts->sortByDesc('postsInter')->take(5);
        $postsAutres=Post::whereNotNull('position')->whereNotIn('post_id',$posts->pluck('post_id'))->update(['fin_position'=>Carbon::now()]);
        $trophy=0;
        if(!empty($posts[0]['position']) && $posts[0]['position']==1){
            $trophy=self::setTrophy($posts[0]);
        }else if(!empty($posts[0]['post_id'])){
            Post::where('post_id',$posts[0]['post_id'])->update(['position'=>1,'debut_position'=>Carbon::now(),'fin_position'=>null,'pred_position'=>$posts[0]['position'],'pred_debut_position'=>$posts[0]['debut_position'],'pred_fin_position'=>$posts[0]['fin_position']]);
        }

        if(!empty($posts[1]['position']) && $posts[1]['position']==2){
            $t=self::setTrophy($posts[1]);
            if($trophy==0){
                $trophy=$t;
            }
        }else if(!empty($posts[1]['post_id'])){
            Post::where('post_id',$posts[1]['post_id'])->update(['position'=>2,'debut_position'=>Carbon::now(),'fin_position'=>null,'pred_position'=>$posts[1]['position'],'pred_debut_position'=>$posts[1]['debut_position'],'pred_fin_position'=>$posts[1]['fin_position']]);
        }
        if(!empty($posts[2]['position']) && $posts[2]['position']==3){
            $t=self::setTrophy($posts[2]);
            if($trophy==0){
                $trophy=$t;
            }
        }else if(!empty($posts[2]['post_id'])){
            Post::where('post_id',$posts[2]['post_id'])->update(['position'=>3,'debut_position'=>Carbon::now(),'fin_position'=>null,'pred_position'=>$posts[2]['position'],'pred_debut_position'=>$posts[2]['debut_position'],'pred_fin_position'=>$posts[2]['fin_position']]);
        }
        if(!empty($posts[3]['position']) && $posts[3]['position']==4){
            $t=self::setTrophy($posts[3]);
            if($trophy==0){
                $trophy=$t;
            }
        }else if(!empty($posts[3]['post_id'])) {
            Post::where('post_id',$posts[3]['post_id'])->update(['position'=>4,'debut_position'=>Carbon::now(),'fin_position'=>null,'pred_position'=>$posts[3]['position'],'pred_debut_position'=>$posts[3]['debut_position'],'pred_fin_position'=>$posts[3]['fin_position']]);
        }
        if(!empty($posts[4]['position']) && $posts[4]['position']==5){
            $t=self::setTrophy($posts[4]);
            if($trophy==0){
                $trophy=$t;
            }
        }else if(!empty($posts[4]['post_id'])) {
            Post::where('post_id',$posts[4]['post_id'])->update(['position'=>5,'debut_position'=>Carbon::now(),'fin_position'=>null,'pred_position'=>$posts[4]['position'],'pred_debut_position'=>$posts[4]['debut_position'],'pred_fin_position'=>$posts[4]['fin_position']]);
        }
        return $trophy;
    }

    public static function countPostVues($post_id){
        $postVues=count(PostsVue::where('post_id',$post_id)->get());
        return $postVues;
    }

    public static function countPostJaime($post_id){
        $postsJaime=count(PostsJaime::where('post_id',$post_id)->get());
        return $postsJaime;
    }

    public static function postComment($post_id){
        $postsComment=PostsComment::where('post_id',$post_id)->get();
        return $postsComment;
    }

    public static function countPostComment($post_id){
        $postsComment=count(self::postComment($post_id));
        return $postsComment;
    }

    public static function postsJaimeUser($post_id,$user_id){
        return count(self::with('postsJaime')->find($post_id)->postsJaime->where('user_id', $user_id));
    }

    public static function postsVueUser($post_id,$user_id){
        return count(self::with('postsVue')->find($post_id)->postsVue->where('user_id', $user_id));
    }

    public static function searchPosts($searchWord){
        $posts=self::with('tag','postsComment','postsJaime')
            ->where('detail','like','%'.$searchWord.'%')
            ->limit(50)
            ->orderBy('date_ajout','desc')
            ->get();

        $posts->map(function($post) {
            $post['userDetails'] = $post->userDetails($post->par);
            $post['all'] = true;
            $post['postsComment'] = count($post->postsComment);
            $post['postsJaime'] = count($post->postsJaime);
            $post['postsVue'] = self::countPostVues($post->post_id);
        });

        return $posts;
    }

    public static function showPosts($login,$user_id=null,$attr=null,$value=null){
        $posts=self::with('tag','postsComment','postsJaime')
            ->limit(50)
            ->orderBy('date_ajout','desc')
            ->get();




        $posts->map(function($post){
            $post['userDetails']=$post->userDetails($post->par);
            $post['all']=true;
            $post['postsComment']=count($post->postsComment);
            $post['postsJaime']=count($post->postsJaime);
            $post['postsVue']=self::countPostVues($post->post_id);



            if(strpos($post->youtube,"watch?v=")>0){$post['youtube']=str_replace("watch?v=", "embed/", $post->youtube);}

            elseif(strpos($post->youtube, "youtu.be/")>0){

                $post['youtube']=str_replace("youtu.be/", "youtube.com/embed/", $post->youtube);}

            elseif(strpos($post->youtube, "youtu.be")>0){$post['youtube']=str_replace("youtu.be","youtube.com/embed", $post->youtube);}


            if(strpos($post->youtube, "m.youtube")>0){$post['youtube']=str_replace("m.youtube", "youtube",$post->youtube);}

            elseif(strpos($post->youtube, "m.youtu")>0){$post['youtube']=str_replace("m.youtu","youtube", $post->youtube);}
            return $post;
        });



        $postsLast=$posts->where('date_ajout','>=',Carbon::now()->subDays(3));
        $postsLast->map(function($post){
            $post['postsInter']=$post['postsVue']+($post['postsJaime']*2)+($post['postsComment']*3);
            return $post;
        });
        $postsTopTwo=$postsLast->sortByDesc('postsInter')->take(2);
        $postsTopTwo->map(function($post){
            $post['all']=false;
            return $post;
        });

        $postsTopTwo=collect(array_values($postsTopTwo->toArray()));
        if(!empty($attr) && !empty($value)){
            $posts=collect(array_filter(array_values($posts->toArray()), function($v) use($attr,$value){
                return $v['userDetails']->$attr==$value;
            }));
        }
        $postsInteractive=null;
        if(!$login){
            $postsInteractive=$postsLast->sortByDesc('postsInter')->take(26*(!empty($request->numPosts)?$request->numPosts:1));
        }
        $posts=$posts->sortByDesc('date_ajout')->take(26*(!empty($request->numPosts)?$request->numPosts:1));

        if(!empty($user_id)){
            self::setViews($posts,$user_id);
        }
        $posts_odd=collect(array_filter(array_values($posts->toArray()), function($k) {
            return $k%2 != 0;
        }, ARRAY_FILTER_USE_KEY));
        $posts_even=collect(array_filter(array_values($posts->toArray()), function($k) {
            return $k%2 == 0;
        }, ARRAY_FILTER_USE_KEY));
        //most interactive
        $postsInteractive_odd=!empty($postsInteractive)?collect(array_filter(array_values($postsInteractive->toArray()), function($k) {
            return $k%2 != 0;
        }, ARRAY_FILTER_USE_KEY)):null;
        $postsInteractive_even=!empty($postsInteractive)?collect(array_filter(array_values($postsInteractive->toArray()), function($k) {
            return $k%2 == 0;
        }, ARRAY_FILTER_USE_KEY)):null;
        $postsTopTwo_odd=array_filter(array_values($postsTopTwo->toArray()), function($k) {
            return $k%2 != 0;
        }, ARRAY_FILTER_USE_KEY);
        $postsTopTwo_even=array_filter(array_values($postsTopTwo->toArray()), function($k) {
            return $k%2 == 0;
        }, ARRAY_FILTER_USE_KEY);

        return array('posts_odd'=>$posts_odd,'posts_even'=>$posts_even,'postsInteractive_odd'=>$postsInteractive_odd,'postsInteractive_even'=>$postsInteractive_even,'postsTopFive_odd'=>$postsTopTwo_odd,'postsTopFive_even'=>$postsTopTwo_even);
    }

    public static function sumTrophy($user){
        $income=0.0;
        //get sum trophy
        $posts=Post::where('par',$user->id)->get();
        $prices=array(0.5,0.3,0.1,0.09,0.07);
        foreach($posts as $trophy){
            if(!empty($trophy['trophy'])){
                $income+=$prices[$trophy['trophy']-1];
            }

        }
        return $income;
    }

    public static function setViews($posts,$user_id){
        $posts->each(function($post) use ($user_id){

            if($post['par']!=$user_id){
                Post::setViewPost($post['post_id'],$user_id);
            }

        });
    }

    public static function setViewPost($post_id,$user_id){
        $postsVue=new PostsVue();
        $postsVue->user_id=$user_id;
        $postsVue->post_id=$post_id;
        $postsVue->save();
    }
}
