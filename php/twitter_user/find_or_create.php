<?php

session_start();

function find_or_create($mysqli, $twitter_user_id, $oauth_token, $oauth_token_secret){
  $stmt = $mysqli->prepare ( 'select * from twitter_user where twitter_user_id = ?' );
  if (!$stmt){
    var_dump($mysqli->error);
  }
  $stmt->bind_param('s', $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows > 0){
    return;
  }

  $stmt = $mysqli->prepare("INSERT INTO twitter_user(
      twitter_user_id, oauth_token, oauth_token_secret
    ) VALUES (?, ?, ?)");
  $stmt->bind_param('sss', $twitter_user_id, $oauth_token, $oauth_token_secret);
  $stmt->execute();
  $result = $stmt->get_result();
}



?>
