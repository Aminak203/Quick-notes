<?php

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://nlp-translation.p.rapidapi.com/v1/translate",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "text=my%20name%20is%20sahil&to=ur&from=en",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: nlp-translation.p.rapidapi.com",
		"X-RapidAPI-Key: f292077523mshb0b1d2d9e6c4ce6p16f9d0jsnbcc7da5612a5",
		"content-type: application/x-www-form-urlencoded"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}