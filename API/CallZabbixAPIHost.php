<?php
function callHosts()
{

	$url = 'http://monitoring.fanaptelecom.ir/api_jsonrpc.php';
	$ch = curl_init($url);

	// First create API token for Authentication

	$data = array("jsonrpc" => "2.0", "method" => "user.login", "params" => array("user" => "api", "password" => "api"), "auth" => null, "id" => 0);
	$payload = json_encode($data);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	# Return response instead of printing.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	# Send request.
	$result = curl_exec($ch);

	$x = json_decode($result, false);

	echo "<h1> Authentication API Token = " . $x->result . "</h1><br />";

	$data = array("jsonrpc" => "2.0", "method" => "host.get", "params" => array("output" => ["hostid", "host", "name"], "selectInterfaces" => ["ip"]), "auth" => $x, "id" => 0);
	$payload = json_encode($data);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	# Return response instead of printing.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	# Send request.
	curl_close($ch);
	return curl_exec($ch);
}

$y = callHosts(); // Get All Host in zabbix Host Group

$z = json_decode($y, true);

//print_r($z);

for ($i = 0; $i <= count($z['result']); $i++) {
	foreach ($z['result'][$i] as $c => $a) {
		echo "<br />";
		echo "<p>$c => $a</p>";
	}

	
}
