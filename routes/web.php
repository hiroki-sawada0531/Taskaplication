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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    if (Auth::user()) {
        return redirect()->route('home');
    }

    return redirect('/login');
}); //welcomeへ向いているので、変更して下さい。

Auth::routes(); //既にあるはず

Route::get('/home', function () {
    return redirect()->route('tasks.index');
})->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('tasks', 'TaskController@index')->name('tasks.index');
    Route::post('tasks', 'TaskController@store')->name('tasks.store');
    Route::put('tasks/sync', 'TaskController@sync')->name('tasks.sync');
    Route::put('tasks/{task}', 'TaskController@update')->name('tasks.update'); //should be implemented.
    Route::delete('tasks/{tasks}', 'TaskController@destroy')->name('tasks.destroy'); // ←これが削除
});


Route::group(['middleware' => 'auth'], function () {
    Route::post('statuses', 'StatusController@store')->name('statuses.store');
    Route::put('statuses/sync', 'StatusController@sync')->name('statuses.sync');
    Route::put('statuses/{status}', 'StatusController@update')->name('statuses.update'); //should be implemented.
    Route::delete('statuses/{status}', 'StatusController@destroy')->name('statuses.destroy');
});