<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAbonne extends Model
{
    use HasFactory;

    protected $table='user_abonne';
    protected $primaryKey='id';
    protected $fillables=['user_id', 'user_vue', 'abonne_del', 'date_ajout', 'add_auto'];
    public $timestamps=false;
}
