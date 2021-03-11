<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetierSpecialite extends Model
{
    use HasFactory;

    protected $table='metier_specialiste';
    protected $primaryKey='id';
    protected $fillables=['nom_fr','nom_en','nom_ar','metier','date_ajout','ismaj'];
    public $timestamps=false;
}
