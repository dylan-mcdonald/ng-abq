<?php

return [
	'table' => 'oauth_identities',
	'providers' => [
		'github' => [
			'client_id' => env('GITHUB_ID'),
			'client_secret' => env('GITHUB_SECRET'),
			'redirect_uri' => 'http://www.ng-abq.com/github/login',
			'scope' => []
		],
		'facebook' => [
			'client_id' => env('FACEBOOK_ID'),
			'client_secret' => env('FACEBOOK_SECRET'),
			'redirect_uri' => 'http://www.ng-abq.com/facebook/login',
			'scope' => []
		]
	],
];
