<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");
// 導入自定義函式庫
include("../../Lib/Functions.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

foreach ($json_data as $properity => $value) {
    $json_data->$properity = '%' . $value . '%';
}

// 執行：根據關鍵詞查詢相關訂單
$sql_query_orders = 'SELECT * FROM
(SELECT * FROM orders as od
JOIN members as mb
ON od.FK_MEMBER_ID_for_OD = mb.MEMBER_ID) as t1 
WHERE
ORDER_ID like ? && ORDER_DATE like ? && MEMBER_ACCOUNT like ? && 
ORDER_MC_NAME like ? && ORDER_MC_PHONE like ? && ORDER_STATUS like ? && ORDER_VISIBLE_ON_WEB != 0';
$statement_query_orders = $pdo->prepare($sql_query_orders);
$statement_query_orders->bindParam(1, $json_data->orderID);
$statement_query_orders->bindParam(2, $json_data->orderDate);
$statement_query_orders->bindParam(3, $json_data->memberAccount);
$statement_query_orders->bindParam(4, $json_data->ordererName);
$statement_query_orders->bindParam(5, $json_data->ordererPhone);
$statement_query_orders->bindParam(6, $json_data->orderStatus);
$statement_query_orders->execute();

$query_result = $statement_query_orders->fetchAll(PDO::FETCH_ASSOC);

if ($query_result == null) {
    $query_result = (array)[];
} else {
    foreach ($query_result as $index => $sub_arr) {
        $sort_index = find_out_serial('orders', $sub_arr['ORDER_ID']);
        $query_result[$index]['SORT_INDEX'] = $sort_index;
    }
}

print json_encode($query_result);
