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

// 透過 session 判斷管理員權限是否足夠進行細項編輯
$admin_level = check_admin_permissions($pdo, $session);

// 執行：詢問細項是否屬於測試項目，以利後續區別相關權限操作
$sql_query_testing_order_detail = 'SELECT * FROM order_details WHERE ORDER_DETAIL_ID = ?';

$statement_query_testing_order_detail = $pdo->prepare($sql_query_testing_order_detail);
$statement_query_testing_order_detail->bindParam(1, $edited_details->orderDetailID);
$statement_query_testing_order_detail->execute();

$query_testing_order_detail_result = $statement_query_testing_order_detail->fetch(PDO::FETCH_ASSOC);

$testing = $query_testing_order_detail_result['ORDER_DETAIL_FOR_TESTING'];

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

$data_error = [];
$min_num_people = 0;
$max_num_people = 0;

// 執行：查詢方案是否存在或是否人數不符限制
$project_id = $edited_details->projectID;
$sql_query_project = "SELECT * FROM projects WHERE PROJECT_ID = ? && PROJECT_VISIBLE_ON_WEB != 0";
$statement_query_project = $pdo->prepare($sql_query_project);
$statement_query_project->bindParam(1,  $project_id);
$statement_query_project->execute();

$query_project_result = $statement_query_project->fetch(PDO::FETCH_ASSOC);

if ($query_project_result == null) {
    array_push($data_error, '方案不存在');
} else {
    $booking_num_people = $edited_details->bookingNumOfPeople;

    $min_num_people = $query_project_result['PROJECT_MIN_NUM_OF_PEOPLE'];
    $max_num_people = $query_project_result['PROJECT_MAX_NUM_OF_PEOPLE'];

    if ($booking_num_people < $min_num_people || $booking_num_people > $max_num_people) {
        array_push($data_error, '預約人數不符限制');
    }
}

// 執行：查詢訂單是否存在或其是否為測試單
$order_id = $edited_details->newOrderID;
$sql_query_order = "SELECT * FROM orders WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
$statement_query_order = $pdo->prepare($sql_query_order);
$statement_query_order->bindParam(1, $order_id);
$statement_query_order->execute();

$query_order_result = $statement_query_order->fetch(PDO::FETCH_ASSOC);

if ($query_order_result == null) {
    array_push($data_error, '訂單不存在');
} else if ($query_order_result['ORDER_FOR_TESTING'] == 0 && $admin_level > 2) {
    array_push($data_error, '無權歸屬測試單');
}

// 判斷：是否有錯誤回饋，「有」則回傳前端、「無」則根據輸入資料更新細項
if (count($data_error) > 0) {
    $error_feedback = '<p>輸入資料有誤，回饋清單如下：</p><ul>';

    foreach ($data_error as $error) {
        switch ($error) {
            case '方案不存在':
                $error_feedback = $error_feedback . '<li>方案【 ' . $project_id . ' 】並不存在。</li>';
                break;
            case '訂單不存在':
                $error_feedback = $error_feedback . '<li>訂單【 ' . $order_id . ' 】並不存在。</li>';
                break;
            case '預約人數不符限制':
                $error_feedback = $error_feedback . '<li>方案【 ' . $project_id . ' 】預約人數應介於 ' . $min_num_people . ' - ' . $max_num_people . ' 之間。</li>';
                break;
            case '無權歸屬測試單':
                $error_feedback = $error_feedback . '<li>您的權限不足以將測試細項歸屬在非測試訂單上。</li>';
                break;
        }
    }

    $error_feedback = $error_feedback . '</ul><p>請再檢查一次，謝謝。</p>';

    echo $error_feedback;
} else {

    // 執行：選出訂單細項所用的密鑰，以利後續產生購買憑證
    $para = 'order_details';
    $sql_query_secret_key = 'SELECT SECRET_KEY_VALUE FROM secret_keys WHERE SECRET_KEY_USAGE = ?';
    $statement_query_secret_key = $pdo->prepare($sql_query_secret_key);
    $statement_query_secret_key->bindParam(1, $para);
    $statement_query_secret_key->execute();

    $order_details_secret_key_row = $statement_query_secret_key->fetch(PDO::FETCH_ASSOC);
    $order_details_secret_key = $order_details_secret_key_row['SECRET_KEY_VALUE'];

    // 執行：查詢訂單持有者帳號，以利後續產生購買憑證
    $sql_query_member_account = 'SELECT mb.MEMBER_ACCOUNT FROM orders as od
    JOIN members as mb ON od.FK_MEMBER_ID_for_OD = mb.MEMBER_ID 
    WHERE od.ORDER_ID = ? && od.ORDER_VISIBLE_ON_WEB != 0';

    $statement_query_member_account = $pdo->prepare($sql_query_member_account);
    $statement_query_member_account->bindParam(1, $order_id);
    $statement_query_member_account->execute();

    $query_result = $statement_query_member_account->fetch(PDO::FETCH_ASSOC);
    $member_account = $query_result['MEMBER_ACCOUNT'];

    $order_detail_certificate = md5($edited_details->orderDetailID . $member_account . $order_details_secret_key);

    // 執行：根據輸入資料更新訂單細項內容
    $sql_update_order_details = "UPDATE order_details as odd JOIN booking as bk 
    ON bk.FK_ORDER_DETAIL_ID_for_BK = odd.ORDER_DETAIL_ID SET 
    odd.ORDER_DETAIL_STATUS = ?, odd.ORDER_DETAIL_AMOUNT = ?, 
    odd.ORDER_DETAIL_MC_NAME = ?, odd.ORDER_DETAIL_MC_PHONE = ?, odd.ORDER_DETAIL_MC_EMAIL = ?, 
    odd.ORDER_DETAIL_EC_NAME = ?, odd.ORDER_DETAIL_EC_PHONE = ?, odd.ORDER_DETAIL_EC_EMAIL = ?, 
    bk.FK_PROJECT_ID_for_BK = ?, bk.BOOKING_NUM_OF_PEOPLE = ?, bk.BOOKING_DATE = ?, ORDER_DETAIL_CERTIFICATE = ?, 
    FK_ORDER_ID_for_ODD = ? WHERE odd.ORDER_DETAIL_ID = ? && odd.ORDER_DETAIL_VISIBLE_ON_WEB != 0";
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
    $statement_update_order_details->bindParam(12, $order_detail_certificate);
    $statement_update_order_details->bindParam(13, $edited_details->newOrderID);
    $statement_update_order_details->bindParam(14, $edited_details->orderDetailID);
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
}
