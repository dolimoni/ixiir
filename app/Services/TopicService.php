<?php


namespace App\Services;

use App\Models\Post;
use App\Models\PostsDislike;
use App\Models\PostsVue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TopicService extends BaseService{


    function __construct()
    {

    }

    public function addTopic($topic){
        var_dump($topic);die();
    }

}
