<?php

session_start();

require_once '../common.php';
require_once '../db.php';

$stmt = $mysqli->prepare("INSERT INTO keywords(
    twitter_user_id, keyword, count, timing_type, interval_time,
    manual_time_0,manual_time_1,manual_time_2,manual_time_3,manual_time_4,manual_time_5,manual_time_6,
    manual_time_7,manual_time_8,manual_time_9,manual_time_10,manual_time_11,manual_time_12,
    manual_time_13,manual_time_14,manual_time_15,manual_time_16,manual_time_17,manual_time_18,
    manual_time_19,manual_time_20,manual_time_21,manual_time_22,manual_time_23, last_exec
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?, ?, ?, ? ,?, ?, ?, ?, ?, ? ,?, ?, ?, ?, ?, ?, ? )");

$twitter_user_id = $_GET['twitter_user_id'];
$keyword = $_GET['keyword'];
$count = intval($_GET['count']);
$timing_type = $_GET['timing_type'];
$interval_time= $_GET['interval_time'] != "" ? $_GET['interval_time'] : NULL;
$mt = $_GET['manual_time'];
foreach ($mt as $id => $t) {
  if ($t == ""){
    $mt[$id] = null;
  }
}

$stmt->bind_param('ssissssssssssssssssssssssssss', $user_id, $keyword, $count, $timing_type, $interval_time, $mt[0],
    $mt[1], $mt[2], $mt[3], $mt[4], $mt[5], $mt[6], $mt[7], $mt[8], $mt[9], $mt[10],
    $mt[11], $mt[12], $mt[13], $mt[14], $mt[15], $mt[16], $mt[17], $mt[18], $mt[19], $mt[20],
    $mt[21], $mt[22], $mt[23], date("Y/m/d H:i:s")
);
$stmt->close();
$mysqli->close();

header('Location: '.HOST.'/mypage.php');
exit();

?>