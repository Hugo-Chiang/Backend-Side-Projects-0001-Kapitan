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

// 以變數接收關鍵資料，以利後續操作
$member_id = $json_data->memberID;
$orderer_contact_info_arr = $json_data->ordererContactInfo;
$order_details_arr = $json_data->orderDetails;

// 執行：查詢結帳內容是否包含已預約的內容（購物車階段被人截胡）
$alerady_booking_arr = [];

$sql_query_booking =
    "SELECT * FROM booking WHERE BOOKING_DATE = ? && FK_PROJECT_ID_for_BK = ?";

for ($i = 0; $i < count($order_details_arr); $i++) {
    $statement_query_booking = $pdo->prepare($sql_query_booking);
    $statement_query_booking->bindParam(1, $order_details_arr[$i]->bookingProjectDate);
    $statement_query_booking->bindParam(2, $order_details_arr[$i]->bookingProjectID);
    $statement_query_booking->execute();

    $query_result = $statement_query_booking->fetch(PDO::FETCH_ASSOC);

    if ($query_result != null) {
        array_push($alerady_booking_arr, $query_result);
    }
}


if (count($alerady_booking_arr) > 0) {

    // 向前端回傳結果：若干方案已有預約
    $return_obj = (object)[
        'status' => '重複訂購',
        'message' => '很抱歉，您所挑選的方案中，有【' . count($alerady_booking_arr) . '】筆在剛剛被預約了。系統已為您刪去重複預約的方案，再請確認新的結帳內容。謝謝您！',
        'invalidAProjects' => $alerady_booking_arr,
    ];

    print json_encode($return_obj);
} else {

    // 執行：判斷並寫入最新訂單編號
    $insert_order_id = insert_max_id($pdo, 'orders');

    $sql_insert_order = "INSERT INTO 
    orders(ORDER_ID, ORDER_DATE, ORDER_TOTAL_CONSUMPTION, ORDER_TOTAL_DISCOUNT, 
    ORDER_MC_NAME, ORDER_MC_PHONE, ORDER_MC_EMAIL, 
    ORDER_EC_NAME, ORDER_EC_PHONE, ORDER_EC_EMAIL, FK_MEMBER_ID_for_OD) 
    VALUES (?, NOW(),'20000','0', ?, ?, ?, ?, ?, ?, ?)";

    // 執行：訂單寫入 orders 表格
    $statement_insert_order = $pdo->prepare($sql_insert_order);
    $statement_insert_order->bindParam(1, $insert_order_id);
    $statement_insert_order->bindParam(2, $orderer_contact_info_arr->MCname);
    $statement_insert_order->bindParam(3, $orderer_contact_info_arr->MCphone);
    $statement_insert_order->bindParam(4, $orderer_contact_info_arr->MCemail);
    $statement_insert_order->bindParam(5, $orderer_contact_info_arr->ECname);
    $statement_insert_order->bindParam(6, $orderer_contact_info_arr->ECphone);
    $statement_insert_order->bindParam(7, $orderer_contact_info_arr->ECemail);
    $statement_insert_order->bindParam(8, $member_id);
    $statement_insert_order->execute();

    // 執行：訂單細項寫入 order_details 表格，同時預約紀錄寫入 booking 表格
    for ($i = 0; $i < count($order_details_arr); $i++) {

        $sql_instert_order_detail = "INSERT INTO order_details 
        (ORDER_DETAIL_ID, ORDER_DETAIL_AMOUNT, ORDER_DETAIL_MC_NAME, ORDER_DETAIL_MC_PHONE, ORDER_DETAIL_MC_EMAIL, 
        ORDER_DETAIL_EC_NAME, ORDER_DETAIL_EC_PHONE, ORDER_DETAIL_EC_EMAIL, FK_ORDER_ID_for_ODD) 
        VALUES (?, '20000', ?, ?, ?, ?, ?, ?, ?)";

        $insert_order_detail_id = insert_max_id($pdo, 'order_details');

        $statement_instert_order_detail = $pdo->prepare($sql_instert_order_detail);
        $statement_instert_order_detail->bindParam(1, $insert_order_detail_id);
        $statement_instert_order_detail->bindParam(2, $order_details_arr[$i]->MCname);
        $statement_instert_order_detail->bindParam(3, $order_details_arr[$i]->MCphone);
        $statement_instert_order_detail->bindParam(4, $order_details_arr[$i]->MCemail);
        $statement_instert_order_detail->bindParam(5, $order_details_arr[$i]->ECname);
        $statement_instert_order_detail->bindParam(6, $order_details_arr[$i]->ECphone);
        $statement_instert_order_detail->bindParam(7, $order_details_arr[$i]->ECemail);
        $statement_instert_order_detail->bindParam(8, $insert_order_id);
        $statement_instert_order_detail->execute();

        $sql_insert_booking = "INSERT INTO 
        booking(BOOKING_ID, BOOKING_DATE, FK_PROJECT_ID_for_BK, FK_ORDER_DETAIL_ID_for_BK) 
        VALUES (?, ?, ?, ?)";

        $insert_booking_id = insert_max_id($pdo, 'booking');

        $statement_insert_booking = $pdo->prepare($sql_insert_booking);
        $statement_insert_booking->bindParam(1, $insert_booking_id);
        $statement_insert_booking->bindParam(2, $order_details_arr[$i]->bookingProjectDate);
        $statement_insert_booking->bindParam(3, $order_details_arr[$i]->bookingProjectID);
        $statement_insert_booking->bindParam(4, $insert_order_detail_id);
        $statement_insert_booking->execute();
    }

    // 向前端回報結果：成功訂購
    $return_obj = (object)[
        'status' => '訂購成功',
        'message' => '會員【' . $member_id . '】的訂單完成了！編號是：【' . $insert_order_id . '】。',
        'order_id' => $insert_order_id,
    ];

    print json_encode($return_obj);
}
