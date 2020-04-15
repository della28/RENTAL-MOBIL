<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

  Route::middleware('auth:api')->get('/user', function (Request $request) {
      return $request->user();
  });

  Route::post('register', 'PetugasController@register');
  Route::post('login', 'PetugasController@login');
  Route::get('/', function(){
    return Auth::user()->level;
  })->middleware('jwt.verify');

  Route::get('user', 'PetugasController@getAuthenticatedUser')->middleware('jwt.verify');

  // // Penyewa
  Route::post('/simpan_penyewa','PenyewaController@store')->middleware('jwt.verify');
  Route::put('/ubah_penyewa/{id}','PenyewaController@update')->middleware('jwt.verify');
  Route::get('/tampil_penyewa','PenyewaController@tampil_penyewa')->middleware('jwt.verify');
  Route::delete('/hapus_penyewa/{id}','PenyewaController@destroy')->middleware('jwt.verify');


  // // Jenis mobil
  Route::post('/simpan_jenis','JenisController@store')->middleware('jwt.verify');
  Route::put('/ubah_jenis/{id}','JenisController@update')->middleware('jwt.verify');
  Route::get('/tampil_jenis','JenisController@tampil_jenis')->middleware('jwt.verify');
  Route::delete('/hapus_jenis/{id}','JenisController@destroy')->middleware('jwt.verify');

  // // Data Mobil
  Route::post('/simpan_data','DatamobilController@store')->middleware('jwt.verify');
  Route::put('/ubah_data/{id}','DatamobilController@update')->middleware('jwt.verify');
  Route::get('/tampil_data','DatamobilController@tampil_mobil')->middleware('jwt.verify');
  Route::delete('/hapus_data/{id}','DatamobilController@destroy')->middleware('jwt.verify');
  //
  //
  // // // transaksi
  Route::post('/simpan_trans','TransaksiController@store')->middleware('jwt.verify');

  // // // detail_transaksi
  Route::post('/simpan_detail','TransaksiController@simpan')->middleware('jwt.verify');


  Route::get('/report/{tgl_trans}/{deadline}','TransaksiController@report')->middleware('jwt.verify');
