<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $session = array();

    public function getLangCode($lang){
        $code = "en";


        if($lang===0){
            $code= "en";
        }else if($lang === 1 ){
            $code= "ar";
        }else{
            $code= "fr";
        }

        return $code;
    }
}
