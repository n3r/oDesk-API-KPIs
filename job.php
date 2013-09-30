<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require 'oDeskAPI.lib.php';

function convert($earnings){
    $earnings_dollar = round($earnings, 2);
    $earnings_temp = $earnings_dollar - ceil($earnings_dollar / 300) * 3 - 5;
    $earnings_rub = round(($earnings_temp - $earnings_temp * 0.03) * 32);
    return $earnings_rub;
}

$odesk_user = '';
$odesk_pass = '';
$secret     = '';
$api_key    = '';

// Set up variables
// current week
(float)$cw_hours = 0;
(float)$cw_earnings = 0;
// last week
(float)$lw_hours = 0;
(float)$lw_earnings = 0;
// current month
(float)$cm_hours = 0;
(float)$cm_earnings = 0;
// last month
(float)$lm_hours = 0;
(float)$lm_earnings = 0;
// today
(float)$t_hours = 0;
(float)$t_earnings = 0;



$api = new oDeskAPI($secret, $api_key);
$api->option('mode', 'nonweb');

if (!isset($_SESSION['saved_token_id'])) {
    $token = $api->auth($odesk_user, $odesk_pass);
    $_SESSION['saved_token_id'] = $token;
} else {
    $api->option('api_token', $_SESSION['saved_token_id']);
}

// Get user infomation
$url = 'https://www.odesk.com/api/hr/v2/users/me.json';
$response = $api->get_request($url, array());
$info = json_decode($response);

// GET THIS MONTH EARNINGS
$from = date('Y-m-01',strtotime('this month'));
$to = date('Y-m-t',strtotime('this month'));

$params = array(
    'tq' => "SELECT worked_on, assignment_team_id, hours, earnings, earnings_offline, task, memo WHERE worked_on >= '".$from."' AND worked_on <= '".$to."'",
    'tqx' => 'out:json'
);

$url = "https://www.odesk.com/gds/timereports/v1/providers/".$info->user->id;
$response = $api->get_request($url, $params);
$cm = $data = json_decode($response);

$result = array();
foreach ($data->table->rows as $row){
    $cm_hours += $row->c[2]->v;
    $cm_earnings += $row->c[3]->v;
    $day = (int)substr($row->c[0]->v, -2);
    if (empty($result[$day])){
        $result[$day] = array(
            "hours" => $row->c[2]->v,
            "earnings" => $row->c[3]->v
        );
    }else{
        $result[$day]["hours"] += $row->c[2]->v;
        $result[$day]["earnings"] += $row->c[3]->v;
    }
    
    if ($row->c[1]->v == "textmagic:phpsql"){
        $result[$day]['tm_hours'] += $row->c[2]->v;
    }
    if ($row->c[1]->v == "bettybaxter"){
        $result[$day]['bb_hours'] += $row->c[2]->v;
    }

}
ksort($result);
// This week earnings:
$start = date("j", strtotime("2013-W".date("W")."-1"));
$end = date("j", strtotime("2013-W".date("W")."-7"));
for ($i=$start;$i<=$end;$i++){
    if (!empty($result[$i])){
        $cw_earnings += $result[$i]['earnings'];
        $cw_hours += $result[$i]['hours'];
    }
}
$cw_earnings_rub = convert($cw_earnings);

// Last week earnings
$start = date("j", strtotime("-1 week", strtotime("2013-W".date("W")."-1")));
$end = date("j", strtotime("-1 week", strtotime("2013-W".date("W")."-7")));
for ($i=$start;$i<=$end;$i++){
    if (isset($result[$i])){
        $lw_earnings += $result[$i]['earnings'];
        $lw_hours += $result[$i]['hours'];
    }
}
$lw_earnings_rub = convert($lw_earnings);


// Today's earnings
$t_earnings_rub = convert($result[date('d')]['earnings']);
$t_hours = $result[date('d')]['hours'];

// Current month earnings
$cm_earnings_rub = convert($cm_earnings);

// HOURS LEFT:
$hours_left = (strtotime("2013-W".date("W")."-7")+86400-time())/(3600);
?>