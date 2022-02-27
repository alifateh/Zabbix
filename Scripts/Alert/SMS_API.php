#!/usr/bin/env php
<?php
date_default_timezone_set('Asia/Tehran');
setlocale(LC_ALL, 'C.UTF-8');
mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');
mb_http_output('UTF-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('default_charset', 'utf-8');

require_once dirname(__FILE__) . "/lib/message.class.php";

/* Developed By alifatehchehr@gmail.com */
function logToDB($to, $body, $subject)
{
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare('INSERT INTO sendSMS VALUES(
									:id,
									:sendTo,
									:text_body,
									:send_date
									)');
        $stmt->execute(array(':id' => NULL, ':sendTo' => $to, ':text_body' => $subject . $body, ':send_date' => strftime('%Y-%m-%d %H:%M:%S', strtotime('now'))));
        ///pdo error
    } catch (PDOException $e) {
        $myfile = fopen("/etc/zabbix/alertscripts/sms.log", "w") or die("Unable to open file!");
        $message_2 = date("Y-m-d H:i:s");
        $text = "pdo error" . $e . $message_2;
        fwrite($myfile, $text);
        fclose($myfile);
    }
}

class SMSMagfa
{

    // Magfa SMS Center
    private static  $DOMAIN        = "fanap";
    private static  $USERNAME      = "Telecom-Fanap";
    private static  $PASSWORD      = "cJgOlrPKjiWtQUzI";
    private static  $BASE_HTTP_URL = "https://sms.magfa.com/magfaHttpService?";
    private static  $senderNumber  = "9830009015";

    private $ERROR_MAX_VALUE = 1000;
    private $errors;


    /**
     * method : constructor
     * the constructor method of the class
     * @return void
     */
    public function __construct($to, $msg)
    {
        $errors = [];

        $errors[1]['title'] = 'INVALID_RECIPIENT_NUMBER';
        $errors[1]['desc'] = 'the string you presented as recipient numbers are not valid phone numbers, please check them again';

        $errors[2]['title'] = 'INVALID_SENDER_NUMBER';
        $errors[2]['desc'] = 'the string you presented as sender numbers(3000-xxx) are not valid numbers, please check them again';

        $errors[3]['title'] = 'INVALID_ENCODING';
        $errors[3]['desc'] = 'are You sure You\'ve entered the right encoding for this message? You can try other encodings to bypass this error code';

        $errors[4]['title'] = 'INVALID_MESSAGE_CLASS';
        $errors[4]['desc'] = 'entered MessageClass is not valid. for a normal MClass, leave this entry empty';

        $errors[6]['title'] = 'INVALID_UDH';
        $errors[6]['desc'] = 'entered UDH is invalid. in order to send a simple message, leave this entry empty';

        $errors[12]['title'] = 'INVALID_ACCOUNT_ID';
        $errors[12]['desc'] = 'you\'re trying to use a service from another account??? check your UN/Password/NumberRange again';

        $errors[13]['title'] = 'NULL_MESSAGE';
        $errors[13]['desc'] = 'check the text of your message. it seems to be null';

        $errors[14]['title'] = 'CREDIT_NOT_ENOUGH';
        $errors[14]['desc'] = 'Your credit\'s not enough to send this message. you might want to buy some credit.call';

        $errors[15]['title'] = 'SERVER_ERROR';
        $errors[15]['desc'] = 'something bad happened on server side, you might want to call MAGFA Support about this:';

        $errors[16]['title'] = 'ACCOUNT_INACTIVE';
        $errors[16]['desc'] = 'Your account is not active right now, call -- to activate it';

        $errors[17]['title'] = 'ACCOUNT_EXPIRED';
        $errors[17]['desc'] = 'looks like Your account\'s reached its expiration time, call -- for more information';

        $errors[18]['title'] = 'INVALID_USERNAME_PASSWORD_DOMAIN'; // todo : note : one of them are empty
        $errors[18]['desc'] = 'the combination of entered Username/Password/Domain is not valid. check\'em again';

        $errors[19]['title'] = 'AUTHENTICATION_FAILED'; // todo : note : wrong arguments supplied ...
        $errors[19]['desc'] = 'You\'re not entering the correct combination of Username/Password';

        $errors[20]['title'] = 'SERVICE_TYPE_NOT_FOUND';
        $errors[20]['desc'] = 'check the service type you\'re requesting. we don\'t get what service you want to use. your sender number might be wrong, too.';

        $errors[22]['title'] = 'ACCOUNT_SERVICE_NOT_FOUND';
        $errors[22]['desc'] = 'your current number range doesn\'t have the permission to use Webservices';

        $errors[23]['title'] = 'SERVER_BUSY';
        $errors[23]['desc'] = 'Sorry, Server\'s under heavy traffic pressure, try testing another time please';

        $errors[24]['title'] = 'INVALID_MESSAGE_ID';
        $errors[24]['desc'] = 'entered message-id seems to be invalid, are you sure You entered the right thing?';

        $errors[102]['title'] = 'WEB_RECIPIENT_NUMBER_ARRAY_SIZE_NOT_EQUAL_MESSAGE_CLASS_ARRAY';
        $errors[102]['desc'] = 'this happens when you try to define MClasses for your messages. in this case you must define one recipient number for each MClass';

        $errors[103]['title'] = 'WEB_RECIPIENT_NUMBER_ARRAY_SIZE_NOT_EQUAL_SENDER_NUMBER_ARRAY';
        $errors[103]['desc'] = 'This error happens when you have more than one sender-number for message. when you have more than one sender number, for each sender-number you must define a recipient number...';

        $errors[104]['title'] = 'WEB_RECIPIENT_NUMBER_ARRAY_SIZE_NOT_EQUAL_MESSAGE_ARRAY';
        $errors[104]['desc'] = 'this happens when you try to define UDHs for your messages. in this case you must define one recipient number for each udh';

        $errors[106]['title'] = 'WEB_RECIPIENT_NUMBER_ARRAY_IS_NULL';
        $errors[106]['desc'] = 'array of recipient numbers must have at least one member';

        $errors[107]['title'] = 'WEB_RECIPIENT_NUMBER_ARRAY_TOO_LONG';
        $errors[107]['desc'] = 'the maximum number of recipients per message is 90';

        $errors[108]['title'] = 'WEB_SENDER_NUMBER_ARRAY_IS_NULL';
        $errors[108]['desc'] = 'array of sender numbers must have at least one member';

        $errors[109]['title'] = 'WEB_RECIPIENT_NUMBER_ARRAY_SIZE_NOT_EQUAL_ENCODING_ARRAY';
        $errors[109]['desc'] = 'this happens when you try to define encodings for your messages. in this case you must define one recipient number for each Encoding';

        $errors[110]['title'] = 'WEB_RECIPIENT_NUMBER_ARRAY_SIZE_NOT_EQUAL_CHECKING_MESSAGE_IDS__ARRAY';
        $errors[110]['desc'] = 'this happens when you try to define checking-message-ids for your messages. in this case you must define one recipient number for each checking-message-id';

        $errors[-1]['title'] = 'NOT_AVAILABLE';
        $errors[-1]['desc'] = 'The target of report is not available(e.g. no message is associated with entered IDs)';

        $this->errors = $errors;

        $this->to = $to;
        $this->msg = $msg;
    }


