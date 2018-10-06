<?php
  //$pdo = new PDO("mysql:host=mysql2.star.ne.jp; dbname=aikatsu_rtbot;charset=utf8", "aikatsu_rtbot", "password", array(PDO::ATTR_EMULATE_PREPARES => false));
  //$sql = "SELECT * FROM twitter_user where twitter_user_id =".$twitter_user_id;
  //$statement = $pdo->query($sql);
  //var_dump($statement);
  //$members = array();
  //foreach ($statement as $row) {
  //    $members[] = $row;
  //}
  //var_dump(count($members));
  //$statement->closeCursor();

session_start();

function find_or_create($mysqli, $twitter_user_id, $oauth_token, $oauth_token_secret){

  $stmt = $mysqli->prepare ( 'select count(*) from twitter_user where twitter_user_id = ?' );
  if (!$stmt){
    var_dump($mysqli->error);
  }
  $stmt->bind_param('s', $twitter_user_id);
  $stmt->execute();
  $stmt->bind_result($is_exist);
  if($stmt->fetch()){
    return;
  }
  $stmt->close();

  $stmt = $mysqli->prepare("INSERT INTO twitter_user(
      twitter_user_id, oauth_token, oauth_token_secret
    ) VALUES (?, ?, ?)");
  if (!$stmt){
    var_dump($stmt);
    var_dump($mysqli->error);
  }  
  $stmt->bind_param('sss', $twitter_user_id, $oauth_token, $oauth_token_secret);
  $stmt->execute();
  //$result = $stmt->get_result();
}



?>
