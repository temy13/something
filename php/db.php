<?php
$mysqli = new mysqli("127.0.0.1" , "rtbotuser" , "password" , "rtbotdb");
if ($mysqli->connect_error) {
    error_log($mysqli->connect_error);
    exit;
}
?>
