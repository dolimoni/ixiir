<?php


namespace App\Services;

use App\Models\Post;
use App\Models\PostsVue;
use App\Models\User;
use App\Models\UserVue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService{


    function __construct()
    {

    }

    public function getPostsCount($id){
        return count(Post::where('par',$id)->get());
    }

    public function getAbonnesCount($id){
        return count(User::with('abonnes')->find($id)->abonnes->where('abonne_del', 0));
    }

    public function getPageVisitCount($id){
        return count(UserVue::where('user_id',$id)->get());
    }

    public function getPostVuesCount($id){
        //$a = "SELECT (@cnt := @cnt + 1) AS rowNumber, id from users CROSS JOIN (SELECT @cnt := 0) AS dummy where ville = 24160";

        $vues = DB::table('users','u')
            ->join('posts','posts.par','=','u.id')
            ->join('posts_vue as pv','posts.post_id','=','pv.post_id')
            ->where('u.id','=',$id)
            ->get();



        return count($vues);
    }

    public function updatRanking($id){
        $ranking = $this->calculateRanking($id);
        User::where('id',$id)->where('ranking','0')->update(['ranking'=>$ranking]);
    }

    public function updateAllRanking(){
        ini_set("memory_limit","2048M");
        $users = User::all();
        foreach ($users as $user){
            $this->updatRanking($user->id);
        }

        die('fin update ranking');
    }

    public function calculateRanking($id){
        $posts = $this->getPostsCount($id);

        $abonne = $this->getAbonnesCount($id);
        $pageVisits = $this->getPageVisitCount($id);

        $postsVues = $this->getPostVuesCount($id);

        $ranking = $postsVues + ($pageVisits+$posts)*10 + $abonne*100;

        return $ranking;
    }

    public function wordRanking($id){
        $sql = "SELECT (@cnt := @cnt + 1) AS rank,id,ville,pays
                        from users 
                        CROSS JOIN (SELECT @cnt := 0) AS dummy 
                        order by ranking desc ";
        $result = DB::select(DB::raw($sql));

        $index = array_search($id, array_column($result, 'id'));

        if($index!==false){
            return $result[$index]->rank;
        }else{
            return "NA";
        }
    }

    public function cityRanking($id,$ville){

        if(is_null($ville)){
            return "NA";
        }

        $sql = "SELECT (@cnt := @cnt + 1) AS rank,id,ville,pays
                        from users 
                        CROSS JOIN (SELECT @cnt := 0) AS dummy
                        where ville = $ville
                        order by ranking desc ";

        $result = DB::select(DB::raw($sql));

        $index = array_search($id, array_column($result, 'id'));

        if($index!==false){
            return $result[$index]->rank;
        }else{
            return "NA";
        }
    }

    public function countryRanking($id,$country){

        if(is_null($country)){
            return "NA";
        }
        $sql = "SELECT (@cnt := @cnt + 1) AS rank,id,ville,pays
                        from users 
                        CROSS JOIN (SELECT @cnt := 0) AS dummy
                        where pays = $country
                        order by ranking desc ";

        $result = DB::select(DB::raw($sql));

        $index = array_search($id, array_column($result, 'id'));

        if($index!==false){
            return $result[$index]->rank;
        }else{
            return "NA";
        }

    }


}