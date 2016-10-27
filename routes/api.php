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

Route::get( 'episode/{id}', 'EpisodeController@indexById' );
Route::get( 'episode/status/{status}', 'EpisodeController@indexByStatus' );
Route::get( 'episode/name/{name}', 'EpisodeController@indexByName' );
Route::resource( 'episode', 'EpisodeController', [
	'only' => [ 'store', 'update', 'destroy' ]
]);

Route::get( 'collection', 'CollectionController@index' );
Route::get( 'collection/{id}', 'CollectionController@indexById' );
Route::get( 'collection/status/{status}', 'CollectionController@indexByStatus' );
Route::get( 'collection/name/{name}', 'CollectionController@indexByName' );
Route::resource( 'collection', 'CollectionController', [
	'only' => [ 'store', 'update', 'destroy' ]
]);

Route::get( 'history/{id}', 'HistoryController@indexById' );
Route::get( 'history/object/{object}', 'HistoryController@indexByObject' );
Route::resource( 'history', 'HistoryController', [
	'only' => [ 'store', 'update', 'destroy' ]
]);