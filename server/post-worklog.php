<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$auth_key = $_POST["auth_key"];
$issue = $_POST["issue"];
$seconds = $_POST["seconds"];
$description = $_POST["description"];
$startDate = $_POST["startDate"];
$startTime = $_POST["startTime"];
$activity = $_POST["activity"];
$accountId = $_POST["accountId"];

if (empty($auth_key)) {
	die();
}

$post_fields = json_encode(array(
	'issueKey' => $issue,
	'timeSpentSeconds' => intval($seconds),
	'startDate' => $startDate,
	'startTime' => $startTime,
	'description' => $description,
	'authorAccountId' => $accountId,
	'attributes' => array(
		array(
			'key' => '_Activity_',
			'value' => $activity
		)
	)
));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.tempo.io/core/3/worklogs");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	"Authorization: Bearer " . $auth_key,
	"Content-Type:application/json"
));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

$result = curl_exec($ch);

curl_close($ch);

?>