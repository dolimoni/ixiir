<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostsJaime extends Model
{
    use HasFactory;

    protected $table='posts_jaime';
    protected $primaryKey='id';
    protected $fillables=['date_ajout'];
    public $timestamps=false;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function post(){
        return $this->belongsTo('App\Models\Post','post_id');
    }
}
