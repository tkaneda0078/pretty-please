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

    // store
    Route::resource('/wishs', 'WishController');

    Route::delete('/wish/{wish_list}', ['middleware' => 'auth', function (Wish_list $wish_list) {
        $wish_list->delete();

        return redirect('/');
    }]);

    Route::auth();
});
