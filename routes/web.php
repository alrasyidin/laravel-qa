<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/questions', 'QuestionController')->except('show');
Route::get('/questions/{slug}', 'QuestionController@show')->name('questions.show');

// answer base question per method
// Route::post('/question/{question}/answers', 'AnswerController@store')->name('questions.answer.store');

// answer base question use resource
Route::resource('/questions.answers', 'AnswerController')->only(['store', 'edit', 'update', 'destroy']);
Route::post('/answer/{answer}/accept', 'AcceptBestAnswerController')->name('answers.accept');
