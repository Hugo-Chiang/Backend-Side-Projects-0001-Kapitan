<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

foreach ($json_data as $properity => $value) {
    $json_data->$properity = '%' . $value . '%';
}

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
ORDER_ID like ? && ORDER_DATE like ? && MEMBER_ACCOUNT like ? && 
ORDER_MC_NAME like ? && ORDER_MC_PHONE like ? && ORDER_MC_EMAIL like ? && t2.ORDER_VISIBLE_ON_WEB != 0';

$statement_query_orders = $pdo->prepare($sql_query_orders);
$statement_query_orders->bindParam(1, $json_data->orderID);
$statement_query_orders->bindParam(2, $json_data->orderDate);
$statement_query_orders->bindParam(3, $json_data->memberAccount);
$statement_query_orders->bindParam(4, $json_data->ordererName);
$statement_query_orders->bindParam(5, $json_data->ordererPhone);
$statement_query_orders->bindParam(6, $json_data->ordererEmail);
$statement_query_orders->execute();

$query_result = $statement_query_orders->fetchAll(PDO::FETCH_ASSOC);

if ($query_result == null) {
    $query_result = (array)[];
}

print json_encode($query_result);
