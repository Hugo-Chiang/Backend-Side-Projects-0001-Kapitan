<?php

// 導入並設定 CORS 權限
$allow_methods = 'GET';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 執行：
$sql_query_category = "SELECT * FROM category WHERE CATEGORY_VISIBLE_ON_WEB != 0";
$response_query_category = $pdo->query($sql_query_category);
$result_query_category = $response_query_category->fetchAll(PDO::FETCH_ASSOC);

print json_encode($result_query_category);
