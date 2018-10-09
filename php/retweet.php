<?php

require_once 'common.php';
require_once 'twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;


function retweet($mysqli, $twitter_user_id, $keyword, $count, $id, $log=False){
  retweet_exec($mysqli, $twitter_user_id, $keyword, $count,$log);
  after_exec($mysqli, $id);
}


function retweet_exec($mysqli, $twitter_user_id, $keyword, $count,$log){

  $query = 'select * from twitter_user where twitter_user_id = '.$twitter_user_id;
  $result = $mysqli->query($query);
  $tw_row = $result->fetch_assoc();

  if (!$tw_row["allowed"]){
    return;
  }
  $ck = $tw_row["consumer_key"] ? $tw_row["consumer_key"] : CONSUMER_KEY;
  $cs = $tw_row["consumer_secret"] ? $tw_row["consumer_secret"] : CONSUMER_SECRET;
  $at = $tw_row["access_token"] ? $tw_row["access_token"] : $tw_row["oauth_token"];
  $as = $tw_row["access_token_secret"] ? $tw_row["access_token_secret"] : $tw_row["oauth_token_secret"];

  if($log){ var_dump($tw_row["screen_name"]); }
  $retweets = [];
  $query = 'select * from retweeted where twitter_user_id = '.$twitter_user_id;
  $result = $mysqli->query($query);
  while ($row = $result->fetch_assoc()) {
    $retweets[] = $row["tweet_id"];
  }
  // if($log){ var_dump($ck);var_dump($cs); var_dump($at);var_dump($as);}

  $connection = new TwitterOAuth($ck, $cs, $at, $as);
  // if($log){ var_dump($connection); }
  // if($log){ var_dump($oauth_token);var_dump($oauth_token_secret);var_dump($connection); }
  $res = $connection->get('blocks/ids');
  $block_ids = $res->ids;
  if(!$block_ids){
    if($log){ var_dump($res); }
    return;
    // if($log){ var_dump($block_ids); }
  }
  $c = 10;
  $tweet_id="";
  $now = new DateTime();
  while($count > 0 && $c > 0){
    $c -= 1;
    $tweets_params = ['q' => $keyword ,'count' => 100, 'max_id' => $tweet_id, 'result_type' => 'recent'];
    $tweets = $connection->get('search/tweets', $tweets_params)->statuses;
    foreach ($tweets as $tweet) {
      $tweet_id = $tweet->id_str;
      // if($log){ var_dump($tweet->user->id); var_dump($tweet_id); }
      if(in_array($tweet_id, $retweets)){
        continue;
      }
      if(in_array($tweet->user->id, $block_ids)){
        continue;
      }
      $t= new DateTime(date('Y-m-d H:i:s', strtotime($tweet->created_at)));
      $h = ($now->getTimestamp() - $t->getTimestamp()) / 3600;
      if($h > 23){
        continue;
      }
      $retweet = $connection->post('statuses/retweet/'.$tweet_id);
      $count-=1;
      insert_retweeted($mysqli, $twitter_user_id, $tweet_id);
      // if($log){ var_dump($count); }

      if($count<=0){
        return;
      }

    }
  }
}


function after_exec($mysqli, $id){
  $stmt = $mysqli->prepare("UPDATE keywords
      SET last_exec = ?
      WHERE id = ?
    ");
  $s = date("Y/m/d H:i:s")
  $stmt->bind_param('si', $s, intval($id));
  if(!$stmt->execute()){
    var_dump($mysqli->error);
  }
  $stmt->close();

}

function insert_retweeted($mysqli, $twitter_user_id, $tweet_id){
  $stmt = $mysqli->prepare("
    INSERT INTO retweeted(twitter_user_id, tweet_id)
    VALUES (?, ?)
  ");
  if(!$stmt){
    var_dump($mysqli->error);
  }
  $stmt->bind_param('ss', $twitter_user_id, $tweet_id);
  $res = $stmt->execute();
  $stmt->close();

}


 ?>
