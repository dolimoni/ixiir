<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table='blog';
    protected $primaryKey='id';
    protected $fillables=['title','meta_title','meta_descr','meta_keyword','resumer','html_cntnt','image','date_ajout'];
    public $timestamps=false;
}
