<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
//header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

$auth_key = $_POST["auth_key"];

if (empty($auth_key)) {
	die();
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.tempo.io/core/3/work-attributes");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	"Authorization: Bearer " . $auth_key
));

$result = curl_exec($ch);

// //http_response_code(curl_getinfo($ch, CURLINFO_HTTP_CODE));

curl_close($ch);

// $obj = json_decode($result);
// echo $result;


// echo "Hello: ";
// echo $_POST["auth_key"];
?>