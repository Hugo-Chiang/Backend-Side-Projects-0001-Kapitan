<?php

// 設定 CORS 權限
header("Access-Control-Allow-Origin: http://localhost:8080/");
// header("Access-Control-Allow-Origin: https://fe-sp-0001-kapitan.herokuapp.com");
header('Access-Control-Allow-Methods: POST');
header("Content-Type:text/html; charset=utf-8");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$order_id = file_get_contents("php://input");

// 執行：
$sql_query_orders = 'SELECT * FROM
(SELECT * FROM
(SELECT * FROM
(SELECT * FROM orders as od
JOIN order_details as odd
ON od.ORDER_ID = odd.FK_ORDER_ID_for_ODD) as t1
JOIN booking as bk
ON bk.FK_ORDER_DETAIL_ID_for_BK = t1.ORDER_DETAIL_ID) as t2
JOIN projects as pj
ON pj.PROJECT_ID = t2.FK_PROJECT_ID_for_BK) as t3
JOIN members as mb
ON t3.FK_MEMBER_ID_for_OD = mb.MEMBER_ID
WHERE
ORDER_ID = ?';

$statement_query_orders = $pdo->prepare($sql_query_orders);
$statement_query_orders->bindParam(1, $order_id);
$statement_query_orders->execute();

$query_result = $statement_query_orders->fetchAll(PDO::FETCH_ASSOC);

print json_encode($query_result);
