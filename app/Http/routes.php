<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

get('/', function() { return Redirect::to('stores'); });

get('stores', 'HomeController@index');
post('stores', 'HomeController@validate');
get('oauth', 'HomeController@oauth');

get('stores/{id}/webhooks', array('as' => 'webhooks', 'uses' => 'HomeController@webhooks'));
post('stores/{id}/webhooks', 'HomeController@createHook');
