<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type:text/html; charset=utf-8");
// header("Access-Control-Allow-Origin: https://side-projects-01-kapitan.herokuapp.com");
// header('Access-Control-Allow-Methods: GET');

include("../../Lib/PDO.php");

$sql = "SELECT PROJECT_ID,PROJECT_NAME,PROJECT_SUMMARY,PROJECT_ORIGINAL_PRICE_PER_PERSON FROM projects";

$result = $pdo->query($sql);
$data = $result->fetchAll();

print json_encode($data);
