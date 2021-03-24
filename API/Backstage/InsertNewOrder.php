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
$edited_details = $json_data->editedDetails;

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    echo '您的權限不足以執行這項操作！';
} else {

    // 執行：查詢訂單歸屬對象是否存在
    $sql_query_member = "SELECT * FROM orders WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
    $statement_query_member = $pdo->prepare($sql_query_member);
    $statement_query_member->bindParam(1, $edited_details->memberID);
    $statement_query_member->execute();

    $query_result = $statement_query_member->fetch(PDO::FETCH_ASSOC);

    if ($query_result != null) {

        $order_id = insert_max_id($pdo, 'orders');
        $visible = 1;

        $sql_insert_order_data = "INSERT INTO orders 
        (ORDER_ID, ORDER_STATUS, ORDER_DATE, ORDER_TOTAL_CONSUMPTION, ORDER_TOTAL_DISCOUNT, 
        ORDER_MC_NAME, ORDER_MC_PHONE, ORDER_MC_EMAIL, 
        ORDER_EC_NAME, ORDER_EC_PHONE, ORDER_EC_EMAIL, ORDER_VISIBLE_ON_WEB, FK_MEMBER_ID_for_OD) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement_insert_order_data = $pdo->prepare($sql_insert_order_data);
        $statement_insert_order_data->bindParam(1, $order_id);
        $statement_insert_order_data->bindParam(2, $edited_details->orderStatus);
        $statement_insert_order_data->bindParam(3, $edited_details->orderDate);
        $statement_insert_order_data->bindParam(4, $edited_details->orderTotalConsumption);
        $statement_insert_order_data->bindParam(5, $edited_details->orderTotalDiscount);
        $statement_insert_order_data->bindParam(6, $edited_details->MCname);
        $statement_insert_order_data->bindParam(7, $edited_details->MCphone);
        $statement_insert_order_data->bindParam(8, $edited_details->MCemail);
        $statement_insert_order_data->bindParam(9, $edited_details->ECname);
        $statement_insert_order_data->bindParam(10, $edited_details->ECphone);
        $statement_insert_order_data->bindParam(11, $edited_details->ECemail);
        $statement_insert_order_data->bindParam(12, $visible);
        $statement_insert_order_data->bindParam(13, $edited_details->memberID);
        $statement_insert_order_data->execute();

        echo '訂單 ' . $order_id . ' 新增完成了！';
    } else {
        echo '會員 ' . $edited_details->memberID . ' 並不存在。請再檢查一次。';
    }
}
