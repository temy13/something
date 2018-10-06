<?php

require_once 'common.php';
require_once 'twitteroauth/autoload.php';
require_once 'db.php';
require_once 'retweet.php'

use Abraham\TwitterOAuth\TwitterOAuth;

//$stmt = $mysqli->prepare ( 'select * from keywords' );
//$stmt->execute();
//$result = $stmt->get_result();

$query = 'select * from keywords';
$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {
  //前提: 10分に一回
  if ($row["timing_type"] == "auto" && auto_retweet_check($row)){
    continue;
  } else if ($row["timing_type"] == "manual" && manual_retweet_check($row)){
    continue;
  }
  retweet($mysqli, $row["twitter_user_id"], $row["keyword"], $row["count"],$row["id"]);

}

$mysqli->close();

function auto_retweet_check($row){
  $now = new DateTime();
  $interval = new DateTime($row["interval_time"]);
  $interval_sec = $interval->getTimestamp();
  $last_exec_dt = new DateTime($row["last_exec"]);
  $diff_sec = ($now->getTimestamp() - $last_exec_dt->getTimestamp());
  return $diff_sec >= $interval_sec;
}


function manual_retweet_check($row){
  $now = new DateTime();
  for ($i=0; $i<24; $i++) {
    if(!$row["manual_time_".$i]){
      continue;
    }
    $exec_dt = new DateTime($row["manual_time_".$i]);
    var_dump($now);
    var_dump($exec_dt);
    $diff_sec = ($now->getTimestamp() - $exec_dt->getTimestamp());
    var_dump($diff_sec);
    #10分に一回前提
    if(0<= $diff_sec && $diff_sec <= 600){
      return true;
    }
  }
  return false;
}
