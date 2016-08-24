<?php

return [
	
	'type' => env('PAYMENT_TYPE', 'batihost'),

	'methods' => [

		'batihost' => [
			'id' => env('BATIHOST_ID'),
			'token' => env('BATIHOST_TOKEN')
		]

	]

];