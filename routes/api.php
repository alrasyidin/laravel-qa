<?php

use Illuminate\Support\Facades\Route;

Route::get('questions', 'Api\QuestionsController@index');
Route::get('questions/{question}-{slug}', 'Api\QuestionDetailsController');
Route::get('questions/{question}/answers', 'Api\AnswersController@index');

Route::post('login', 'Api\Auth\LoginController@store');
Route::post('register', 'Api\Auth\RegisterController');
// Route::post('token', 'Auth\LoginController@getToken');

Route::middleware('auth:api')->group(function () {
    Route::apiResource('questions', 'Api\QuestionsController')->except('index');
    Route::apiResource('questions.answers', 'Api\AnswersController')->except('index');

    // vote
    Route::post('questions/{question}/vote', 'Api\VoteQuestionController');
    Route::post('answers/{answer}/vote', 'Api\VoteAnswerController');

    // accept best answer
    Route::post('/answers/{answer}/accept', 'Api\AcceptBestAnswerController')->name('answers.accept');

    // favorite question
    Route::post('/questions/{question}/favorite', 'Api\FavoriteController@store')->name('questions.favorite');
    Route::delete('/questions/{question}/favorite', 'Api\FavoriteController@destroy')->name('questions.unfavorite');

    // my posts
    Route::get('/my-posts', 'Api\MyPostController');

    //logout
    Route::post('logout', 'Api\Auth\LoginController@destroy');
});
