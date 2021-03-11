<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table='slider';
    protected $primaryKey='id';
    protected $fillables=['title', 'descr', 'btn_txt', 'lien', 'img', 'date_ajout'];
    public $timestamps=false;
}
