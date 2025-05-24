<?php 

define('E_UNKNOWN',0);
define('E_REGULAR',1);
define('E_PROB',2);
define('E_CONSULTANT',3);
define('E_OJT',4);
define('E_CONTRACTUAL',5);
define('E_TERMINATED',6);
define('E_PROJECT_BASED',7);
define('E_RESIGNED',8);
define('E_END_CONTRACT',9);
define('E_DECEASED',10);
define('E_AWOL',11);
function getEmployementStatus($key = null) {
  $status = [
  	E_REGULAR => "REGULAR",
  	E_PROB => "PROBATIONARY",
  	E_CONSULTANT => "CONSULTANT",
    E_PROJECT_BASED => "PROJECT BASED",
  	E_OJT => "OJT",
    E_CONTRACTUAL => "CONTRACTUAL",
    E_TERMINATED => "TERMINATED",
    E_RESIGNED => "RESIGNED",
    E_END_CONTRACT => "END OF CONTRACT",
    E_DECEASED => "DECEASED",
    E_AWOL => "AWOL"
  ];
  if ($key === null) {
  	return $status;
  }
  return isset($status[$key])?$status[$key]:null;
}
function inactiveEmployeeStatus(){
    return [
        E_END_CONTRACT, E_RESIGNED, E_TERMINATED, E_DECEASED
    ];
}

function formatDateTime($date_time, $show_time = false, $mid_text_between_date_time=null) {
    if (blank($date_time)) {
        return "";
    }
    if ($show_time) {
        if ($mid_text_between_date_time) {
            return date("M d, Y {$mid_text_between_date_time} g:i A", strtotime($date_time));
        }
        return date("M d, Y g:i A", strtotime($date_time));
    }
    //    return \Carbon\Carbon::parse($date_time)->format("F d, Y");
    return date("M d, Y", strtotime($date_time));
}

function formatDateOrDateTime($date_time, $time=null){
    if (!blank($date_time) and !blank($time)) {
        return formatDateTime($date_time." ".$time,true);
    }
    return formatDateTime($date_time);
}

function formatTime($time, $display_if_empty = "") {
    if (blank($time)) {
        return $display_if_empty;
    }
    return date("g:i A", strtotime($time));
}

function toNumber($value, $round=2){
    if (empty($value)) {
        $value = 0;
    }
    return round(floatval(preg_replace('/[ ,]+/', '', $value)), $round);
}

function amount_format($amount, $forcePositive = false, $decimal=2){
    if (blank($amount)) {
        $amount = 0;
    }
    if ($forcePositive===false) {
        return number_format(toNumber($amount), $decimal, ".", ",");
    }
    return number_format(toNumber(abs($amount)), $decimal, ".", ",");
}
//  CONVERT DATE FROM FRONT END TO BACKEND
//
function user_to_system_date($date){
    if ($date) {
        return \Carbon\Carbon::parse($date)->format("Y-m-d");
    }
    return today()->format("Y-m-d");
}

function removeAllSpace(string $string){
    $string = preg_replace('/\s+/', '', $string);
    return trim($string);
}
function removeDoubleSpace($string){
    if (empty($string)) {
        return null;
    }
    return preg_replace('/\s\s+/', ' ', $string);
}

/**
 * Check the two time periods overlap
 *
 * @param $periods
 * @param string $start_time_key
 * @param string $end_time_key
 * @return bool
 */
 function isOverlapped(array $periods, $start_time_key = 'start_time', $end_time_key = 'end_time')
{
    // order periods by start_time
    usort($periods, function ($a, $b) use ($start_time_key, $end_time_key) {
        return strtotime($a[$start_time_key]) <=> strtotime($b[$end_time_key]);
    });
    // check two periods overlap
    foreach ($periods as $key => $period) {
        if ($key != 0) {
            
            if (strtotime($period[$start_time_key]) < strtotime($periods[$key - 1][$end_time_key])) {
                return true;
            }

            if (
                strtotime($period[$start_time_key]) == strtotime($periods[$key - 1][$end_time_key]) 
                and strtotime($period[$end_time_key]) == strtotime($periods[$key - 1][$start_time_key])
            ) {
                return true;
            }
        }
    }
    return false;
}

function numberFormatPrecision($number=0, $precision = 2, $separator = '.')
{
    $numberParts = explode($separator, $number);
    $response = $numberParts[0];
    if (count($numberParts)>1 && $precision > 0) {
        $response .= $separator;
        $response .= substr($numberParts[1], 0, $precision);
    }

    return number_format($response, $precision);
}

function getPreciseNumber($number, $precision = 2, $separator = '.')
{
    $numberParts = explode($separator, $number);
    $response = $numberParts[0];
    if (count($numberParts)>1 && $precision > 0) {
        $response .= $separator;
        $response .= substr($numberParts[1], 0, $precision);
    }
    return $response;
}

function checkIfDateIsInRestDay(string $rest_days, $date){
    $date = \Carbon\Carbon::parse($date)->format('l');
    $allowed_days = explode(',', $rest_days);
    $current_day_selected = substr(strtoupper($date), 0, 3);
    return in_array($current_day_selected, $allowed_days);
}
function formatEmployeeNo($id_no, $digit="6"){
    return sprintf( "%0{$digit}d", $id_no); 
}

function str_slug($string, $slug="_"){
    return \Illuminate\Support\Str::slug(strtolower($string), $slug);
}

function staticPayrollColumns($key =null){
    // db column = "Column Header of front end and import and export to excel payroll register"
    $array =  [
        'night_differential_pay' => "Night Differential Pay",
        'wtax_deduction' => "Tax",
        'ut_deduction' => "Undertime",
        'late_deduction' => "Late",
        'lwop_deduction' => "LWOP",
        'awol_deduction' => "AWOL"
    ];
      return isset($array[$key])?$array[$key]:$array;
}

function maskAmount($value, $return_if_zero="-"){
    if ($value==0) {
        return $return_if_zero;
    }
    return amount_format(getPreciseNumber($value));
}
function maskTime($value, $unit="hrs", $return_if_zero="-", $decimal=2){
    if ($value==0) {
        return $return_if_zero;
    }
    return (amount_format(getPreciseNumber($value), false, $decimal)." ".$unit);
}


define('DT_PERIOD',1);
define('DT_MONTHLY',2);

function getDeductionTypes($key = null){
    $array = [
        DT_PERIOD => "Per Payroll",
        DT_MONTHLY => "Per Month",
    ];
      return isset($array[$key])?$array[$key]:$array;
}

function getTheNthOfText($number){
       $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function getDiffInMinutes($time1,$time2){
    return \Carbon\Carbon::parse($time1)->floatDiffInMinutes($time2,false);
}

function convertDateToMonthDay($date){
    return date('m-d',strtotime($date));
}

function clean($string) {
   $string = str_replace(' ', '', $string); //remove all spaces
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);  //remove all special char
   return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with empty string.
}


function convertStringToFileName($string){
    return preg_replace("([^\w\s\d\.\-_~,;:\[\]\(\)]|[\.]{2,})", '', $string);
}

function getNullifEmpty($value){
    if (toNumber($value)==0) {
        return null;
    }
    return numberFormatPrecision($value);
}