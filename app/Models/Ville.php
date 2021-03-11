<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $primaryKey='id';
    protected $table='ville';
    protected $fillables=['nom_fr', 'nom_en', 'nom_ar', 'pays', 'date_ajout', 'order', 'ismaj'];
    public $timestamps=false;

    public function pays(){
        $this->belongsTo('App\Models\Pays','pays');
    }
}
