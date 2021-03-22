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

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    echo '您的權限不足以執行這項操作！';
} else {

    $sql_delete_order = "UPDATE orders SET ORDER_VISIBLE_ON_WEB = 0 WHERE ORDER_ID = ?";
    $statement_delete_order = $pdo->prepare($sql_delete_order);
    $statement_delete_order->bindParam(1, $order_id);
    $statement_delete_order->execute();

    echo '訂單 ' . $order_id . ' 已被刪除了。';
}
