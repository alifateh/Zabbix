<?php

class dateUtils
{
    private $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    private $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

    public function date_my_format ($a_timestamp, $a_only_date = false)
    {
        if ($a_only_date) {
            $f = '%Y-%m-%d';
        }
        else {
            $f = '%Y-%m-%d %H:%M:%S';
        }
        return strftime($f, $a_timestamp);
    }

    private function date_format_jalali ($a_date = null)
    {
        $j = $this->date_jalali_get_year_month_day ($a_date);
        return sprintf ("%04d/%02d/%02d", $j[0], $j[1], $j[2]);
    }

    private function date_jalali_get_year_month_day ($a_date = null)
    {
        if ($a_date === null) { $a_date = $this->date_get_request_time(); }

        $dd = $this->datedict_from_str($a_date);
        $j  = $this->date_gregorian_to_jalali ($dd['year'], $dd['mon'], $dd['mday']);

        return array($j[0], $j[1], $j[2]);
    }

    private function datedict_from_str ($a_str)
    {
        return getdate(strtotime($a_str));
    }

    private function date_gregorian_set_to_formatted ($a_date = null)
    {
        if ($a_date === null) { $a_date = $this->date_get_request_time(); }

        $f = '%Y-%m-%d';
        return strftime($f, strtotime($a_date));
    }

    public function date_get_now ($a_only_date = false)
    {
        return $this->date_my_format(strtotime('now'), $a_only_date);
    }

    public function date_get_request_time ($a_only_date = false)
    {
        if (isset($_SERVER['REQUEST_TIME'])) {
            return $this->date_my_format($_SERVER['REQUEST_TIME'], $a_only_date);
        }

        else {
            return $this->date_my_format(strtotime('now'), $a_only_date);
        }
    }

    public function date_get_by_info ($date_info, $a_date = null)
    {
        switch ($date_info[0]) {
            case 'MIN':
            case 'HOUR':
            case 'DAY':
            case 'MONTH':
            case 'YEAR':
                return $this->date_add ($date_info[0], $date_info[1], $a_date);

            case 'WORK':
                return $this->date_add_work_day ($date_info[1], $a_date);
        }

        return false;
    }

    public function date_add ($a_x, $a_n, $a_date = null)
    {
        if ($a_date === null) { $a_date = $this->date_get_request_time(); }

        if ($a_n >= 0) {
            $s = " +$a_n ".strtolower($a_x);
        }
        else {
            $a_n = -$a_n;
            $s = " -$a_n ".strtolower($a_x);
        }

        return $this->date_my_format(strtotime($a_date . $s));
    }

    public function date_add_day ($a_n, $a_date=null, $a_only_date=false)
    {
        if ($a_date === null) { $a_date = $this->date_get_request_time(); }

        if ($a_n >= 0) {
            $s = " +$a_n Day";
        }
        else {
            $a_n = -$a_n;
            $s = " -$a_n Day";
        }

        return $this->date_my_format(strtotime($a_date . $s), $a_only_date);
    }

    public function date_add_work_day ($a_n, $a_date = null)
    {
        if ($a_date === null) { $a_date = $this->date_get_request_time(); }

        $j = $i = 0;

        while ($i < abs($a_n)) {
            $j++;

            if ($a_n >= 0) {
                $s = "$a_date +$j Day";
            }
            else {
                $s = "$a_date -$j Day";
            }

            if (!$this->date_is_day_off($s)) {
                $i++;
            }
        }

        return $this->date_my_format(strtotime($s));
    }

    public function date_is_day_off ($a_date = null)
    {
        if ($a_date === null) { $a_date = $this->date_get_request_time(); }

        global $WEEKEND_LIST, $HOLIDAYS_LIST;

        $dd = getdate(strtotime(($a_date)));

        return  (isset($WEEKEND_LIST[$dd['wday']])				? $WEEKEND_LIST[$dd['wday']]				: null) ||
        (isset($HOLIDAYS_LIST[$dd['year']][$dd['mon']][$dd['mday']])	? $HOLIDAYS_LIST[$dd['year']][$dd['mon']][$dd['mday']]	: null);
    }

