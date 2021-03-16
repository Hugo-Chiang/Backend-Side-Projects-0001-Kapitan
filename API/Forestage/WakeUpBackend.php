<?php

header("Access-Control-Allow-Origin: http://localhost:8080");
// header("Access-Control-Allow-Origin: https://fe-sp-0001-kapitan.herokuapp.com");
header('Access-Control-Allow-Methods: GET');
header("Content-Type:text/html; charset=utf-8");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

$sql_query = 'SELECT ADMIN_NAME FROM admin WHERE ADMIN_ID = "AD0001"';
$result = $pdo->query($sql_query);
$data = $result->fetch(PDO::FETCH_ASSOC);

echo $data['ADMIN_NAME'] . '是這個網站的作者～';