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

// DATATABLES SERVICES
Route::get('/users/service', 'UsersController@service')->name('users.service');
Route::get('/types/service', 'TypesController@service')->name('types.service');
Route::get('/blocks/service', 'BlocksController@service')->name('blocks.service');
Route::get('/networks/service', 'NetworksController@service')->name('networks.service');
Route::get('/devices/service', 'DevicesController@service')->name('devices.service');
Route::get('/palette_colors/service', 'PaletteColorsController@service')->name('palette_colors.service');
Route::get('/teams/service', 'TeamsController@service')->name('teams.service');




Route::get('devices/export', 'DevicesController@export');
