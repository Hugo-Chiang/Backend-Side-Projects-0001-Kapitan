<?php

// 設定 CROS 權限
header("Access-Control-Allow-Origin: *");
header("Content-Type:text/html; charset=utf-8");
// header("Access-Control-Allow-Origin: https://side-projects-01-kapitan.herokuapp.com");
// header('Access-Control-Allow-Methods: GET');

// 導入PDO以安全連線資練庫
include("../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

// 以變數接收關鍵資料，以利後續操作
$member_id = $json_data->memberID;
$orderer_contact_info_arr = $json_data->ordererContactInfo;
$order_details_arr = $json_data->orderDetails;

// 前置語法區域開始

// 資料庫查詢：找到目前最新序號，以利後續生成各表格的下一序號
$sql_select_max_order_id = "SELECT max(ORDER_ID) FROM orders";
$sql_select_max_detail_id = "SELECT max(ORDER_DETAIL_ID) FROM order_details";
$sql_select_max_booking_id = "SELECT max(BOOKING_ID) FROM booking";

// 資料庫寫入：綁定已登入的會員帳號，寫入訂單表格（orders）
$sql_insert_order =
    "INSERT INTO orders(ORDER_ID,ORDER_DATE,ORDER_TOTAL_CONSUMPTION,ORDER_TOTAL_DISCOUNT,FK_MEMBER_ID_for_OD) 
VALUES (?, NOW(),'20000','0', ?)";
// 資料庫寫入：
$sql_instert_order_detail =
    "INSERT INTO order_details
(ORDER_DETAIL_ID, ORDER_DETAIL_AMOUNT, ORDER_DETAIL_MC_NAME, ORDER_DETAIL_MC_PHONE, ORDER_DETAIL_MC_EMAIL, ORDER_DETAIL_EC_NAME, ORDER_DETAIL_EC_PHONE, ORDER_DETAIL_EC_EMAIL, FK_ORDER_ID_for_ODD) 
VALUES (?, '20000', ?, ?, ?, ?, ?, ?, ?)";
// 資料庫寫入：
$sql_insert_booking =
    "INSERT INTO booking(BOOKING_ID, BOOKING_DATE, FK_PROJECT_ID_for_BK, FK_ORDER_DETAIL_ID_for_BK) 
VALUES (?, NOW(), ?, ?)";

// 前置語法區域結束

// 執行：判斷並寫入最新訂單編號
$statement_select_max_order_id = $pdo->prepare($sql_select_max_order_id);
$statement_select_max_order_id->execute();
$order_max_id = $statement_select_max_order_id->fetch();

$order_max_id == null ? 'OD0000000000' : $order_max_id;

$order_max_number = (int)substr($order_max_id[0], 2, 7) + 1;
$insert_order_id = "";

if ($order_max_number < 10) {
    $insert_order_id = "OD000000" . $order_max_number;
} else if ($order_max_number < 100 && $order_max_number >= 10) {
    $insert_order_id = "OD00000" . $order_max_number;
} else if ($order_max_number < 1000 && $order_max_number >= 100) {
    $insert_order_id = "OD0000" . $maxNumber;
} else if ($order_max_number < 10000 && $order_max_number >= 1000) {
    $insert_order_id = "OD000" . $maxNumber;
} else if ($order_max_number < 100000 && $maxNumber >= 10000) {
    $insert_order_id = "OD00" . $order_max_number;
}

// 執行：訂單寫入 orders 表格
$statement_insert_order = $pdo->prepare($sql_insert_order);
$statement_insert_order->bindParam(1, $insert_order_id);
$statement_insert_order->bindParam(2, $member_id);
$statement_insert_order->execute();

// 執行：訂單細項寫入 order_details 表格
for ($i = 0; $i < count($order_details_arr); $i++) {

    // 執行：判斷並寫入最新訂單細節編號
    $statement_select_max_detail_id  = $pdo->prepare($sql_select_max_detail_id);
    $statement_select_max_detail_id->execute();
    $order_max_detail_id = $statement_select_max_detail_id->fetch();

    $order_max_id == null ? 'OD0000000000' : $order_max_id;

    $order_max_number = (int)substr($order_max_id[0], 2, 7) + 1;
    $insert_order_id = "";

    if ($order_max_number < 10) {
        $insert_order_id = "OD000000" . $order_max_number;
    } else if ($order_max_number < 100 && $order_max_number >= 10) {
        $insert_order_id = "OD00000" . $order_max_number;
    } else if ($order_max_number < 1000 && $order_max_number >= 100) {
        $insert_order_id = "OD0000" . $maxNumber;
    } else if ($order_max_number < 10000 && $order_max_number >= 1000) {
        $insert_order_id = "OD000" . $maxNumber;
    } else if ($order_max_number < 100000 && $maxNumber >= 10000) {
        $insert_order_id = "OD00" . $order_max_number;
    }
}

echo $member_id . '的訂單完成了！';

?>
.