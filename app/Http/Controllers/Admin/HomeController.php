<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('admin.index');
    }

    public function topics(Request $request)
    {
        $topics = Tag::orderByDesc('created_at')->get();
        return view('admin.topics',compact('topics'));
    }

    public function showTopic(Request $request){
        $topicId = $request->get('topicId');
        Tag::where('id', $topicId)
            ->update(['visible' => 1]);
        $topics = Tag::orderByDesc('created_at')->get();
        return view('admin.topics',compact('topics'));
    }

    public function hideTopic (Request $request){

        $topicId = $request->get('topicId');
        Tag::where('id', $topicId)
            ->update(['visible' => 0]);
        $topics = Tag::orderByDesc('created_at')->get();
        return view('admin.topics',compact('topics'));
    }
}
