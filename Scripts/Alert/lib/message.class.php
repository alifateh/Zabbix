<?php
require_once dirname(__FILE__) . "/dateUtils.class.php";


class message
{
    private static $DOWN_TEXT   = "قطع گردید.";
    private static $UP_TEXT = "وصل شد.";

    private static $EMGOJI_MAP = [
        "ok"=> "✅",
        "problem"=> "❗",
        "info"=> "ℹ️",
        "warning"=> "⚠️",
        "disaster"=> "❌",
        //"bomb"=> "💣",
        //"fire" => "🔥",
    ];

    private static $DESC = array(
        'origin_co' =>'Origin Company',
        'location'  =>'Location',
        'POPSiteID'  =>'POP Site ID',
        'POPSiteName'  =>'POP Site Name',
        'Point'  => 'Point',
    );

    function __construct($subject, $body)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->date = new dateUtils();
    }

    public function getMSG()
    {
        $subject = $this->subject;
        $body    = $this->body;

        #if(strripos($subject, "ArvanCloud") !== false){
        #    exit(0);
        #}

        if(preg_match('/^(OK): (.*)/i', $subject, $matches)){
            $MSG_TYPE = "ok";
        }
        elseif(preg_match('/^(PROBLEM): (.*)/i', $subject, $matches)){
            $MSG_TYPE = "problem";
        }
        else {
            if (preg_match('/(.*)(is Up)/i', $subject)) {
                $MSG_TYPE = "ok";
            } elseif (preg_match('/(.*)(is Down)/i', $subject)) {
                $MSG_TYPE = "problem";
            }
        }


        if (mb_detect_encoding($subject, "auto") == 'UTF-8') {

            if(preg_match('/(.*)(is Up)/i', $subject, $matches)){
                list($sbj, $ip) = explode("__", trim($matches[1]));
                $subject = $sbj . " " .  self::$UP_TEXT;
            }
            elseif(preg_match('/(.*)(is Down)/i', $subject, $matches)){
                list($sbj, $ip) = explode("__", trim($matches[1]));
                $subject = $sbj . " " .  self::$DOWN_TEXT;
            }

        }


        $line_arr = explode("\n", $body);
        $body ="";
        foreach ($line_arr as $l){

            if (strlen(trim($l)) == 0) {
                continue;
            }

            if(preg_match('/^(Date): ([0-9]{4}\.(0[1-9]|1[0-2])\.(0[1-9]|[1-2][0-9]|3[0-1]))/', $l, $matches)){
                list($Y, $m, $d) = explode(".", $matches[2]);
                $RecoveryDate = $Y."-".$m."-".$d;

                $l = $matches[0] ."\n";
                $l .= "JalaliDate: " . $this->date->getGregorianToJalaliDate(strftime('%Y-%m-%d', strtotime($Y."-".$m."-".$d))) ." \n";
                $body .=$l ."";
                continue;
            }

            if(preg_match('/^(Time): (([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9]))/', $l, $matches)){
                $RecoveryTime = $matches[2];
            }

            if(preg_match('/^(EventDate): ([0-9]{4}\.(0[1-9]|1[0-2])\.(0[1-9]|[1-2][0-9]|3[0-1]))/', $l, $matches)){
                list($Y, $m, $d) = explode(".", $matches[2]);
                $EventDate = $Y."-".$m."-".$d;

                $l = '';
                $body .=$l ."";
                continue;
            }

            if(preg_match('/^(EventTime): (([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9]))/', $l, $matches)){
                $EventTime = $matches[2];

                $l = '';
                $body .=$l ."";
                continue;
            }

            if (is_object($desc = json_decode($l))){
                $l = '';
                foreach($desc as $k=>$v){
                    //if($k == 'origin_co') continue;
                    $l .= self::$DESC[$k]. ": ".$v . "\n";
                }

                $body .=$l ."\n";
                continue;
            }

            $body .=$l ."\n";
        }

        if(isset($EventDate) && isset($EventTime) && !empty($EventDate) && !empty($EventTime)) {
            $time1 = new DateTime($EventDate . " " . $EventTime); // string date
            $time2 = new DateTime($RecoveryDate . " " . $RecoveryTime);
            $interval = $time2->diff($time1);
            //echo $interval->format("%a days %H hours %i minutes %s seconds");
            $interval = $interval->format("%a days %H hours %i minutes");

            $interval = preg_replace('/0\sdays/i', '', $interval);
            $interval = preg_replace('/00\shours/i', '', $interval);

            $body .= "\n".self::$EMGOJI_MAP['info']."Duration: " . $interval . " \n";
        }

        if($MSG_TYPE == 'ok'){
            $sbjHeader = self::$EMGOJI_MAP['ok'].self::$EMGOJI_MAP['ok'].self::$EMGOJI_MAP['ok'].self::$EMGOJI_MAP['ok'].self::$EMGOJI_MAP['ok'];
            $xSubject = $sbjHeader."\n".$subject."\n";
        }
        elseif($MSG_TYPE == 'problem'){
            $sbjHeader = self::$EMGOJI_MAP['problem'].self::$EMGOJI_MAP['problem'].self::$EMGOJI_MAP['problem'].self::$EMGOJI_MAP['problem'].self::$EMGOJI_MAP['problem'];
            $xSubject = $sbjHeader."\n".$subject."\n";
        }

        $body = trim($xSubject) ."\n". trim($body);

        return array($this->subject = $subject, $this->body = $body);
    }

    public function convertToHtml($body)
    {
        $line_arr = explode("\n", $body);
        $body ="";
        foreach ($line_arr as $l){

            if (preg_match('/^([^:]+):\s*(.*)$/u', $l, $matches)) {
                $l = '<b>' . $matches[1] . ' :</b> &nbsp;&nbsp;' . $matches[2];
            }

            $l = preg_replace('/'.self::$EMGOJI_MAP['problem'].'/iu','<span style="color:#ff0000">'.self::$EMGOJI_MAP['problem'].'</span>',$l);
            $l = preg_replace('/'.self::$EMGOJI_MAP['ok'].'/iu','<b style="color:#1BD341">'.self::$EMGOJI_MAP['ok'].'</b>',$l);
            $l = preg_replace('/'.self::$EMGOJI_MAP['info'].'/iu','<b style="color:#0907D1">'.self::$EMGOJI_MAP['info'].'</b>&nbsp;&nbsp;&nbsp;',$l);

            $body .=$l ."\n";
        }

        $body = str_replace("\n","<br>", $body);

        $msg = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body style="direction:ltr;">';
        $msg .= $body ;
        $msg .= '</body></html>';

        return $msg;
    }

}
