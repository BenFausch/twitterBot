<!doctype html>
<html >
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<link rel="apple-touch-icon" href="apple-touch-icon.png">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet">

</head>
<body>
	<div>

		<?php

		require "twitteroauth/autoload.php";

		use Abraham\TwitterOAuth\TwitterOAuth;

		function getConnectionWithAccessToken($oauth_token, $oauth_token_secret) {
			$connection = new TwitterOAuth(HnJghiNKs68sJhdnNVN9alvAz, d1iwpD0AMY6ER0goT2QFwVhkqFETN1bTzRMYhmJz9ZzRyJeUlC, $oauth_token, $oauth_token_secret);
			return $connection;
		}


		$connection = getConnectionWithAccessToken("781532307228286976-FVPTxlj7624yyCCZ9PNdiegYqFPCWFI", "ft39Bp63NqbeX49pmpfTCPCBpelBO3g2ysaiG1ncAs9Db");

		if (!empty($_POST["tweet"])) {
			$tweet = $_POST["tweet"];
		}


		$content = $connection->post("statuses/update", ["status" => $tweet]);


		$errors = $content->errors;
		if (!empty($errors)){
			$errormsg = $errors[0]->message;
			echo('<h1>there was an error yo</h1><p>'.$errormsg.'</p>');
		}else{
			$timestamp = $content->created_at;
			$tweet = $content->text;


			echo('<h1>yo dawg you tweeted:</h1><p id="timestamp">At: '.$timestamp.'</p><p id="tweet">'.$tweet.'</p>');
		}

 //print("<pre>".print_r($content,true)."</pre>");
		?>
	</div>








</body>
</html>

