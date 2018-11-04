<?php

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

Route::get('/', 'LoginController@index');
Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login/attempt', 'LoginController@attemptlogin')->name('attemptlogin');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::get('/register', 'LoginController@register')->name('register');
Route::post('/register/attempt', 'LoginController@attemptregister')->name('attemptregister');


Route::resource('dashboard', 'DashboardController')->except('post', 'destroy');
Route::post('/dashboard/store/{piggy_id}', 'DashboardController@store')->name('store');
Route::post('/dashboard/piggy_store', 'DashboardController@piggy_store')->name('piggy_store');
Route::delete('/dashboard/destroy/{id}/{piggy_id}', 'DashboardController@destroy')->name('destroy') ;
Route::get('/settings', 'SettingsController@index')->name('settings');
Route::post('/settings/update', 'SettingsController@update')->name('update_settings');
Route::post('/settings/destroy', 'SettingsController@destroy')->name('destroy_settings');

Route::get('/adminsettings', 'AdminsettingsController@index')->name('adminsettings');
Route::post('/adminsettings/destroy', 'AdminsettingsController@destroy')->name('destroy_adminsettings');
