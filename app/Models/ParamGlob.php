<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamGlob extends Model
{
    use HasFactory;

    protected $table='param_glob';
    protected $primaryKey='id';
    protected $fillables=['nom','valeur','date_ajout'];
    public $timestamps=false;
}
