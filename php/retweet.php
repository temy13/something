<?php

require_once 'common.php';
require_once 'twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;


function retweet($mysqli, $twitter_user_id, $keyword, $count, $id, $log=False){
  retweet_exec($mysqli, $twitter_user_id, $keyword, $count,$log);
  after_exec($mysqli, $id);
}


function retweet_exec($mysqli, $twitter_user_id, $keyword, $count,$log){
  $stmt = $mysqli->prepare ( 'select allowed, screen_name, oauth_token, oauth_token_secret from twitter_user where twitter_user_id = ?' );
  if(!$stmt){
    var_dump($mysqli->error);
  }
  $stmt->bind_param('s', $twitter_user_id);
  $stmt->execute();
  //$result = $stmt->get_result();
  //$row = $result->fetch_assoc();
  $stmt->store_result();
  $stmt->bind_result($allowed,$screen_name, $oauth_token, $oauth_token_secret);
  $stmt->fetch();
  if (!$allowed){
    return;
  }
  $stmt->close();
  if($log){ var_dump($screen_name); }
  $retweets = [];
  $query = 'select * from retweeted where twitter_user_id = '.$twitter_user_id;
  $result = $mysqli->query($query);
  while ($row = $result->fetch_assoc()) {
    $retweets[] = $row["tweet_id"];
  }

  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);

  if($log){ var_dump($oauth_token);var_dump($oauth_token_secret);var_dump($connection); }
  $block_ids = $connection->get('blocks/ids')->ids;
  if($log){ var_dump($block_ids); }
  $c = 10;
  $tweet_id="";
  while($count > 0 && $c > 0){
    $c -= 1;
    $tweets_params = ['q' => $keyword ,'count' => 100, 'max_id' => $tweet_id];
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

      $retweet = $connection->post('statuses/retweet/'.$tweet_id);
      $count-=1;
      insert_retweeted($mysqli, $twitter_user_id, $tweet_id);
      if($log){ var_dump($count); }

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

  $stmt->bind_param('si', date("Y/m/d H:i:s"), intval($id));
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
