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
$order_detail_id = $json_data->orderDetailID;

// 執行：詢問細項是否屬於測試項目，以利後續區別相關權限操作
$sql_query_testing_order_details = 'SELECT * FROM order_details WHERE ORDER_DETAIL_ID = ?';

$statement_query_testing_order_details = $pdo->prepare($sql_query_testing_order_details);
$statement_query_testing_order_details->bindParam(1, $order_detail_id);
$statement_query_testing_order_details->execute();

$query_result = $statement_query_testing_order_details->fetch(PDO::FETCH_ASSOC);

$testing = $query_result['ORDER_DETAIL_FOR_TESTING'];

// 透過 session 判斷管理員權限是否足夠進行細項刪除
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    if ($testing == 1) {
        $sql_delete_order_detail = "UPDATE order_details SET ORDER_DETAIL_VISIBLE_ON_WEB = 0 WHERE ORDER_DETAIL_ID = ?";
        $statement_delete_order_detail = $pdo->prepare($sql_delete_order_detail);
        $statement_delete_order_detail->bindParam(1, $order_detail_id);
        $statement_delete_order_detail->execute();

        echo '細項' . $order_detail_id . ' 已被刪除了。';
    } else {
        echo '您的權限不足以執行這項操作！';
    }
} else {

    $sql_delete_order_detail = "UPDATE order_details SET ORDER_DETAIL_VISIBLE_ON_WEB = 0 WHERE ORDER_DETAIL_ID = ?";
    $statement_delete_order_detail = $pdo->prepare($sql_delete_order_detail);
    $statement_delete_order_detail->bindParam(1, $order_detail_id);
    $statement_delete_order_detail->execute();

    echo '訂單細項 ' . $order_detail_id . ' 已被刪除了。';
}
