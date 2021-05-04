<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(!$this->isAdmin()){
            return redirect()->route('home');
        }
        return view('admin.index');
    }

    public function topics(Request $request)
    {
        if(!$this->isAdmin()){
            return redirect()->route('home');
        }

        $topics = Tag::orderByDesc('created_at')->get();
        return view('admin.topics',compact('topics'));
    }

    public function showTopic(Request $request){
        if(!$this->isAdmin()){
            return redirect()->route('home');
        }

        $topicId = $request->get('topicId');
        Tag::where('id', $topicId)
            ->update(['visible' => 1,'created_at' => Carbon::now()]);
        $topics = Tag::orderByDesc('created_at')->get();
        return view('admin.topics',compact('topics'));
    }

    public function hideTopic (Request $request){

        if(!$this->isAdmin()){
            return redirect()->route('home');
        }

        $topicId = $request->get('topicId');
        Tag::where('id', $topicId)
            ->update(['visible' => 0]);
        $topics = Tag::orderByDesc('created_at')->get();
        return view('admin.topics',compact('topics'));
    }

    function isAdmin(){

        $isAdmin = false;
        if(Auth::user()->id === 1822 || Auth::user()->id === 1){
            $isAdmin = true;
        }
        return $isAdmin;
    }
}
