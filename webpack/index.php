<?php
require_once("lib/xsrf.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
setXsrfCookie();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<base href="/"/>

		<title>ng-abq</title>
	</head>
	<body>
		<div class="under-construction">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2 class="text-center">We are under construction. Come back and visit soon.</h2>
					</div>
				</div>
			</div>
		</div>
		<ng-abq-app>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="progress site-loading-bar">
							<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
								Loading site...
							</div>
						</div>
					</div>
				</div>
			</div>
		</ng-abq-app>
	</body>
</html>
