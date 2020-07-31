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

Route::get('/', function () {
    return view('welcome');
});


Route::get('events/create', 'EventController@create')->name('events.create');
Route::post('events', 'EventController@store')->name('events.store');       // nastav cookie, zavolaj events/{code} spolu so spravou, ktora bude obsahovat osobny person code.

Route::get('events/{code}', 'EventController@show')->name('events.show');   // ak je dobre cookies(user code) a event code -> vrati event ... ak je zly event code -> return na welcome s chybou (neplatny event code) ... ak je zla/chyba cookie -> vrat view kde sa moze regnut (tlacitko: uz mam user code)


Route::post('register', 'PersonController@register')->name('persons.register');  //ak nema cookie tak sa mu zobrazi formular na registraciu do eventu, potvrdi sa cez tuto route (hidden input event code), z tohto sa zavola events/{code} spolu so spravou, ktora bude obsahovat osobny person code.

Route::get('login/{code}', 'PersonController@showLoginForm')->name('persons.loginForm');  
Route::post('login', 'PersonController@login')->name('persons.login');          //validuje sa osobny person code, ak je dobry, tak sa nastavi cookie a zavola sa events/{code} ({code} z hidden inputu)





// Route::get('events/show', 'EventController@show')->name('events.show');
// Route::get('missing-code', 'PersonController@missingCode')->name('missing-user-code');
// Route::get('/create-event', 'EventController@create')->name('events.create');
// Route::get('/register-to-event', 'PersonController@register')->name('persons.register');
// Route::get('events/create', 'EventController@create')->name('events.create');



// Route::middleware('person_token')->group(function () {

// });