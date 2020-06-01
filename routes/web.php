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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', 'HomeController@index')->name('homepage');

Route::get('/shop', 'HomeController@shop')->name('shop');

Route::get('/product_detail/{id}', 'HomeController@productDetail')->name('product_detail');

Route::get('/cart', 'HomeController@cart')->name('cart');

Route::post('/order', 'HomeController@order')->name('order');


//backend
Route::group(['middleware' => ['role:admin']], function () {
	Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
		Route::get('/dashboard', function () {
	    return view('backend.dashboard');
		})->name('dashboard');
		Route::resource('/category','CategoryController');
		Route::get('/get_category','CategoryController@get_category')->name('get_category');
		Route::resource('/brand','BrandController');
		Route::get('/get_brand','BrandController@get_brand')->name('get_brand');
		Route::resource('/item','ItemController');
		Route::get('/get_item','ItemController@getItem')->name('get_item');

	});	
});		



