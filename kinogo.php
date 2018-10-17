<?php
//Kinogo.cc films url parser

if(isset($_POST['url'])) {

$url = $_POST['url'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

preg_match_all("/Base64\.decode\(\'(.+)\'\)/", $server_output, $get_base64);
$data = base64_decode($get_base64[1][0]);
preg_match_all("/\;file\=(.+)\&/", $data, $result);
echo $result[1][0];

} else {
	echo "Please, provide url";
}


?>

<form action="_test.php" method="post">
	<input type="text" name="url" value="" placeholder="input url here..." />
	<input type="submit" name="submit" value="GET!" />
</form>
