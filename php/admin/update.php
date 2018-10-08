<?php

session_start();

require_once '../db.php';

$stmt = $mysqli->prepare("UPDATE twitter_user
    SET allowed = ?
    WHERE id = ?
  ");
if (!$stmt){
  var_dump($mysqli->error);
}

$id = intval($_GET['id']);
$allowd = $_GET['allowed'] == "true" ? 1 : 0;

$stmt->bind_param('ii', $allowed, $id);
$res = $stmt->execute();
if(!$res){
  var_dump($mysqli->error);
}
$stmt->close();
$mysqli->close();


header('Location: '.HOST.'/mypage/index.php');
exit();

?>
