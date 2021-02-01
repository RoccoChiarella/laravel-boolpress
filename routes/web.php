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

Route::get('/', 'HomeController@index')->name('index');
Route::get('/contatti', 'HomeController@contatti')->name('contatti');
Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/posts/{slug}', 'PostController@show')->name('posts.show');
Route::get('/categories/{slug}', 'CategoryController@show')->name('categories.show');

Auth::routes();

Route::middleware('auth')->namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
    Route::get('/', 'HomeController@index')->name('index');
    Route::resource('/posts', 'PostController');
    Route::get('/profile', 'HomeController@profile')->name('profile');
    Route::post('/profile/generate-token', 'HomeController@generateToken')->name('generate_token');
});
