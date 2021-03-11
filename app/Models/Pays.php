<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    use HasFactory;

    protected $table='pays';
    protected $primaryKey='id';
    protected $fillables=['nom_fr','nom_en','nom_ar','date_ajout','order','ismaj'];
    public $timestamps=false;

    public function villes(){
        return $this->hasMany('App\Models\Ville','pays');
    }

    public static function villesPays($pays){
        return self::with('villes')->find($pays)->villes;
    }
}
