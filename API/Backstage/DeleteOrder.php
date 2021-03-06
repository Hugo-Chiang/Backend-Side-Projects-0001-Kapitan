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

$session = $json_data->session;
$order_id = $json_data->orderID;

// 執行：詢問訂單是否屬於測試項目，以利後續區別相關權限操作
$sql_query_testing_orders = 'SELECT * FROM orders WHERE ORDER_ID = ?';

$statement_query_testing_orders = $pdo->prepare($sql_query_testing_orders);
$statement_query_testing_orders->bindParam(1, $order_id);
$statement_query_testing_orders->execute();

$query_result = $statement_query_testing_orders->fetch(PDO::FETCH_ASSOC);

$testing = $query_result['ORDER_FOR_TESTING'];

// 透過 session 判斷管理員權限是否足夠進行訂單刪除
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2 && $testing != 1) {

    echo '您的權限不足以執行這項操作！';
    exit;
}

$sql_delete_order = "UPDATE orders SET ORDER_VISIBLE_ON_WEB = 0 WHERE ORDER_ID = ?";
$statement_delete_order = $pdo->prepare($sql_delete_order);
$statement_delete_order->bindParam(1, $order_id);
$statement_delete_order->execute();

// 執行：根據輸入資料更新訂單細項內容
$sql_query_update_order_details = "SELECT * FROM order_details WHERE FK_ORDER_ID_for_ODD = ? && ORDER_DETAIL_VISIBLE_ON_WEB != 0";
$statement_query_update_order_details = $pdo->prepare($sql_query_update_order_details);
$statement_query_update_order_details->bindParam(1, $order_id);
$statement_query_update_order_details->execute();

$query_query_update_order_details = $statement_query_update_order_details->fetchAll(PDO::FETCH_ASSOC);

if ($query_query_update_order_details != null || false) {
    for ($i = 0; $i < count($query_query_update_order_details); $i++) {
        if ($query_query_update_order_details[$i]['ORDER_DETAIL_STATUS'] != 2) {
            $sql_update_order_details = "UPDATE order_details SET 
            ORDER_DETAIL_STATUS = 0 WHERE ORDER_DETAIL_ID = ? && ORDER_DETAIL_VISIBLE_ON_WEB != 0";
            $statement_update_order_details = $pdo->prepare($sql_update_order_details);
            $statement_update_order_details->bindParam(1, $query_query_update_order_details[$i]['ORDER_DETAIL_ID']);
            $statement_update_order_details->execute();
        }
    }
}

echo '訂單 ' . $order_id . ' 已被刪除了。';
