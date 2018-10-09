<?php

function tw_update($mysqli, $consumer_key, $consumer_secret, $access_token, $access_token_secret, $id){
  $stmt = $mysqli->prepare("UPDATE twitter_user
      SET consumer_key = ?, consumer_secret = ?, access_token = ?, access_token_secret = ?
      WHERE id = ?
    ");
  if (!$stmt){
    var_dump($mysqli->error);
  }
  $stmt->bind_param('ssssi', $consumer_key, $consumer_secret, $access_token, $access_token_secret, intval($id) );
  $res = $stmt->execute();
  if(!$res){
    var_dump($mysqli->error);
  }
  $stmt->close();
}



 ?>
