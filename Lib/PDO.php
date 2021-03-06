<?php

$db_host = getenv('host');
$db_user = getenv('username');
$db_pass = getenv('password');
$db_select = getenv('database');

$dsn = "mysql:host=" . $db_host . ";dbname=" . $db_select;
$opts_values = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => 2, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

$pdo = new PDO($dsn, $db_user, $db_pass, $opts_values);
