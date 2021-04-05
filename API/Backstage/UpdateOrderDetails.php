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

// 執行：查詢方案是否存在
$project_id = $edited_details->projectID;
$sql_query_project = "SELECT * FROM projects WHERE PROJECT_ID = ? && PROJECT_VISIBLE_ON_WEB != 0";
$statement_query_project = $pdo->prepare($sql_query_project);
$statement_query_project->bindParam(1,  $project_id);
$statement_query_project->execute();

$query_project_result = $statement_query_project->fetch(PDO::FETCH_ASSOC);

// 執行：查詢訂單是否存在或其是否為測試單
$order_id = $edited_details->newOrderID;
$sql_query_order = "SELECT * FROM orders WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
$statement_query_order = $pdo->prepare($sql_query_order);
$statement_query_order->bindParam(1, $order_id);
$statement_query_order->execute();

$query_order_result = $statement_query_order->fetch(PDO::FETCH_ASSOC);

$query_order_for_testing = '無關';
if ($query_order_result) {
    $query_order_for_testing = $query_order_result['ORDER_FOR_TESTING'];
}

$query_results = (array)[
    (object)[
        'unit' => '方案',
        'ID' => $project_id,
        'exisit' => $query_project_result,
        'forTesting' => '無關'
    ],
    (object)[
        'unit' => '訂單',
        'ID' => $order_id,
        'exisit' => $query_order_result,
        'forTesting' => $query_order_for_testing
    ],
];

$data_error = false;

foreach ($query_results as $obj) {
    if ($obj->exisit == null || $obj->forTesting == 0) {
        $data_error = true;
    }
}

// 執行：詢問細項是否屬於測試項目，以利後續區別相關權限操作
$order_detail_id = $edited_details->orderDetailID;
$sql_query_testing_order_details = 'SELECT * FROM order_details WHERE ORDER_DETAIL_ID = ?';

$statement_query_testing_order_details = $pdo->prepare($sql_query_testing_order_details);
$statement_query_testing_order_details->bindParam(1, $order_detail_id);
$statement_query_testing_order_details->execute();

$query_result = $statement_query_testing_order_details->fetch(PDO::FETCH_ASSOC);

$testing = $query_result['ORDER_DETAIL_FOR_TESTING'];

if (!$data_error) {

    // 透過 session 判斷管理員權限是否足夠進行細項刪除
    $admin_level = check_admin_permissions($pdo, $session);

    if ($admin_level > 2) {

        if ($testing == 1) {
            $order_detail_status = -1;
        } else {
            echo '您的權限不足以執行這項操作！';
            exit;
        }
    } else {

        $order_detail_status = $edited_details->orderDetailStatus;
    }

    // 執行：根據輸入資料更新訂單細項內容
    $sql_update_order_details = "UPDATE order_details as odd JOIN booking as bk 
    ON bk.FK_ORDER_DETAIL_ID_for_BK = odd.ORDER_DETAIL_ID SET 
    odd.ORDER_DETAIL_STATUS = ?, odd.ORDER_DETAIL_AMOUNT = ?, 
    odd.ORDER_DETAIL_MC_NAME = ?, odd.ORDER_DETAIL_MC_PHONE = ?, odd.ORDER_DETAIL_MC_EMAIL = ?, 
    odd.ORDER_DETAIL_EC_NAME = ?, odd.ORDER_DETAIL_EC_PHONE = ?, odd.ORDER_DETAIL_EC_EMAIL = ?, 
    bk.FK_PROJECT_ID_for_BK = ?, bk.BOOKING_NUM_OF_PEOPLE = ?, bk.BOOKING_DATE = ?, FK_ORDER_ID_for_ODD = ? 
    WHERE odd.ORDER_DETAIL_ID = ? && odd.ORDER_DETAIL_VISIBLE_ON_WEB != 0";
    $statement_update_order_details = $pdo->prepare($sql_update_order_details);
    $statement_update_order_details->bindParam(1, $order_detail_status);
    $statement_update_order_details->bindParam(2, $edited_details->orderDetailAmount);
    $statement_update_order_details->bindParam(3, $edited_details->MCname);
    $statement_update_order_details->bindParam(4, $edited_details->MCphone);
    $statement_update_order_details->bindParam(5, $edited_details->MCemail);
    $statement_update_order_details->bindParam(6, $edited_details->ECname);
    $statement_update_order_details->bindParam(7, $edited_details->ECphone);
    $statement_update_order_details->bindParam(8, $edited_details->ECemail);
    $statement_update_order_details->bindParam(9, $edited_details->projectID);
    $statement_update_order_details->bindParam(10, $edited_details->bookingNumOfPeople);
    $statement_update_order_details->bindParam(11, $edited_details->bookingDate);
    $statement_update_order_details->bindParam(12, $edited_details->newOrderID);
    $statement_update_order_details->bindParam(13, $edited_details->orderDetailID);
    $statement_update_order_details->execute();

    // 執行：因應細項修改而更新訂單總金額
    $sql_query_order_new_amount = "SELECT sum(ORDER_DETAIL_AMOUNT) FROM
    (SELECT * FROM orders as od JOIN order_details as odd ON 
    odd.FK_ORDER_ID_for_ODD = od.ORDER_ID) as t1 
    WHERE t1.ORDER_ID = ? && t1.ORDER_VISIBLE_ON_WEB != 0 && t1.ORDER_DETAIL_VISIBLE_ON_WEB != 0 
    GROUP BY t1.ORDER_ID";
    $statement_query_order_new_amount = $pdo->prepare($sql_query_order_new_amount);
    $statement_query_order_new_amount->bindParam(1, $edited_details->newOrderID);
    $statement_query_order_new_amount->execute();

    $query_result = $statement_query_order_new_amount->fetch(PDO::FETCH_ASSOC);
    $order_new_amount = $query_result['sum(ORDER_DETAIL_AMOUNT)'];

    $sql_update_order_amount = "UPDATE orders SET ORDER_TOTAL_CONSUMPTION = ? 
    WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
    $statement_update_order_amount = $pdo->prepare($sql_update_order_amount);
    $statement_update_order_amount->bindParam(1, $order_new_amount);
    $statement_update_order_amount->bindParam(2, $edited_details->newOrderID);
    $statement_update_order_amount->execute();

    echo $edited_details->orderDetailID . ' 細項修改完成了！';
} else {

    foreach ($query_results as $obj) {
        if ($obj->exisit == null) {
            echo $obj->ID . ' ' . $obj->unit . '並不存在。請再檢查一次。<br>';
        } else if ($obj->forTesting == 0) {
            echo '您的權限不足以將測試細項歸屬在非測試訂單上。<br>請再檢查一次。';
        }
    }
}
