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

Auth::routes();

// VIEW AND CRUD - USERS
Route::resource('users', 'UsersController')->names([
    'index' => 'users',
    'create' => 'users.create',
    'update' => 'users.update',
    'destroy' => 'users.destroy'
]);

// VIEW AND CRUD - COLORS
Route::resource('palette_colors', 'PaletteColorsController')->names([
    'index' => 'palette_colors',
    'create' => 'palette_colors.create',
    'update' => 'palette_colors.update',
    'destroy' => 'palette_colors.destroy'
]);

// VIEW AND CRUD - BLOCKS
Route::resource('blocks', 'BlocksController')->names([
    'index' => 'blocks',
    'create' => 'blocks.create',
    'update' => 'blocks.update',
    'destroy' => 'blocks.destroy'
]);

// VIEW AND CRUD - TYPES
Route::resource('types', 'TypesController')->names([
    'index' => 'types',
    'create' => 'types.create',
    'update' => 'types.update',
    'destroy' => 'types.destroy'
]);

// VIEW AND CRUD - NETWORKS
Route::resource('networks', 'NetworksController')->names([
    'index' => 'networks',
    'create' => 'networks.create',
    'update' => 'networks.update',
    'destroy' => 'networks.destroy'
]);

// VIEW AND CRUD - DEVICES
Route::resource('devices', 'DevicesController')->names([
    'index' => 'devices',
    'create' => 'devices.create',
    'update' => 'devices.update',
    'destroy' => 'devices.destroy'
]);

// VIEW AND CRUD - TEAMS
Route::resource('teams', 'TeamsController')->names([
    'index' => 'teams',
    'create' => 'teams.create',
    'update' => 'teams.update',
    'destroy' => 'teams.destroy'
]);

// VIEW AND CRUD - DIAGRAMS
Route::get('/diagrams', 'DiagramsController@index')->name('diagrams');

// PERFIL_COLOR_CHANGE
Route::post('/palette_colors/perfil_colors_change', 'PaletteColorsController@perfil_colors_change')->name('palette_colors.perfil_colors_change');

Route::get('{any}', function() {
    return redirect('login');
 })->where('any', '.*');
