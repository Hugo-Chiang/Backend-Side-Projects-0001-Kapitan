<?php

// 導入並設定 CORS 權限
$allow_methods = 'GET';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 執行：
$sql_query_departure_location = "SELECT * FROM departure_location WHERE LOCATION_VISIBLE_ON_WEB != 0";
$response_query_departure_location = $pdo->query($sql_query_departure_location);
$result_query_departure_location = $response_query_departure_location->fetchAll(PDO::FETCH_ASSOC);

print json_encode($result_query_departure_location);
