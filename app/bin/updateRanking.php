<?php

use App\Models\User;
use App\Services\PostService;
use App\Services\UserService;

require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$userService = new UserService();

$userService->updateAllRanking();
