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
    Route::get('/', function () {
        $wish_list = Wish_list::all();

        return view('top', ['wish_list' => $wish_list]);
    });

    Route::post('/wish', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:10',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $wish = new Wish_list;
        $wish->category = '';
        $wish->name = $request->name;
        $wish->save();

        return redirect('/');
    });

    Route::delete('/wish/{wish_list}', function (Wish_list $wish_list) {
        $wish_list->delete();

        return redirect('/');
    });

    Route::auth();
});
