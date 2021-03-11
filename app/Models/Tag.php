<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table='tags';
    protected $primaryKey='id';
    protected $fillables=['tag', 'created_at'];
    public $timestamps=false;

    public function posts(){
        return $this->hasMany('App\Models\Post','tag_id','id');
    }
}
