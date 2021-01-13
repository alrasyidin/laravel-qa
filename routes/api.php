<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('questions', 'Api\QuestionsController@index');
Route::get('questions/{question}-{slug}', 'Api\QuestionDetailsController');
Route::get('questions/{question}/answers', 'Api\AnswersController@index');

Route::post('token', 'Auth\LoginController@getToken');

Route::middleware('auth:api')->group(function(){
    Route::apiResource('questions', 'Api\QuestionsController')->except('index');
    Route::apiResource('questions.answers', 'Api\AnswersController')->except('index');
});