    /**
     * method : enqueueSample
     * this method provides a sample usage of "enqueue" service
     * which you can send Mobile Terminating (MT) messages with it
     * @return void
     * @throws Exception
     */
    public function enqueueSample()
    {
        $method = 'enqueue';

        $senderNumber = self::$senderNumber;
        $recipientNumber = $this->to;
        $message = urlencode($this->msg);

        $udh = ""; // [FILL] udh of the message ; (optional)
        // [FILL] coding of the message (optional)
        // if left blank, system will guess the message coding automatically
        $coding = "";

        $checkingMessageId = ""; // [FILL] checking message id (optional)

        // creating the url based on the information above
        $url = self::$BASE_HTTP_URL .
            "service=" . $method .
            "&username=" . self::$USERNAME . "&password=" . urlencode(self::$PASSWORD) . "&domain=" . self::$DOMAIN .
            "&from=" . $senderNumber . "&to=" . $recipientNumber .
            "&message=" . $message . "&coding=" . $coding . "&udh=" . $udh .
            "&chkmessageid=" . $checkingMessageId;

        // sending the request via http call
        $result = $this->call($url);

        // compare the response with the ERROR_MAX_VALUE
        if ($result <= $this->ERROR_MAX_VALUE) {
            throw new Exception("Error Code : $result ; Error Title : " . $this->errors[$result]['title'] . ' {' . $this->errors[$result]['desc'] . '}');
        } else {
            return $result;
        }
    }

    /**
     * method : call
     * this method calls a http url and returns the result
     * it uses curl library inorder to send http request; which means that you should have the php5-curl module installed
     * however, you can use simpler methods such as file_get_contents , etc ...
     * @param String $url the input url
     * @return String       the response
     * @throws Exception
     */
    private function call($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if (curl_error($ch)) {
            throw new Exception('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
        }
        curl_close($ch);

        return $response;
    }
}

$to      = $argv[1];
$subject = $argv[2];
$body    = (string) $argv[3];


if (!isset($to)      || empty($to)) exit(0);
if (!isset($subject) || empty($subject)) exit(0);
if (!isset($body)    || empty($body)) exit(0);

try {
    $magfa = new SMSMagfa($to, $subject);
    if ($result = $magfa->enqueueSample()) {
        $stringData  = "OK:\t";
        $stringData .= $to . ",\t";
        $stringData .= $subject . ",\t";
        $stringData .= "MessageId : " . $result . ",\n";
        logToDB($to, $body . $stringData, $subject);
    } else {
        throw new Exception('Unknown error occurred.');
    }
} catch (Exception $e) {

    var_dump($e->getMessage());

    $stringData  = "Error:\t";
    $stringData .= $to . ",\t";
    $stringData .= $subject . ",\t";
    $stringData .= $e->getMessage() . ",\n";
    logToDB($to, $stringData, $subject);
}
