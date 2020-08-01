<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('event-persons', 'EventController@getEventPersons');     //.
Route::delete('person/{id}', 'PersonController@deletePerson');      //.

Route::get('event-info', 'EventController@getEventInfo');           //.
Route::put('event-info', 'EventController@updateEventInfo');        //.
Route::get('event-overlaps', 'EventController@getEventOverlaps');   //.

Route::post('answer', 'AnswerController@store');                    //.
Route::delete('answer/{id}', 'AnswerController@deleteAnswer');      //.
Route::get('my-answers', 'AnswerController@getMyAnswers');          //.
