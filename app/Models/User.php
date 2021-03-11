<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Pays;
use App\Ville;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $primaryKey='id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'detail_desactive', 'nom', 'prenom', 'user_vld', 'login', 'password', 'pays', 'ville', 'metier', 'specialite', 'image', 'id_role', 'user_type', 'lastconx', 'id_etapes', 'tbl_ref', 'date_out', 'source', 'id_reseaux', 'lang', 'vue', 'vue_post', 'abonne', 'date_ajout', 'pass_save', 'ismaj', 'bloqbyadmin'
    ];
    public $timestamps=false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function country(){
        return $this->belongsTo('App\Models\Pays','pays');
    }

    public function city(){
        return $this->belongsTo('App\Models\Ville','ville');
    }

    public function metier(){
        return $this->belongsTo('App\Models\Metier','metier');
    }

    public function metierSpecialite(){
        return $this->belongsTo('App\Models\MetierSpecialite','specialite');
    }

    public static function posts($user_id){
        $posts=Post::with('postsVue','postsJaime','postsComment')->where('par',$user_id)->get();
        $posts->map(function($post) use ($user_id){
            $post['userDetails']=$post->userDetails($user_id);
            $post['postsJaimeUser']=count($post->postsJaime->where('user_id', $user_id));
            $post->postsVue=count($post->postsVue);
            $post->postsJaime=count($post->postsJaime);
            $post->postsComment=count($post->postsComment);
            return $post;
       });
        return $posts;
    }

    public function abonnes(){
        return $this->hasMany('App\Models\UserAbonne','user_id');
    }
    
    public function userVue(){
        return $this->hasMany('App\Models\UserVue','user_id');
    }

    public static function countAbonnes($user_id){
        return count(self::with('abonnes')->find($user_id)->abonnes->where('abonne_del', 0));
    }

    public static function abonnesUser($user_id,$user_vue){
        return count(self::with('abonnes')->find($user_id)->abonnes->where('user_id', $user_id)->where('user_vue', $user_vue)->where('abonne_del', 0));
    }
}
