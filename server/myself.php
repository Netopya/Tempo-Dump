<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Content-Type");

	$auth_key = $_POST["auth_key"];
	$email = $_POST["email"];

	if (empty($auth_key)) {
		die();
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://diffagency.atlassian.net/rest/api/3/myself");
	curl_setopt($ch, CURLOPT_USERPWD, $email . ":" . $auth_key);

	$result = curl_exec($ch);

	curl_close($ch);

?>