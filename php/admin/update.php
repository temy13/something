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
var_dump($_GET['allowed']);
$allowed = $_GET['allowed'] == "true" ? 1 : 0;
var_dump($allowed);
$stmt->bind_param('ii', $allowed, $id);
$res = $stmt->execute();
if(!$res){
  var_dump($mysqli->error);
}
$stmt->close();
$mysqli->close();


header('Location: '.HOST.'/admin/index.php');
exit();

?>
