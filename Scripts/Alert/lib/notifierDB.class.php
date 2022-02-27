<?php

require_once dirname(__FILE__)."/dateUtils.class.php";

class notifierDB
{
    var $host = 'localhost';
    var $username = 'root';
    var $password = 'zabbix@!';
    var $database = 'notifier';

    private static $LOG_FILE = "PDOErrors.log";

    function __construct()
    {
        try{
            $this->db = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->username, $this->password);
            $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch(PDOException $e) {
            //$this->log("ERROR: ". $e->getMessage() .", ");
            file_put_contents(self::$LOG_FILE, $e->getMessage(), FILE_APPEND);

            throw new Exception($e->getMessage());
        }
    }

    public function insSMS ($to, $subject, $body)
    {
        try{
            $sql = "
                    INSERT INTO `out_sms` (
                    `id` ,
                    `input_date` ,
                    `to` ,
                    `subject` ,
                    `content`
                    )
                    VALUES (
                    NULL ,
                    CURRENT_TIMESTAMP , ?, ?, ?
                )";

            $result = $this->db->prepare($sql);
            $result->execute(array(
                $to,
                $subject,
                $body
            ));

            $lastId = $this->db->lastInsertId();
        }
        catch(PDOException $e) {
            //$this->log("ERROR: ". $e->getMessage() .", ");
            throw new Exception($e->getMessage());
        }

        return $lastId;
    }

    public function getSMSList($sent_bit = 0)
    {
        try{
            $sql = "SELECT * FROM out_sms WHERE sent_bit=?";

            $result = $this->db->prepare($sql);
            $result->execute(array(
                $sent_bit,
            ));

            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            //$this->log("ERROR: ". $e->getMessage() .", ");
            throw new Exception($e->getMessage());
        }
    }

    public function setSMSSentBit ($sms)
    {
        try{
            $sql = "UPDATE out_sms SET
                    sent_bit=?
                    WHERE id=?";

            $result = $this->db->prepare($sql);
            $result->execute(array(
                1,
                $sms['id'],
            ));

            $affected_rows = $result->rowCount();
        }
        catch(PDOException $e) {
            //$this->log("ERROR: ". $e->getMessage() .", ");
            throw new Exception($e->getMessage());
        }

        return $affected_rows;
    }

    private function log($str_output = null)
    {
        $dateUtils = new dateUtils();
        $myFile = dirname(__FILE__) . "/" . self::$LOG_FILE;

        if (empty($str_output) || is_null($str_output) ){
            $str_output = $this->str_output;
        }

        $fh = fopen($myFile, 'a+');

        $outputStr  = "[". $dateUtils->date_get_request_time()  ."],\t";
        $outputStr .= $str_output . "";
        $outputStr .= "\n";

        fwrite($fh, $outputStr);
        fclose($fh);
    }

}

