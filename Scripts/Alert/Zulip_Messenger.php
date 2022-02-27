#!/usr/bin/env php
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('default_charset', 'utf-8');
date_default_timezone_set('Asia/Tehran');

mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');
mb_http_output('UTF-8');

setlocale(LC_ALL, 'C.UTF-8');

function logToDB($to, $body, $subject)
{
    $servername = "192.168.200.125";
    $username = "ZbxUser";
    $password = "Xperi@530";
    $dbname = "sms";

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare('INSERT INTO sendSMS VALUES(
									:id,
									:sendTo,
									:text_body,
									:send_date
									)');
        $stmt->execute(array(':id' => NULL, ':sendTo' => "Result of Calling Zulip : " . $to, ':text_body' => $subject . "<->***<->" . $body, ':send_date' => strftime('%Y-%m-%d %H:%M:%S', strtotime('now'))));
        ///pdo error
    } catch (PDOException $e) {
        $myfile = fopen("/etc/zabbix/alertscripts/sms.log", "w") or die("Unable to open file!");
        $message_2 = date("Y-m-d H:i:s");
        $text = "pdo error" . $e . $message_2;
        fwrite($myfile, $text);
        fclose($myfile);
    }
}

$url = "https://chat.fanaptelecom.ir/api/v1/external/zabbix?api_key=EOMXNjAFzc4zvoECnD8Gbo9Rpydryd9P&stream=zabbix";
$ch = curl_init($url);


$sendto  = $argv[1];
$subject = $argv[2];
$body    = (string) $argv[3];

// $data = array("hostname" => "test", "severity" => "test","status" => "test","item" => "test","trigger" => "test","link" => "test");

$data = array("hostname" => $body, "severity" => " ", "status" => " ", "item" => $subject, "trigger" => $subject, "link" => " ");


$payload = json_encode($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//# Return response instead of printing.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//# Send request.
$result = curl_exec($ch);

//# Print response.

$x = json_decode($result, false);

//echo $x->result;

logToDB($x->result, $body, "Zulip_Messenger");

curl_close($ch);

//for echo on web
//echo $x->result;
/* Developed By alifatehchehr@gmail.com */