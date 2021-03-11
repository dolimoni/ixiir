<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ville;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GlobalController extends Controller
{
    public function quiSommesNous(){
        return view('qui-sommes-nous');
    }
    
    public function conditions(){
        return view('conditions');
    }
    
    public function concurrence(){
        return view('concurrence');
    }
    
    public function getVilles($pays){
       $villes=Ville::where('pays',$pays)->get();
       return response(array('villes'=> $villes), 200);
    }

    public function setLang(Request $request,$lang){
        $request->session()->put('lang', $lang=='en'?0:($lang=='fr'?2:1));
        return redirect()->back();
    }
     
    public function hashPass(Request $request){
        $user=User::find(1);
        $user->password=Hash::make($user->password);
        $user->save();
        return redirect()->back();
    } 
}
