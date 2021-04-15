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

// 執行：詢問訂單是否屬於測試項目，以利後續區別相關權限操作
$sql_query_testing_orders = 'SELECT * FROM orders WHERE ORDER_ID = ?';

$statement_query_testing_orders = $pdo->prepare($sql_query_testing_orders);
$statement_query_testing_orders->bindParam(1, $order_id);
$statement_query_testing_orders->execute();

$query_result = $statement_query_testing_orders->fetch(PDO::FETCH_ASSOC);

$testing = $query_result['ORDER_FOR_TESTING'];

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    if ($testing == 1) {
        $order_status = -1;
    } else {
        echo '您的權限不足以執行這項操作！';
        exit;
    }
} else {
    $order_status = $edited_details->orderStatus;
}

// 執行：根據輸入資料更新訂單資料
$sql_update_order_data = "UPDATE orders SET 
ORDER_STATUS = ?, ORDER_DATE = ?, ORDER_TOTAL_CONSUMPTION = ?, ORDER_TOTAL_DISCOUNT = ?, ORDER_MC_NAME = ?, 
ORDER_MC_PHONE = ?, ORDER_MC_EMAIL = ?, ORDER_EC_NAME = ?, ORDER_EC_PHONE = ?, ORDER_EC_EMAIL = ?, FK_MEMBER_ID_for_OD = ? 
WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
$statement_update_order_data = $pdo->prepare($sql_update_order_data);
$statement_update_order_data->bindParam(1, $order_status);
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
            ORDER_DETAIL_STATUS = ? WHERE ORDER_DETAIL_ID = ? && ORDER_DETAIL_VISIBLE_ON_WEB != 0";
            $statement_update_order_details = $pdo->prepare($sql_update_order_details);
            $statement_update_order_details->bindParam(1, $order_status);
            $statement_update_order_details->bindParam(2, $query_query_update_order_details[$i]['ORDER_DETAIL_ID']);
            $statement_update_order_details->execute();
        }
    }
}

echo '訂單 ' . $order_id . ' 修改完成了！';
