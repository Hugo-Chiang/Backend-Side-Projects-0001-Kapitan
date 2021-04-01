<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$order_id = file_get_contents("php://input");

// 執行：根據關鍵詞查詢相關訂單
$sql_query_order_data = 'SELECT * FROM orders WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0';

$statement_query_order_data = $pdo->prepare($sql_query_order_data);
$statement_query_order_data->bindParam(1, $order_id);
$statement_query_order_data->execute();

$query_result = $statement_query_order_data->fetch(PDO::FETCH_ASSOC);

print json_encode($query_result);
