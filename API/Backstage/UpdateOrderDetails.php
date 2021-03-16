<?php

// 設定 CORS 權限
// header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: http://localhost:8080/");
// header("Access-Control-Allow-Origin: https://fe-sp-0001-kapitan.herokuapp.com");
header('Access-Control-Allow-Methods: POST');
header("Content-Type:text/html; charset=utf-8");

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

    $sql_update_order_details = "UPDATE order_details as odd JOIN booking as bk 
    ON bk.FK_ORDER_DETAIL_ID_for_BK = odd.ORDER_DETAIL_ID SET 
    odd.ORDER_DETAIL_MC_NAME = ?, odd.ORDER_DETAIL_MC_PHONE = ?, odd.ORDER_DETAIL_MC_EMAIL = ?, 
    odd.ORDER_DETAIL_EC_NAME = ?, odd.ORDER_DETAIL_EC_PHONE = ?, odd.ORDER_DETAIL_EC_EMAIL = ?, 
    bk.FK_PROJECT_ID_for_BK = ?, bk.BOOKING_DATE = ? WHERE odd.ORDER_DETAIL_ID = ?";
    $statement_update_order_details = $pdo->prepare($sql_update_order_details);
    $statement_update_order_details->bindParam(1, $edited_details->MCname);
    $statement_update_order_details->bindParam(2, $edited_details->MCphone);
    $statement_update_order_details->bindParam(3, $edited_details->MCemail);
    $statement_update_order_details->bindParam(4, $edited_details->ECname);
    $statement_update_order_details->bindParam(5, $edited_details->ECphone);
    $statement_update_order_details->bindParam(6, $edited_details->ECemail);
    $statement_update_order_details->bindParam(7, $edited_details->projectID);
    $statement_update_order_details->bindParam(8, $edited_details->bookingDate);
    $statement_update_order_details->bindParam(9, $edited_details->orderDetailID);
    $statement_update_order_details->execute();

    echo $edited_details->orderDetailID . '修改完成了！';
}
