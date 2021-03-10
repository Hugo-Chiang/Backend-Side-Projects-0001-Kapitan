<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type:text/html; charset=utf-8");
// header("Access-Control-Allow-Origin: https://side-projects-01-kapitan.herokuapp.com");
// header('Access-Control-Allow-Methods: GET');

include("../Lib/PDO.php");

$sql = "SELECT * FROM PROJECTS";

$result = $pdo->query($sql);
$data = $result->fetchAll();

print json_encode($data);
