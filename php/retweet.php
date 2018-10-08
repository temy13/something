<?php

function retweet($mysqli, $twitter_user_id, $keyword, $count, $id){
  retweet_exec($mysqli, $twitter_user_id, $keyword, $count)
  after_exec($mysqli, $id)
}


function retweet_exec($mysqli, $twitter_user_id, $keyword, $count){
  $stmt = $mysqli->prepare ( 'select allowed, oauth_token, oauth_token_secret from twitter_user where twitter_user_id = ?' );
  if(!$stmt){
    var_dump($mysqli->error);
  }
  $stmt->bind_param('s', $twitter_user_id);
  $stmt->execute();
  //$result = $stmt->get_result();
  //$row = $result->fetch_assoc();
  $stmt->store_result();
  $stmt->bind_result($allowed, $oauth_token, $oauth_token_secret);

  $stmt->fetch();
  if (!$allowed){
    return;
  }
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
  $tweets_params = ['q' => $keyword ,'count' => $count];
  $tweets = $connection->get('search/tweets', $tweets_params)->statuses;
  foreach ($tweets as $tweet) {
    $retweet = $connection->post('statuses/retweet/'.$tweet->id_str);
  }
  $stmt->close();
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



 ?>
