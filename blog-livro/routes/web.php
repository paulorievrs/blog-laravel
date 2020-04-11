<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes(); //ROTAS AUTH

Route::get('/', function () { 
    return view('welcome');
});

Route::get('hello-world', 'HelloWorldController@index');

/*
* Rota para USERS
*  
*/
Route::resource('/users', 'UserController');

/*
* Rota para Admin\Post e \Profile
* CRUD COMPLETO 
*/
Route::group(['middleware' => ['auth']], function() {
    Route::prefix('admin')->namespace('Admin')->group(function (){

        Route::resource('posts', 'PostController');
        Route::resource('categories', 'CategoryController');

        Route::prefix('profile')->name('profile.')->group(function(){

            Route::get('/', 'ProfileController@index')->name('index');
            Route::post('/', 'ProfileController@update')->name('update');
    
        });

    });

    
});

/*
* Rota para categorias
* CRUD COMPLETO 
*/
Route::prefix('admin')->namespace('Admin')->group(function (){

    Route::resource('categories', 'CategoryController');

});


Route::get('/home', 'HomeController@index')->name('home');
