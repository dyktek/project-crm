<?php

Route::resources([
	'events' => 'EventsController'
]);

Route::get('events/my-events/{user}', 'EventsController@myEvents');