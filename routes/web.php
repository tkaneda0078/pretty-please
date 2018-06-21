<?php

use App\Models\Wish_list;
use Illuminate\Http\Request;

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

Route::group(['middleware' => 'web'], function () {
    // top
    Route::get('/', 'WishController@index');

    // add store
    Route::resource('/wishs', 'WishController');

    // delete
    Route::get('/wishs/{id}', 'WishController@destroy');

    // line notification
    Route::get('/line/notify', 'Notification\LineNotifyController@notify');

    Route::auth();
});
