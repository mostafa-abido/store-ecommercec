<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// note that  the prefix is admin for all file route

Route::group([
  'prefix' => LaravelLocalization::setLocale(),
  'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin' , 'prefix'=>'admin'], function () {
    
   Route::get('/','DashboardController@index')->name('admin.dashboard'); // the first page admin visits if auth;
   Route::get('logout','LoginController@logout')->name('admin.logout'); 

    Route::group(['prefix' => 'settings'],function(){
      
      Route::get('shipping-methods/{type}','SettingsController@editShippingMethods')-> name('edit.shippings.methods');
      Route::PUT('shipping-methods/{id}','SettingsController@updateShippingMethods')-> name('update.shippings.methods');
    });
    Route::group(['prefix' => 'profile'],function(){
      
      Route::get('edit','profileController@editProfile')-> name('edit.profile');
      Route::PUT('update','profileController@updateProfile')-> name('update.profile');
    });

    
       ######################### products  routes ############################
     
     Route::group(['prefix' => 'products'], function () {
      Route::get('/', 'ProductsController@index')->name('admin.products');
      Route::get('general-information', 'ProductsController@create')->name('admin.products.general.create');
      Route::post('store-general-information', 'ProductsController@store')->name('admin.products.general.store');
       
      
      Route::get('price/{id}', 'ProductsController@getPrice')->name('admin.products.price');
      Route::post('price', 'ProductsController@saveProductPrice')->name('admin.products.price.store');

     
      Route::get('images/{id}', 'ProductsController@addImages')->name('admin.products.images');
      Route::post('images', 'ProductsController@saveProductImages')->name('admin.products.images.store');

      Route::post('images/db', 'ProductsController@saveProductImagesDB')->name('admin.products.images.store.db');


      });
      ######################### end products    #############################  
    
   
 });


 Route::group(['namespace' => 'Dashboard','middleware'=>'guest:admin','prefix'=>'admin'],function(){
    Route::get('login','LoginController@login')-> name('admin.login');
    Route::post('login','LoginController@postLogin')-> name('admin.post.login');
 });

 
 
});