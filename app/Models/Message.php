<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table='message';
    protected $primaryKey='id';
    protected $fillables=['msg_du','msg_au','message','lu','date_ajout'];
    public $timestamps=false;
    
    public function user(){
        return $this->belongsTo('App\Models\User','msg_du','id');
    }
}
