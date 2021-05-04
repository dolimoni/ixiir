<?php

namespace App\Http\Controllers;

use App\Models\UserVue;
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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use DB;
use Symfony\Component\HttpFoundation\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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


        $lang = $request->session()->get('lang');
        $langCode = $this->getLangCode($lang);
        $specialites=MetierSpecialite::orderBy('nom_en', 'ASC')->get();


        $user=User::with('country','city','metierSpecialite')->find(Auth::user()->id);
        $posts=Post::showPosts(false,$request->user()->id);
        $topics=Tag::where('created_at','>=',Carbon::now()->subDays(10))
            ->where('tags.visible',1)
            ->get();
        $params = array(
            'showComments' => false,
            'isHotTopic' => false
        );





        $posts_odd=$posts['posts_odd'];
        $posts_even=$posts['posts_even'];
        $posts_odd_plus=$posts['posts_odd_plus'];
        $posts_even_plus=$posts['posts_even_plus'];
        $postsInteractive_odd=$posts['postsInteractive_odd'];
        $postsInteractive_even=$posts['postsInteractive_even'];
        $postsTopFive_odd=$posts['postsTopFive_odd'];
        $postsTopFive_even=$posts['postsTopFive_even'];
        $postsTopFive_even=$posts['postsTopFive_even'];
        Post::updatePosition();
        $topTopics=DB::table('tags')->select('tags.tag',DB::raw('count(posts.post_id)+count(posts_comment.post_id) as word'))
            ->where('tags.created_at','>=',Carbon::now()->subDays(10))
            ->where('tags.visible',1)
            ->join('posts','tags.id','=','posts.tag_id')
            ->leftJoin('posts_comment','posts.post_id','=','posts_comment.post_id')->groupBy('tags.tag')->get()->sortByDesc('word')->take(5);
        return view('index',compact('user','topTopics','topics','pays','villes','metiers','specialites','posts_odd','posts_even','postsTopFive_odd','postsTopFive_even','postsInteractive_odd','postsInteractive_even','params','posts_even_plus','posts_odd_plus'));
    }


    public function addPost(Request $request){

        if(isset($request->txt_youtube)){
            $request->txt_youtube.='&';
            $parsed = $this->get_string_between($request->txt_youtube, '?v=', '&');
            $request->txt_youtube = "https://www.youtube.com/embed/".$parsed;
        }

        $firstPost=Post::where('par',$request->user()->id)->orderByDesc('date_ajout')->first();
        $hours = 12;
        if(!empty($request->txt_updpost_id)){
            $post=Post::find($request->txt_updpost_id);
            $post->detail=$request->detail;
            $post->youtube=$request->txt_youtube;
            if(!empty($request->image)){
                $filename = "ixiir-post-".$request->user()->id."-".time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move('upload/posts', $filename);
                $post->image='/upload/posts/'.$filename;
            }

            if(!empty($request->txt_hash)){
                $tag=Tag::where('id',$request->txt_hash)->first();
                if(empty($tag)){
                    $tag=new Tag();
                    $tag->tag=$request->txt_hash;
                    $tag->created_at=Carbon::now();
                    $tag->save();
                }
                $post->tag_id=$tag->id;
            }else if(!empty($request->txt_hash_select)){
                $post->tag_id=$request->txt_hash_select;
            }
            $post->save();
        }else{
            if(!empty($firstPost))  {
                $date_ajout = Carbon::createFromFormat('Y-m-d H:i:s', $firstPost->date_ajout);
                $current=Carbon::now();
                $hours = $date_ajout->diffInHours($current);
            }
            if($hours>=12){
                $post=new Post();
                $post->detail=$request->detail;
                $post->par=$request->user()->id;
                $post->pour=0;
                $post->date_ajout=Carbon::now();
                $post->youtube=$request->txt_youtube;
                if(!empty($request->image)){
                    $filename = "ixiir-post-".$request->user()->id."-".time().'.'.$request->image->getClientOriginalExtension();
                    $request->image->move('upload/posts', $filename);
                    $post->image='/upload/posts/'.$filename;
                }

                if(!empty($request->txt_hash)){
                    $tag=Tag::where('id',$request->txt_hash)->first();
                    if(empty($tag)){
                        $tag=new Tag();
                        $tag->tag=$request->txt_hash;
                        $tag->created_at=Carbon::now();
                        $tag->save();
                    }
                    $post->tag_id=$tag->id;
                }else if(!empty($request->txt_hash_select)){
                    $post->tag_id=$request->txt_hash_select;

                }

                $post->save();

            }
        }
        return redirect()->route('home');
    }

     function aimerPost(Request $request){
		if($request->txt_jaimeornot>0){
            PostsJaime::where('user_id',Auth::user()->id)->where('post_id',$request->txt_idposjaime)->delete();
        }else {
            $postsJaime=new PostsJaime();
            $postsJaime->user_id=Auth::user()->id;
            $postsJaime->post_id=$request->txt_idposjaime;
            $postsJaime->save();
        }
        Post::updatePosition();
    }

    function vuePost(Request $request){
		Post::setViewPost($request->txt_idposvue,$request->user()->id);
        Post::updatePosition();
    }

    function commentPost(Request $request){
		$postsComment=new PostsComment();
        $postsComment->user_id=$request->user()->id;
        $postsComment->detail=htmlspecialchars($request->txt_comentaire);
        $postsComment->post_id=$request->txt_idpost;
        $postsComment->save();
        $user=User::find($postsComment->user_id);
        Post::updatePosition();
        return response(array('postsComment'=> $postsComment,'user'=> $user), 200);
    }

    function isAdmin(){
        $isAdmin = false;
        if(Auth::user()->id === 1822 || Auth::user()->id === 1){
            $isAdmin = true;
        }
        return $isAdmin;
    }

    function deleteCommentPost(Request $request){

		if($this->isAdmin()){
            $postComment = PostsComment::find($request->txt_idcomntdelete);
        }else{
            $postComment = PostsComment::where('id',$request->txt_idcomntdelete)->where('user_id',Auth::user()->id);
        }

		if(!empty($postComment) && $postComment->delete()){
            return true;
        }

        return false;
    }

     function followPost($oper,$user_vue,$user_id){
		if($oper=="delflw")
		{
            UserAbonne::where('user_vue',$user_vue)->where('user_id',$user_id)->update(['abonne_del'=>1]);
		}else {
            $nbr_abon=UserAbonne::where('user_vue',$user_vue)->where('user_id',$user_id)->count();
            if($nbr_abon>0)
            {
                UserAbonne::where('user_vue',$user_vue)->where('user_id',$user_id)->update(['abonne_del'=>0]);
            }
            else
            {
                $userAbonne=new UserAbonne();
                $userAbonne->user_vue=$user_vue;
                $userAbonne->user_id=$user_id;
                $userAbonne->abonne_del=0;
                $userAbonne->add_auto=0;
                $userAbonne->save();
            }
        }
    }

    public function getProfil($user_id,Request $request){
        $pays=Pays::get();
        $metiers=Metier::get();


        $userVue = new UserVue();



        if(!isset($_COOKIE['pfllstsn_'.$user_id])){
            setcookie('pfllstsn_'.$user_id,$user_id,time()+300);
            $userVue->user_id=$user_id;
            $userVue->user_vue=Auth::user()->id;
            $userVue->save();
        }

        $lang = $request->session()->get('lang');
        $langCode = $this->getLangCode($lang);
        $specialites=MetierSpecialite::orderBy('nom_en', 'ASC')->get();

        $user=User::with('country','city','metierSpecialite')->find($user_id);
        $country=empty($user['country']['id'])?1:$user['country']['id'];
        $villes=Pays::with('villes')->find($country)->villes;
        $posts=User::posts($user_id)->sortByDesc('date_ajout')->take(26);
        $posts->map(function($post){
            $post['profil']=true;
            return $post;
        });
        $params = array(
            'showComments' => false,
            'isHotTopic' => false
        );
        $topics=Tag::where('created_at','>=',Carbon::now()->subDays(10))
            ->where('tags.visible',1)
            ->get();

        $posts_even=array_filter(array_values($posts->toArray()), function($k) {
            return $k%2 == 0;
        }, ARRAY_FILTER_USE_KEY);
        $posts_odd=array_filter(array_values($posts->toArray()), function($k) {
            return $k%2 != 0;
        }, ARRAY_FILTER_USE_KEY);
        $messagesDu=[];
        $messagesAu=[];
        $messages=[];
        if($request->user()->id==$user_id){
            $messages=Message::with('user')->where('msg_du',$user_id)->orWhere('msg_au',$user_id)->get()->sortBy('date_ajout');
        }


        $profiles=Message::with('user')->select('msg_du')->where('msg_au',$request->user()->id)->distinct('msg_du')->get()->sortBy('date_ajout,lu DESC');

        return view('profil',compact('user','pays','villes','metiers','specialites','user','posts_even','posts_odd','messages','messagesAu','messagesDu','profiles','params','topics'));
    }

    public function updateProfil(Request $request){
        $user=User::with('country','city','metierSpecialite')->find(Auth::user()->id);
        if(!empty($user)){
            $user->fill($request->post());
            $user->password=Hash::make($request->password);
            if(!empty($request->image)){
                $filename = "ixiir-user-".Auth::user()->id."-".time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move('upload/user', $filename);
                $user->image='/upload/user/'.$filename;
            }
            $user->save();
            //return redirect()->route('getProfil',['user_id'=>$request->user_id]);
        }
        //return redirect()->route('home');
    }

    public function postsCountry(Request $request,$country)
    {

        $pays=Pays::get();
        $villes=Pays::with('villes')->find(1)->villes;
        $metiers=Metier::get();
        $specialites=MetierSpecialite::get();
        $posts=Post::showPosts(false,$request->user()->id,'pays',$country);
        $posts_odd=$posts['posts_odd'];
        $posts_even=$posts['posts_even'];
        //most interactive
        $postsInteractive_odd=$posts['postsInteractive_odd'];
        $postsInteractive_even=$posts['postsInteractive_even'];
        $postsTopFive_odd=$posts['postsTopFive_odd'];
        $postsTopFive_even=$posts['postsTopFive_even'];
        $topics=Tag::get();
        $_SESSION['page']='country';
        $user=User::with('country','city','metierSpecialite')->find(Auth::user()->id);
        $params = array(
            'showComments' => true,
            'isHotTopic' => false
        );
        $topicEntity=Tag::where('tag','')->first();
        $topics=Tag::where('created_at','>=',Carbon::now()->subDays(10))
            ->where('tags.visible',1)
            ->get();
        $topTopics=DB::table('tags')->select('tags.tag',DB::raw('count(posts.post_id)+count(posts_comment.post_id) as word'))->where('tags.created_at','>=',Carbon::now()->subDays(10))->join('posts','tags.id','=','posts.tag_id')->leftJoin('posts_comment','posts.post_id','=','posts_comment.post_id')->groupBy('tags.tag')->get()->sortByDesc('word')->take(5);
        return view('index',compact('topTopics','pays','villes','metiers','specialites','topics','posts_odd','posts_even','postsTopFive_odd','postsTopFive_even','postsInteractive_odd','postsInteractive_even','user','params','topicEntity'));
    }

    public function postsCity(Request $request,$city)
    {

        $pays=Pays::get();
        $villes=Pays::with('villes')->find(1)->villes;
        $metiers=Metier::get();
        $specialites=MetierSpecialite::get();
        $posts=Post::showPosts(false,$request->user()->id,'ville',$city);
        $posts_odd=$posts['posts_odd'];
        $posts_even=$posts['posts_even'];
        //most interactive
        $postsInteractive_odd=$posts['postsInteractive_odd'];
        $postsInteractive_even=$posts['postsInteractive_even'];
        $postsTopFive_odd=$posts['postsTopFive_odd'];
        $postsTopFive_even=$posts['postsTopFive_even'];
        $topics=Tag::get();
        $_SESSION['page']='city';
        $user=User::with('country','city','metierSpecialite')->find(Auth::user()->id);
        $params = array(
            'showComments' => true,
            'isHotTopic' => false
        );
        $topicEntity=Tag::where('tag','')->first();
        $topics=Tag::where('created_at','>=',Carbon::now()->subDays(10))
            ->where('tags.visible',1)
            ->get();
        $topTopics=DB::table('tags')->select('tags.tag',DB::raw('count(posts.post_id)+count(posts_comment.post_id) as word'))->where('tags.created_at','>=',Carbon::now()->subDays(10))->join('posts','tags.id','=','posts.tag_id')->leftJoin('posts_comment','posts.post_id','=','posts_comment.post_id')->groupBy('tags.tag')->get()->sortByDesc('word')->take(5);
        return view('index',compact('topTopics','pays','villes','metiers','specialites','topics','posts_odd','posts_even','postsTopFive_odd','postsTopFive_even','postsInteractive_odd','postsInteractive_even','user','params','topicEntity'));
    }

    public function postsMetier(Request $request,$metier)
    {

        $pays=Pays::get();
        $villes=Pays::with('villes')->find(1)->villes;



        $metiers=Metier::get();
        $specialites=MetierSpecialite::get();
        $posts=Post::showPosts(false,$request->user()->id,'specialite',$metier);
        $posts_odd=$posts['posts_odd'];
        $posts_even=$posts['posts_even'];
        //most interactive
        $postsInteractive_odd=$posts['postsInteractive_odd'];
        $postsInteractive_even=$posts['postsInteractive_even'];
        $postsTopFive_odd=$posts['postsTopFive_odd'];
        $postsTopFive_even=$posts['postsTopFive_even'];
        $_SESSION['page']='metier';
        $user=User::with('country','city','metierSpecialite')->find(Auth::user()->id);
        $params = array(
            'showComments' => true,
            'isHotTopic' => false
        );
        $topicEntity=Tag::where('tag','')->first();
        $topics=Tag::where('created_at','>=',Carbon::now()->subDays(10))
            ->where('tags.visible',1)
            ->get();
        $topTopics=DB::table('tags')->select('tags.tag',DB::raw('count(posts.post_id)+count(posts_comment.post_id) as word'))->where('tags.created_at','>=',Carbon::now()->subDays(10))->join('posts','tags.id','=','posts.tag_id')->leftJoin('posts_comment','posts.post_id','=','posts_comment.post_id')->groupBy('tags.tag')->get()->sortByDesc('word')->take(5);
        return view('index',compact('topTopics','pays','villes','metiers','specialites','topics','posts_odd','posts_even','postsTopFive_odd','postsTopFive_even','postsInteractive_odd','postsInteractive_even','user','params','topicEntity'));
    }

    public function deletePost($id){
        if($this->isAdmin()){
            $post=Post::find($id);
        }else{
            $post=Post::where('post_id',$id)
                ->where('par',Auth::user()->id);
        }

        if(!empty($post)){
            $post->delete();
        }
        return redirect()->route('home');
    }

    public function showMessages(Request $request){
        $profiles=Message::with('user')->where('msg_au',$request->user()->id)->sortBy('date_ajout,lu DESC');
        if(!empty($user)){
            $message=new Message();
            $message->message=$request->txt_message;
            $message->msg_du=$request->user()->id;
            $message->msg_au=$request->user_message;
            $message->lu=0;
            $message->date_ajout=Carbon::now();
            $message->save();
        }
        return redirect()->route('getProfil',['profiles'=>$profiles,'user_id'=>$request->user_message]);
    }

    public function sendMessage(Request $request){
        $user=User::find($request->user_message);
        if(!empty($user)){
            $message=new Message();
            $message->message=$request->txt_message;
            $message->msg_du=$request->user()->id;
            $message->msg_au=$request->user_message;
            $message->lu=0;
            $message->date_ajout=Carbon::now();
            $message->save();
        }
        return redirect()->route('getProfil',['user_id'=>$request->user_message]);
    }

    public function templatePost($id){
        $post=Post::find($id);
        if(!empty($post)){
            $post['userDetails']=$post->userDetails($post->par);
            return view('templatePostShared',['post'=>$post]);
        }

    }

    public function deactivateUser(Request $request){
        $user=User::find($request->id);
        if(!empty($user)){
            $user->update(['detail_desactive'=>$request->txt_desc_out,'bloqbyadmin'=>1]);
        }
        return redirect()->route('home');
    }

    public function hottopicDetail($topic){

        $topicPosts=Tag::with('posts')->where('tag',$topic)->first();
        $topicEntity=Tag::where('tag',$topic)->first();
        $topicPosts_odd=[];
        $topicPosts_even=[];
        $user=User::with('country','city','metierSpecialite')->find(Auth::user()->id);
        $topics=Tag::where('created_at','>=',Carbon::now()->subDays(10))->get();


        $params = array(
            'showComments' => true,
            'isHotTopic' => true
        );
        $topics=Tag::where('created_at','>=',Carbon::now()->subDays(10))
            ->where('tags.visible',1)
            ->get();
        if(!empty($topicPosts)){

            $topicPosts=$topicPosts->posts->map(function($post){
                $post['userDetails']=$post->userDetails($post->par);
                $post['all']=true;
                $post['postsComment']=Post::countPostComment($post->post_id);
                $post['postsJaime']=Post::countPostJaime($post->post_id);
                $post['postsVue']=Post::countPostVues($post->post_id);
                if(strpos($post->youtube,"watch?v=")>0){$post['youtube']=str_replace("watch?v=", "embed/", $post->youtube);}

    			elseif(strpos($post->youtube, "youtu.be/")>0){

    			    $post['youtube']=str_replace("youtu.be/", "youtube.com/embed/", $post->youtube);}

    			elseif(strpos($post->youtube, "youtu.be")>0){$post['youtube']=str_replace("youtu.be","youtube.com/embed", $post->youtube);}

    			if(strpos($post->youtube, "m.youtube")>0){$post['youtube']=str_replace("m.youtube", "youtube",$post->youtube);}

    			elseif(strpos($post->youtube, "m.youtu")>0){$post['youtube']=str_replace("m.youtu","youtube", $post->youtube);}
                return $post;
            });
            $topicPosts_odd=collect(array_filter(array_values($topicPosts->toArray()), function($k) {
                return $k%2 != 0;
            }, ARRAY_FILTER_USE_KEY));
            $topicPosts_even=collect(array_filter(array_values($topicPosts->toArray()), function($k) {
                        return $k%2 == 0;
            }, ARRAY_FILTER_USE_KEY));
        }
        return view('topicPosts',['topicPosts_odd'=>$topicPosts_odd,'topicPosts_even'=>$topicPosts_even,'topic'=>$topic,'topics'=>$topics,'topicEntity'=>$topicEntity,'user'=>$user,'params'=>$params]);
    }

    public function getTopics(){
        $topics=Topic::get(['topic']);
        return response(array('topics'=> $topics), 200);
    }

    public function hotTopics(){
        $user=User::with('country','city','metierSpecialite')->find(Auth::user()->id);
        $topTopics=DB::table('tags')->select('tags.tag',DB::raw('count(posts.post_id)+count(posts_comment.post_id) as word'))
            ->where('tags.created_at','>=',Carbon::now()->subDays(10))
            ->where('tags.visible',1)
            ->join('posts','tags.id','=','posts.tag_id')->leftJoin('posts_comment','posts.post_id','=','posts_comment.post_id')->groupBy('tags.tag')->get()->sortByDesc('word');
        return view('topTopics',['topTopics'=>$topTopics,'user'=>$user]);
    }

    public function search(Request $request){

        $pays=Pays::get();
        $villes=Pays::with('villes')->find(1)->villes;
        $metiers=Metier::get();

        $searchWord = $request->txt_search;

        $specialites=MetierSpecialite::orderBy('nom_en', 'ASC')->get();


        $user=User::with('country','city','metierSpecialite')->find(Auth::user()->id);
        $posts=Post::searchPosts($searchWord);
        $topics=Tag::where('created_at','>=',Carbon::now()->subDays(10))
            ->get();
        $params = array(
            'showComments' => false,
            'isHotTopic' => false
        );

        $users = User::where('nom','like','%'.$searchWord.'%')->orWhere('prenom','like','%'.$searchWord.'%')->get();

        $posts_odd=$posts;
        $posts_even=$posts;
        return view('search',compact('user','topics','pays','villes','metiers','specialites','posts_odd','posts_even','params','searchWord','users'));
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}

?>
