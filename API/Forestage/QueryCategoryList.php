<?php

// 設定 CORS 權限
header("Access-Control-Allow-Origin: http://localhost:8080/");
// header("Access-Control-Allow-Origin: https://fe-sp-0001-kapitan.herokuapp.com");
header('Access-Control-Allow-Methods: GET');
header("Content-Type:text/html; charset=utf-8");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 執行：
$sql_query_category = "SELECT * FROM category";
$response_query_category = $pdo->query($sql_query_category);
$result_query_category = $response_query_category->fetchAll(PDO::FETCH_ASSOC);

print json_encode($result_query_category);
