<?php


// require_once 'common.php';
// require_once 'db.php';

function select($mysqli, $twitter_user_id){
  $query = 'select * from keywords where twitter_user_id = '.$twitter_user_id;
  $result = $mysqli->query($query);
  $row = $result->fetch_assoc();
  return $row;
}
