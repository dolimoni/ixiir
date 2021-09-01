<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Services\TopicService;
use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;
use App\Models\PostsJaime;
use App\Models\PostsVue;
use App\Models\PostsComment;
use App\Models\Pays;
use App\Models\Metier;
use App\Models\MetierSpecialite;
use App\Models\User;
use App\Models\Message;
use App\Models\UserAbonne;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use DB;

class TopicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $topicService;

    public function __construct()
    {
        $this->topicService = new TopicService();

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
     $topic = $request->topic;

     $this->topicService->addTopic($topic);

    }
}
