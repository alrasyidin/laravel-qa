<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::view('{any}', 'spa')->where('any', '.*');

Route::get('/', "QuestionController@index");

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/questions', 'QuestionController')->except('show');
Route::get('/questions/{slug}', 'QuestionController@show')->name('questions.show');
Route::post('/questions/{question}/favorite', 'FavoriteController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorite', 'FavoriteController@destroy')->name('questions.unfavorite');

// answer base question per method
// Route::post('/question/{question}/answers', 'AnswerController@store')->name('questions.answer.store');

// answer base question use resource
Route::resource('/questions.answers', 'AnswerController')->only(['store', 'edit', 'update', 'destroy', 'index']);
Route::post('/answer/{answer}/accept', 'AcceptBestAnswerController')->name('answers.accept');

// vote question
Route::post('/questions/{question}/vote', 'VoteQuestionController');
// vote answer
Route::post('/answers/{answer}/vote', 'VoteAnswerController');