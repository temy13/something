<?php
require_once 'common.php';
$mysqli = new mysqli(DB_HOST , DB_USER , DB_PASS , DB_DATABASE);
if ($mysqli->connect_error) {
    error_log($mysqli->connect_error);
    exit;
}
?>
