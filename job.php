<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require 'oDeskAPI.lib.php';

function convert($earnings){
	if ($earnings == 0){
		return 0;
	}
    $earnings_dollar = round($earnings, 2);
    $earnings_temp = $earnings_dollar - ceil($earnings_dollar / 300) * 3 - 5;
    $earnings_rub = round(($earnings_temp - $earnings_temp * 0.03) * 32);
	if ($earnings_rub > 0){
		return $earnings_rub;
	}else{
		return 0;
	}
}

$odesk_user = '';
$odesk_pass = '';
$secret     = 'd296e44582e94513';
$api_key    = 'ee045279a6a66b956ccde55f483a924b';

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
// other



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

// дата начала месяца
$from = date('Y-m-01',strtotime('this month'));
// дата конца месяца
$to = date('Y-m-t',strtotime('this month'));

// GET THIS MONTH EARNINGS
$start_week = date("W", strtotime($from)) - 1;
$start = date("Y-m-d", strtotime("2013-W".$start_week."-1"));
$end = date("Y-m-d", strtotime("2013-W".date("W", strtotime($to))."-7"));

$params = array(
    'tq' => "SELECT worked_on, assignment_team_id, hours, earnings, earnings_offline, task, memo WHERE worked_on >= '".$start."' AND worked_on <= '".$end."'",
    'tqx' => 'out:json'
);

$url = "https://www.odesk.com/gds/timereports/v1/providers/".$info->user->id;
$response = $api->get_request($url, $params);
$cm = $data = json_decode($response);

$result = array(
	(int)date("m") => array(
		(int)date("d") => array(
            "hours" => 0,
            "earnings" => 0
		)
	)
);
foreach ($data->table->rows as $row){
    $month = (int)substr($row->c[0]->v, 4, 2);
    $day = (int)substr($row->c[0]->v, -2);
	
	$m = (int)date('m');
	if ($month == $m){
		$cm_hours += $row->c[2]->v;
		$cm_earnings += $row->c[3]->v;
	}
    if (empty($result[$month][$day])){
        $result[$month][$day] = array(
            "hours" => $row->c[2]->v,
            "earnings" => $row->c[3]->v
        );
    }else{
        $result[$month][$day]["hours"] += $row->c[2]->v;
        $result[$month][$day]["earnings"] += $row->c[3]->v;
    }

}
ksort($result);
foreach($result as $m){
	ksort($m);
}

// This week earnings:
$start = (int)strtotime("2013-W".date("W")."-1");
$end = (int)strtotime("2013-W".date("W")."-7");
$k = 86400;
for ($i=$start;$i<=$end;$i=$i+$k){
	$m = (int)date("m", $i);
	$d = (int)date("d", $i);
	
    if (!empty($result[$m][$d])){
        $cw_earnings += $result[$m][$d]['earnings'];
        $cw_hours += $result[$m][$d]['hours'];
    }
}
$cw_earnings_rub = convert($cw_earnings);

// Last week earnings
$start = strtotime(date("Y-m-d", strtotime("-1 week", strtotime("2013-W".date("W")."-1"))));
$end = strtotime(date("Y-m-d", strtotime("-1 week", strtotime("2013-W".date("W")."-7"))));
$k = 86400;
for ($i=$start;$i<=$end;$i=$i+$k){
	$m = (int)date("m", $i);
	$d = (int)date("d", $i);
	
    if (!empty($result[$m][$d])){
        $lw_earnings += $result[$m][$d]['earnings'];
        $lw_hours += $result[$m][$d]['hours'];
    }
}
$lw_earnings_rub = convert($lw_earnings);

// Today's earnings
$t_earnings_rub = convert($result[date("m")][(int)date('d')]['earnings']);
$t_hours = $result[date('m')][(int)date('d')]['hours'];

// Current month earnings
$cm_earnings_rub = convert($cm_earnings);

// HOURS LEFT:
$hours_left = (strtotime("2013-W".date("W")."-7")+86400-time())/(3600);
?>