<?php

$db_host = getenv('host');
$db_user = getenv('username');
$db_pass = getenv('password');
$db_select = getenv('database');

$dsn = "mysql:host=" . $db_host.";dbname=" . $db_select;

$pdo = new PDO($dsn, $db_user, $db_pass);

$pdo->query(‘set names utf8;’);

return $pdo;

?>