<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temoignage extends Model
{
    use HasFactory;

    protected $table='temoignage';
    protected $primaryKey='id';
    protected $fillables=['title', 'descr', 'image', 'date_ajout'];
    public $timestamps=false;
}
