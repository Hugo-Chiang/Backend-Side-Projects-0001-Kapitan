<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

// 執行：根據前端送來的會員編號，回傳其近 90 天的所有非刪除訂單
$sql_query_order_details = 'SELECT * FROM
(SELECT * FROM 
(SELECT * FROM 
(SELECT * FROM 
(SELECT * FROM 
orders as od JOIN order_details as odd
ON od.ORDER_ID = odd.FK_ORDER_ID_for_ODD) as t1
JOIN booking as bk 
ON bk.FK_ORDER_DETAIL_ID_for_BK = t1.ORDER_DETAIL_ID) as t2
JOIN projects as pj
ON pj.PROJECT_ID = t2.FK_PROJECT_ID_for_BK) as t3
JOIN departure_location as dl 
ON dl.LOCATION_ID = t3.FK_LOCATION_ID_for_PJ) as t4
JOIN members as mb 
ON t4.FK_MEMBER_ID_for_OD = mb.MEMBER_ID
WHERE
MEMBER_ID = ? && ORDER_STATUS LIKE ? 
&& ORDER_DETAIL_VISIBLE_ON_WEB != 0 && datediff(ORDER_DATE, NOW()) >= -90';

$statement_query_order_details = $pdo->prepare($sql_query_order_details);
$statement_query_order_details->bindParam(1, $json_data->memberID);
$statement_query_order_details->bindParam(2, $json_data->orderStatus);
$statement_query_order_details->execute();

$query_result = $statement_query_order_details->fetchAll(PDO::FETCH_ASSOC);

print json_encode($query_result);
