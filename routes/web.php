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

Route::resource('jobs', 'JobsController');

Route::resource('candidates', 'CandidateController');

Route::resource('users', 'UserController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
