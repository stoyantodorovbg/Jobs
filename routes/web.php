<?php

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

Route::get('/candidates/{job}/candidatesJob', 'CandidateController@candidatesJobIndex')->name('candidates.candidatesJob');
Route::post('/candidates/search', 'CandidateController@search')->name('candidates.search');

Route::get('/jobs/{job}/showApply', 'JobsController@showApply')->name('jobs.showApply');
Route::post('/jobs/{job}/apply', 'JobsController@apply')->name('jobs.apply');
Route::get('/', 'JobsController@index')->name('jobs.index');
Route::post('/search', 'JobsController@search')->name('jobs.search');

Route::get('/users', 'UserController@index')->name('users.index')->middleware('verifyAuthenticated');
Route::get('/users/{user}', 'UserController@show')->name('users.show')->middleware('verifyUser');
Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit')->middleware('verifyUser');
Route::put('/users/{user}', 'UserController@update')->name('users.update')->middleware('verifyUser');

Route::resource('jobs', 'JobsController');

Route::resource('candidates', 'CandidateController');

Route::resource('messages', 'MessageController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
