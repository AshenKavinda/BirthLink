<?php
	// Authorisation details.
	$username = "kavindahemarathna456@gmail.com";
	$hash = "533bbf8a5522dec9aad68c8d3e2b06561767cde24748909ce9a521ddbefd20d3";

	// Config variables. Consult http://api.txtlocal.com/docs for more info.
	$test = "0";

	// Data for text message. This is the text message data.
	$sender = "API Test"; // This is who the message appears to be from.
	$numbers = "+940783117761"; // A single number or a comma-seperated list of numbers
	$message = "This is a test message from the PHP API script.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('https://api.txtlocal.com/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
    if ($result === false) {
        echo "Something went wrong please try again. cURL error: " . curl_error($ch);
    } else {
        echo "API Response: " . $result;
    }
	curl_close($ch);
?>