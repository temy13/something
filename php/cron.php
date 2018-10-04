<?php

require_once 'common.php';
require_once 'twitteroauth/autoload.php';
require_once 'db.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$stmt = $mysqli->prepare ( 'select * from keywords' );
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  #前提: 10分に一回
  if ($row["timing_type"] == "auto" && auto_retweet_check($row)){
    continue;
  } else if ($row["timing_type"] == "manual" && manual_retweet_check($row)){
    continue;
  }
  retweet($row["twitter_user_id"], $row["keyword"], $row["count"]);
  after_exec($row["id"]);

}


function auto_retweet_check($row){
  $now = new DateTime();
  $interval_sec = new DateTime($row["interval_time"])->getTimestamp();
  $last_exec_dt = new DateTime($row["last_exec"]);
  $diff_sec = ($now->getTimestamp() - $last_exec_dt->getTimestamp());
  return $diff_sec >= $interval_sec;
}


function manual_retweet_check($row){
  $now = new DateTime();
  for ($i=0; $i<24; $i++) {
    if(!$row["manual_time_".$i]){
      continue
    }
    $exec_dt = new DateTime($row["manual_time_".$i]);
    $diff_sec = ($now->getTimestamp() - $exec_dt->getTimestamp());
    #10分に一回前提
    if($diff_sec < 600){
      return true;
    }
  }
  return false;
}


function retweet($twitter_user_id, $keyword, $count){
  $stmt = $mysqli->prepare ( 'select * from twitter_user where twitter_user_id = ?' );
  $stmt->bind_param('s', $twitter_user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $row['oauth_token'], $row['oauth_token_secret']);
  $tweets_params = ['q' => $keyword ,'count' => $count];
  $tweets = $connection->get('search/tweets', $tweets_params)->statuses;
  foreach ($tweets as $tweet) {
    $retweet = $connection->post('statuses/retweet/'.$tweet->id_str);
  }

}

function after_exec($id){
  $stmt = $mysqli->prepare("UPDATE keywords
      SET last_exec = ?
      WHERE id = ?
    ");

    $stmt->bind_param('si', date("Y/m/d H:i:s"), $id);
    if(!$stmt->execute()){
      var_dump($mysqli->error);
    }
    $stmt->close();
    $mysqli->close();
}
