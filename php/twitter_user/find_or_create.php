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

function find_or_create($mysqli, $twitter_user_id, $oauth_token, $oauth_token_secret, $screen_name){

  $query = 'select * from twitter_user where twitter_user_id = '.$twitter_user_id;
  $result = $mysqli->query($query);
  $row = $result->fetch_assoc();
  if($row){
    return $row;
  }

  $stmt = $mysqli->prepare("INSERT INTO twitter_user(
      screen_name, twitter_user_id, oauth_token, oauth_token_secret
    ) VALUES (?, ?, ?, ?)");
  if (!$stmt){
    var_dump($stmt);
    var_dump($mysqli->error);
  }
  $stmt->bind_param('ssss', $screen_name, $twitter_user_id, $oauth_token, $oauth_token_secret);
  $stmt->execute();
  //$result = $stmt->get_result();

  $query = 'select * from twitter_user where twitter_user_id = '.$twitter_user_id;
  $result = $mysqli->query($query);
  $row = $result->fetch_assoc();
  return $row;

}



?>
