<?php

use App\Models\User;
use App\Services\PostService;
use Illuminate\Support\Facades\Config;


require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$postService = new PostService();

$bestAuthors = $postService->bestAuthors();


if(count($bestAuthors)>0){
    $bestAuthor = $bestAuthors[0];
}else{
    die;
}

$best_author_points = $bestAuthor->best_author_points;
$best_author_points++;
User::where('id','!=',$bestAuthor->usr_id)->update(array('best_author_points'=>0));
User::where('id',$bestAuthor->usr_id)->update(array('best_author_points'=>$best_author_points));

if($best_author_points==Config::get('constants.BEST_AUTHOR_COUNT_DAYS')){
    $best_author_wins = $bestAuthor->best_author_wins;
    $income = $bestAuthor->income;
    $best_author_wins++;
    $income += Config::get('constants.BEST_AUTHOR_WIN');
    $data = array(
        'best_author_last_win'=>date('Y-m-d'),
        'best_author_wins'=>$best_author_wins,
        'income'=>$income,
        'best_author_points'=>0);
    User::where('id',$bestAuthor->usr_id)->update($data);
}


