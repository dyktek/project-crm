<?php

Route::group([
	//'middleware' => 'auth.api'
], function () {

	Route::resources( [
		'events' => 'EventsController',
		'roles' => 'RolesController'
	] );

	Route::get( 'events/my-events/{user}', 'EventsController@myEvents' );
	Route::post('logout', 'AuthController@logout');
	Route::post('refresh', 'AuthController@refresh');

});

Route::post('login', 'AuthController@login');