<?php

use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;


require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$postService = new PostService();

$bestPost = $postService->bestPost();



if($bestPost->winner==="true"){
    die('Fin traitement best post => we already have a winner');
}



if($bestPost->current_winner==="true"){
    if($bestPost->start_winner_date<=Carbon::now()->subHours(9) && $bestPost->winner==="false"){
        $user = User::find($bestPost->par);
        $data = array(
            'income' => $user->income+Config::get('constants.BEST_POST_WIN'),
            'best_word_wins' => $user->best_word_wins+1
        );
        User::where('id',$user->id)->update($data);
        Post::where("post_id",">=","1")->update(array('current_winner'=>'false'));
        Post::where('post_id',$bestPost->post_id)->update(array('winner'=>'true'));
    }
}else{
    Post::where('post_id','!=',$bestPost->post_id)->update(array('current_winner'=>'false'));
    Post::where('post_id',$bestPost->post_id)->update(array('current_winner'=>'true','start_winner_date'=>Carbon::now()));
    die('fin traitement best post => new current winner');
}

die('fin traitement best post');
