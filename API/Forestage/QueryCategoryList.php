<?php

// 設定 CORS 權限
header("Access-Control-Allow-Origin: *");
header("Content-Type:text/html; charset=utf-8");
// header("Access-Control-Allow-Origin: https://side-projects-01-kapitan.herokuapp.com");
// header('Access-Control-Allow-Methods: GET');

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 執行：
$sql_query_category = "SELECT * FROM category";
$response_query_category = $pdo->query($sql_query_category);
$result_query_category = $response_query_category->fetchAll(PDO::FETCH_ASSOC);

print json_encode($result_query_category);
