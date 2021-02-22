<?php

$my_env_var = getenv('MY_VAR');

$db_host = getenv('servername');
$db_user = getenv('username');
$db_pass = getenv('password');
$db_select = getenv('dbname');

echo $db_host;
echo $db_user;
echo $db_pass;
echo $db_select;

$dsn = "mysql:host=" . $db_host.";dbname=" . $db_select;

$pdo = new PDO($dsn, $db_user, $db_pass);

return $pdo;

?>