    public function date_set_to_midnight ($a_date = null)
    {
        if ($a_date === null) { $a_date = $this->date_get_request_time(); }

        $dd = $this->datedict_from_str($a_date);
        return $this->date_my_format(mktime (/*hours*/ 0, /*minutes*/ 0, /*seconds*/ 0, $dd['mon'], $dd['mday'], $dd['year']));
    }

    public function date_add_gregorian_month ($a_n, $a_date = null)
    {
        if ($a_date === null) { $a_date = $this->date_get_request_time(); }

        if ($a_n >= 0) {
            $s = " +$a_n Month";
        }
        else {
            $a_n = -$a_n;
            $s = " -$a_n Month";
        }

        return $this->date_my_format(strtotime($a_date . $s));
    }

    public function date_get_formatted_by_calendar ($a_calendar, $a_date = null)
    {
        switch ($a_calendar) {
            case 'GREGORIAN':
                return $this->date_gregorian_set_to_formatted($a_date);

            case 'JALALI':
                return $this->date_format_jalali($a_date);
        }

        return false;
    }

    public function getJalaliToGregorianDate($a_date = null) {
        if ($a_date === null) {
            return $this->date_gregorian_set_to_formatted();
        }

        $jalaliDate = explode("/", $a_date);
        $gregorianDate = $this->date_jalali_to_gregorian($jalaliDate[0], $jalaliDate[1], $jalaliDate[2]);

        return $this->date_gregorian_set_to_formatted($gregorianDate[0] ."-". $gregorianDate[1] ."-". $gregorianDate[2]);
    }

    public function getGregorianToJalaliDate($a_date = null) {
        return $this->date_format_jalali($a_date);
    }

    public function date_gregorian_to_jalali ($g_y, $g_m, $g_d)
    {
        $g_days_in_month = $this->g_days_in_month;
        $j_days_in_month = $this->j_days_in_month;

        $div = create_function('$a,$b','return (int) ($a / $b);');

        $gy = $g_y-1600;
        $gm = $g_m-1;
        $gd = $g_d-1;

        $g_day_no = 365*$gy+$div($gy+3,4)-$div($gy+99,100)+$div($gy+399,400);

        for ($i=0; $i < $gm; ++$i)
            $g_day_no += $g_days_in_month[$i];
        if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
            /* leap and after Feb */
            $g_day_no++;
        $g_day_no += $gd;

        $j_day_no = $g_day_no-79;

        $j_np = $div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
        $j_day_no = $j_day_no % 12053;

        $jy = 979+33*$j_np+4*$div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */

        $j_day_no %= 1461;

        if ($j_day_no >= 366) {
            $jy += $div($j_day_no-1, 365);
            $j_day_no = ($j_day_no-1)%365;
        }

        for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
            $j_day_no -= $j_days_in_month[$i];
        $jm = $i+1;
        $jd = $j_day_no+1;

        return array($jy, $jm, $jd);
    }

    public function date_jalali_to_gregorian ($j_y, $j_m, $j_d)
    {
        $g_days_in_month = $this->g_days_in_month;
        $j_days_in_month = $this->j_days_in_month;

        $div = create_function('$a,$b','return (int) ($a / $b);');

        $jy = $j_y-979;
        $jm = $j_m-1;
        $jd = $j_d-1;

        $j_day_no = 365*$jy + $div($jy, 33)*8 + $div($jy%33+3, 4);
        for ($i=0; $i < $jm; ++$i)
            $j_day_no += $j_days_in_month[$i];

        $j_day_no += $jd;

        $g_day_no = $j_day_no+79;

        $gy = 1600 + 400*$div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        $g_day_no = $g_day_no % 146097;

        $leap = true;
        if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
        {
            $g_day_no--;
            $gy += 100*$div($g_day_no, 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
            $g_day_no = $g_day_no % 36524;

            if ($g_day_no >= 365)
                $g_day_no++;
            else
                $leap = false;
        }

        $gy += 4*$div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
        $g_day_no %= 1461;

        if ($g_day_no >= 366) {
            $leap = false;

            $g_day_no--;
            $gy += $div($g_day_no, 365);
            $g_day_no = $g_day_no % 365;
        }

        for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
            $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
        $gm = $i+1;
        $gd = $g_day_no+1;

        return array($gy, $gm, $gd);
    }
}

