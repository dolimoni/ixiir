<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/qui-sommes-nous', 'App\Http\Controllers\GlobalController@quiSommesNous')->name('qui-sommes-nous');
Route::get('/conditions', 'App\Http\Controllers\GlobalController@conditions')->name('conditions');
Route::get('/concurrence', 'App\Http\Controllers\GlobalController@concurrence')->name('concurrence');
Route::get('/sign-in', 'App\Http\Controllers\SignInController@index')->name('sign-in');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('addPost', 'App\Http\Controllers\HomeController@addPost')->name('addPost');
Route::post('addTopic', 'App\Http\Controllers\TopicController@create')->name('addTopic');
Route::post('updatePost', 'App\Http\Controllers\PostController@updatePost')->name('updatePost');
Route::get('aimerPost', [App\Http\Controllers\HomeController::class, 'aimerPost']);
Route::post('dislikePost', 'App\Http\Controllers\PostController@dislikePost')->name('dislikePost');
Route::get('vuePost', [App\Http\Controllers\HomeController::class, 'vuePost']);
Route::get('commentPost', [App\Http\Controllers\HomeController::class, 'commentPost']);
Route::get('deleteCommentPost', [App\Http\Controllers\HomeController::class, 'deleteCommentPost']);
Route::get('followPost/{oper}/{user_vue}/{user_id}', [App\Http\Controllers\HomeController::class, 'followPost']);
Route::get('profil/{user_id}', [App\Http\Controllers\HomeController::class, 'getProfil'])->name('getProfil');
Route::post('updateProfil', [App\Http\Controllers\HomeController::class, 'updateProfil'])->name('updateProfil');
Route::get('getVilles/{pays}', [App\Http\Controllers\GlobalController::class, 'getVilles']);
Route::get('/country/{country}', [App\Http\Controllers\HomeController::class, 'postsCountry'])->name('postsCountry');
Route::get('/city/{city}', [App\Http\Controllers\HomeController::class, 'postsCity'])->name('postsCity');
Route::get('/metier/{metier}', [App\Http\Controllers\HomeController::class, 'postsMetier'])->name('postsMetier');
Route::get('/setLang/{lang}', [App\Http\Controllers\GlobalController::class, 'setLang'])->name('setLang');
Route::post('/saveMessage', 'App\Http\Controllers\HomeController@saveMessage')->name('saveMessage');
Route::post('/saveMessage', 'App\Http\Controllers\HomeController@sendMessage')->name('sendMessage');
Route::post('/readMessages', 'App\Http\Controllers\HomeController@readMessages')->name('readMessages');
Route::get('/hashPass', 'App\Http\Controllers\GlobalController@hashPass')->name('hashPass');
Route::get('/deletePost/{id}', 'App\Http\Controllers\HomeController@deletePost')->name('deletePost');
Route::post('/deactivateUser', 'App\Http\Controllers\HomeController@deactivateUser')->name('deactivateUser');
Route::get('/templatePost/{id}', 'App\Http\Controllers\HomeController@templatePost')->name('templatePost');
Route::get('/hottopic', 'App\Http\Controllers\HomeController@hotTopics')->name('hotTopics');
Route::get('/hottopic/{topic}', 'App\Http\Controllers\HomeController@hottopicDetail')->name('hottopicDetail');
Route::get('/getTopics', 'App\Http\Controllers\HomeController@getTopics')->name('getTopics');
Route::get('/hashPass', 'App\Http\Controllers\GlobalController@hashPass')->name('hashPass');
Route::get('/room', [App\Http\Controllers\HomeController::class, 'room']);
Route::get('/post/show/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('showPost');
Route::get('/search', 'App\Http\Controllers\HomeController@search')->name('search');

Route::get('/admin', 'App\Http\Controllers\Admin\HomeController@index');
Route::get('/admin/topics', 'App\Http\Controllers\Admin\HomeController@topics')->name('admin.topics');
Route::get('/admin/showTopic', 'App\Http\Controllers\Admin\HomeController@showTopic')->name('admin.topic.show');
Route::get('/admin/hideTopic', 'App\Http\Controllers\Admin\HomeController@hideTopic')->name('admin.topic.hide');
Route::get('/admin/updateAllRanking', 'App\Http\Controllers\Admin\HomeController@updateAllRanking')->name('admin.topic.updateAllRanking');
Route::get('/admin/mail', 'App\Http\Controllers\Admin\HomeController@mail')->name('mail');
Route::get('/admin/api/topicController/delete/{id}', 'App\Http\Controllers\Admin\Api\TopicController@delete')->name('admin.topic.api.delete');
/*authentication*/
Auth::routes();
Route::get('/forgetPass', 'App\Http\Controllers\SignInController@forgetPass')->name('forgetPass');

Route::get('login/{provider}', 'App\Http\Controllers\Auth\LoginController@redirect');
Route::get('login/{provider}/callback','App\Http\Controllers\Auth\LoginController@callback');

