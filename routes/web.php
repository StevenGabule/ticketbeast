<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::post('/threads', 'ThreadsController@store')->name('threads.store');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

