<?php
$con = new PDO('mysql:dbname=id1332318_server;host=localhost;charset=utf8', 'id1332318_server', 'progetto');

$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>