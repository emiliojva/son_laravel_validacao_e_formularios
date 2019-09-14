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

Route::get('/', function () {
    return view('welcome');
});

/**
 * Declarando rota para recurdo de nome admin.
 * Ex: 'admin/store', 'admin/destroy' e etc.
 */ 
//Route::resource('admin','Admin\ClientsController');    

/**
 *  Declarando um resource dentro de um grupo rota. 
 *  admin/[ClientsController@actions]
 */
// Route::group( ['prefix'=>'admin'],function(){
//     Route::resource('clients','Admin\ClientsController');        
// });

/**
 *  Declarando groupo rota verboso(detalhado), com uso do param namespace.
 *  Herdará actions do ClientsController que é um resource route (index,create e outros metodos do padrao)
 */
Route::group([
    'prefix'    =>'admin',
    'namespace' =>'Admin'
],function(){
    Route::resource('clients','ClientsController');
});

// Criando uma rota nomeada

Route::name('meu-nome')->get('/rota-nomeada',function (){
    echo "Hello Rota nomeada";
});
// ou
Route::get('/rota-nomeada',function (){
    echo "Hello Rota nomeada";
})->name('meu-nome');
