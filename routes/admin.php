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


    ######################### Categories routes ############################
    Route::group(['prefix' => 'main_categories'], function () {
      Route::get('/', 'MainCategoriesController@index')->name('admin.maincategories');
      Route::get('create', 'MainCategoriesController@create')->name('admin.maincategories.create');
      Route::post('store', 'MainCategoriesController@store')->name('admin.maincategories.store');
      Route::get('edit/{id}', 'MainCategoriesController@edit')->name('admin.maincategories.edit');
      Route::post('update/{id}', 'MainCategoriesController@update')->name('admin.maincategories.update');
      Route::get('delete/{id}', 'MainCategoriesController@destroy')->name('admin.maincategories.delete');
    });
      ######################### end Categories  #############################


    ######################### Sub Categories routes ############################
    Route::group(['prefix' => 'sub_categories'], function () {
      Route::get('/', 'SubCategoriesController@index')->name('admin.subcategories');
      Route::get('create', 'SubCategoriesController@create')->name('admin.subcategories.create');
      Route::post('store', 'SubCategoriesController@store')->name('admin.subcategories.store');
      Route::get('edit/{id}', 'SubCategoriesController@edit')->name('admin.subcategories.edit');
      Route::post('update/{id}', 'SubCategoriesController@update')->name('admin.subcategories.update');
      Route::get('delete/{id}', 'SubCategoriesController@destroy')->name('admin.subcategories.delete');
    });
      ######################### end Sub Categories  ############################# 
      
      
     ######################### brands  routes ############################
     
     Route::group(['prefix' => 'brands'], function () {
      Route::get('/', 'BrandsController@index')->name('admin.brands');
      Route::get('create', 'BrandsController@create')->name('admin.brands.create');
      Route::post('store', 'BrandsController@store')->name('admin.brands.store');
      Route::get('edit/{id}', 'BrandsController@edit')->name('admin.brands.edit');
      Route::post('update/{id}', 'BrandsController@update')->name('admin.brands.update');
      Route::get('delete/{id}', 'BrandsController@destroy')->name('admin.brands.delete');
      });
      ######################### end brands   #############################  



       ######################### tags  routes ############################
     
     Route::group(['prefix' => 'tags'], function () {
      Route::get('/', 'TagsController@index')->name('admin.tags');
      Route::get('create', 'TagsController@create')->name('admin.tags.create');
      Route::post('store', 'TagsController@store')->name('admin.tags.store');
      Route::get('edit/{id}', 'TagsController@edit')->name('admin.tags.edit');
      Route::post('update/{id}', 'TagsController@update')->name('admin.tags.update');
      Route::get('delete/{id}', 'TagsController@destroy')->name('admin.tags.delete');
      });
      ######################### end tags    #############################  
    

       ######################### products  routes ############################
     
     Route::group(['prefix' => 'products'], function () {
      Route::get('/', 'ProductsController@index')->name('admin.products');
      Route::get('general-information', 'ProductsController@create')->name('admin.products.general.create');
      Route::post('store-general-information', 'ProductsController@store')->name('admin.products.general.store');
      
      });
      ######################### end products    #############################  
    
   
 });


 Route::group(['namespace' => 'Dashboard','prefix'=>'admin'],function(){
   
    Route::get('login','LoginController@login')-> name('admin.login');
    Route::post('login','LoginController@postLogin')-> name('admin.post.login');
 });

 
 
});