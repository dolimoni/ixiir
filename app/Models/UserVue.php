<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVue extends Model
{
    use HasFactory;

    protected $primaryKey='id';
    protected $table='user_vue';
    protected $fillables=['user_id', 'user_vue',  'date_ajout'];
    public $timestamps=false;
}
