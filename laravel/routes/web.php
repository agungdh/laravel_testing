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

Route::get('/', 'WelcomeController@index');

Route::get('ajaxkabupaten', 'WelcomeController@ajaxKabupaten');
Route::get('ajaxchart1/{kab_id}', 'WelcomeController@ajaxChart1');
Route::get('ajaxchart11/{kab_id}/{tahun}', 'WelcomeController@ajaxChart11');
Route::get('ajaxchart12/{kab_id}/{tahun}', 'WelcomeController@ajaxChart12');

Route::get('pdf/{kab_id}/{tahun}', 'WelcomeController@pdf');
Route::get('pdfall/{tahun}', 'WelcomeController@pdfall');

Route::post('login', 'WelcomeController@login');
Route::get('logout', 'WelcomeController@logout');

Route::get('profil', 'ProfilController@index');
Route::put('profil/ubah', 'ProfilController@ubah');
Route::put('profil/gantipassword', 'ProfilController@gantiPassword');

Route::get('test', 'TestController@index');
Route::get('test/hash/{hash}', 'TestController@hash');

Route::get('config', 'ConfigController@index');
Route::put('config', 'ConfigController@update');

Route::resource('klui', 'KluiController');

Route::get('perusahaan/ajaxprovinsi', 'PerusahaanController@ajaxProvinsi');
Route::get('perusahaan/ajaxkabupaten/{id}', 'PerusahaanController@ajaxKabupaten');
Route::get('perusahaan/ajaxkecamatan/{id}', 'PerusahaanController@ajaxKecamatan');
Route::get('perusahaan/ajaxkelurahan/{id}', 'PerusahaanController@ajaxKelurahan');
Route::get('perusahaan/download/{id}', 'PerusahaanController@download');
Route::get('perusahaan/showpdf/{id}', 'PerusahaanController@showPdf');
Route::resource('perusahaan', 'PerusahaanController');

Route::put('user/gantipassword/{id}', 'UserController@gantiPassword');
Route::resource('user', 'UserController');