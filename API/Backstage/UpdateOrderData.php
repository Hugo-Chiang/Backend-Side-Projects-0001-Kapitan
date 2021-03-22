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
$order_id =  $json_data->orderID;
$edited_details = $json_data->editedDetails;

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    echo '您的權限不足以執行這項操作！';
} else {

    $sql_update_order_data = "UPDATE orders SET 
    ORDER_STATUS = ?, ORDER_DATE = ?, ORDER_TOTAL_CONSUMPTION = ?, ORDER_TOTAL_DISCOUNT = ?, ORDER_MC_NAME = ?, 
    ORDER_MC_PHONE = ?, ORDER_MC_EMAIL = ?, ORDER_EC_NAME = ?, ORDER_EC_PHONE = ?, ORDER_EC_EMAIL = ?, FK_MEMBER_ID_for_OD = ? 
    WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
    $statement_update_order_data = $pdo->prepare($sql_update_order_data);
    $statement_update_order_data->bindParam(1, $edited_details->orderStatus);
    $statement_update_order_data->bindParam(2, $edited_details->orderDate);
    $statement_update_order_data->bindParam(3, $edited_details->orderTotalConsumption);
    $statement_update_order_data->bindParam(4, $edited_details->orderTotalDiscount);
    $statement_update_order_data->bindParam(5, $edited_details->MCname);
    $statement_update_order_data->bindParam(6, $edited_details->MCphone);
    $statement_update_order_data->bindParam(7, $edited_details->MCemail);
    $statement_update_order_data->bindParam(8, $edited_details->ECname);
    $statement_update_order_data->bindParam(9, $edited_details->ECphone);
    $statement_update_order_data->bindParam(10, $edited_details->ECemail);
    $statement_update_order_data->bindParam(11, $edited_details->memberID);
    $statement_update_order_data->bindParam(12, $order_id);
    $statement_update_order_data->execute();

    echo '訂單 ' . $order_id . ' 修改完成了！';
}
