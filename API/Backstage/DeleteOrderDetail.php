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

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    echo '您的權限不足以執行這項操作！';
} else {

    $sql_delete_order_detail = "UPDATE order_details SET ORDER_DETAIL_VISIBLE_ON_WEB = 0 WHERE ORDER_DETAIL_ID = ?";
    $statement_delete_order_detail = $pdo->prepare($sql_delete_order_detail);
    $statement_delete_order_detail->bindParam(1, $order_detail_id);
    $statement_delete_order_detail->execute();

    echo '訂單細項 ' . $order_detail_id . ' 已被刪除了。';
}
