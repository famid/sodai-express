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
require base_path('routes/web/auth/auth.php');
require base_path('routes/web/admin/admin.php');
require base_path('routes/web/user/user.php');
// ------------------------------ Test routes ------------------------------
Route::get('/test', 'TestController@test')->name('test');
Route::get('/test-redirect/{id}', 'TestController@testRedirect')->name('test.redirect');
// ------------------------------ End Of Test Routes -----------------------

Route::get('/', "Web\Auth\LoginController@signIn")->name('web.auth.sign_in');

//Category

Route::get('/category/list_view','Web\Category\CategoryController@listView')->name('web.category.listView')->middleware(['auth','admin']);
Route::get('/category/category_table_data','Web\Category\CategoryController@categoryTableData')->name('web.category.categoryTableData')->middleware(['auth','admin']);

Route::get('/category/create/view','Web\Category\CategoryController@createView')->name('web.category.createView')->middleware(['auth','admin']);
Route::post('/category/create','Web\Category\CategoryController@create')->name('web.category.create')->middleware(['auth','admin']);

Route::get('/category/{id}/edit', 'Web\Category\CategoryController@editView' )->name('web.category.edit')->middleware(['auth','admin']);
Route::post('/category/update','Web\Category\CategoryController@update')->name('web.category.update')->middleware(['auth','admin']);

Route::get('/category/{id}/delete', 'Web\Category\CategoryController@delete' )->name('web.category.delete')->middleware(['auth','admin']);

//Product
Route::get('/product/list/{category_id}', 'Web\Product\ProductController@list')->name('web.product.list')->middleware(['auth','admin']);
Route::get('/product/filter_product_table_data/{category_id}','Web\Product\ProductController@filterProductTableData')->name('web.product.filterProductTableData')->middleware(['auth','admin']);

Route::get('/product/list_view','Web\Product\ProductController@listView')->name('web.product.listView')->middleware(['auth','admin']);
Route::get('/product/product_table_data','Web\Product\ProductController@productTableData')->name('web.product.productTableData')->middleware(['auth','admin']);

Route::get('/product/create/view','Web\Product\ProductController@createView')->name('web.product.createView')->middleware(['auth','admin']);
Route::post('/product/create','Web\Product\ProductController@create')->name('web.product.create')->middleware(['auth','admin']);

Route::get('/product/{id}/edit', 'Web\Product\ProductController@editView' )->name('web.product.edit')->middleware(['auth','admin']);
Route::post('/product/update','Web\Product\ProductController@update')->name('web.product.update')->middleware(['auth','admin']);

Route::get('/product/{id}/delete', 'Web\Category\CategoryController@delete' )->name('web.product.delete')->middleware(['auth','admin']);





