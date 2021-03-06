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
Route::get('/jobs/{candidate}/job-application-pdf-view','JobsController@jobApplicationViewPDF')->name('jobs.job-application-pdf-view');
Route::get('/jobs/{candidate}/job-application-pdf-save','JobsController@jobApplicationSavePDF')->name('jobs.job-application-pdf-save');

Route::get('/', 'JobsController@index')->name('jobs.index');
Route::post('/', 'JobsController@index')->name('jobs.search');
Route::get('/jobs/locations', 'JobsController@jobLocations')->name('jobs.locations');
Route::get('/jobs/selected', 'JobsController@selectedLocations');

Route::get('/users', 'UserController@index')->name('users.index')->middleware('verifyAuthenticated');
Route::get('/users/{user}', 'UserController@show')->name('users.show')->middleware('verifyUser');
Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit')->middleware('verifyUser');
Route::put('/users/{user}', 'UserController@update')->name('users.update')->middleware('verifyUser');

Route::get('/advertisements/{location}/location', 'AdvertisementController@advertisementsForLocation')
     ->name('advertisements.findByPreferredLocation');

Route::resource('jobs', 'JobsController');

Route::resource('candidates', 'CandidateController');

Route::resource('advertisements', 'AdvertisementController');

Route::resource('messages', 'MessageController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
