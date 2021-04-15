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
$creatingDetails = $json_data->creatingDetails;

// 透過 session 判斷管理員權限所建細項是否僅供測試
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    $testing = 1;
    $order_details_status = -1;
} else {

    $testing = 0;
    $order_details_status = $creatingDetails[0]->ORDER_DETAIL_STATUS;
}

$data_error = [];
$min_num_people = 0;
$max_num_people = 0;

// 執行：查詢方案是否存在或是否人數不符限制
$project_id = $creatingDetails[0]->PROJECT_ID;
$sql_query_project = "SELECT * FROM projects WHERE PROJECT_ID = ? && PROJECT_VISIBLE_ON_WEB != 0";
$statement_query_project = $pdo->prepare($sql_query_project);
$statement_query_project->bindParam(1,  $project_id);
$statement_query_project->execute();

$query_project_result = $statement_query_project->fetch(PDO::FETCH_ASSOC);

if ($query_project_result == null) {
    array_push($data_error, '方案不存在');
} else {
    $booking_num_people = $creatingDetails[0]->BOOKING_NUM_OF_PEOPLE;

    $min_num_people = $query_project_result['PROJECT_MIN_NUM_OF_PEOPLE'];
    $max_num_people = $query_project_result['PROJECT_MAX_NUM_OF_PEOPLE'];

    if ($booking_num_people < $min_num_people || $booking_num_people > $max_num_people) {
        array_push($data_error, '預約人數不符限制');
    }
}

// 執行：查詢方案是否已被預訂
$booking_date = $creatingDetails[0]->BOOKING_DATE;
$booked_order_id = '';
$booked_order_detail_id = '';
$sql_query_booking = "SELECT * FROM booking as bk 
JOIN order_details as odd ON bk.FK_ORDER_DETAIL_ID_for_BK = odd.ORDER_DETAIL_ID 
WHERE BOOKING_DATE = ? && FK_PROJECT_ID_for_BK = ? && ORDER_DETAIL_STATUS != -1;";
$statement_query_booking = $pdo->prepare($sql_query_booking);
$statement_query_booking->bindParam(1,  $booking_date);
$statement_query_booking->bindParam(2,  $project_id);
$statement_query_booking->execute();

$query_booking_result = $statement_query_booking->fetch(PDO::FETCH_ASSOC);

if ($query_booking_result != null || false) {
    $booked_order_id = $query_booking_result['FK_ORDER_ID_for_ODD'];
    $booked_order_detail_id = $query_booking_result['FK_ORDER_DETAIL_ID_for_BK'];
    array_push($data_error, '方案已預訂');
}

// 執行：查詢訂單是否存在或其是否為測試單
$order_id = $creatingDetails[0]->FK_ORDER_ID_for_ODD;
$sql_query_order = "SELECT * FROM orders WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
$statement_query_order = $pdo->prepare($sql_query_order);
$statement_query_order->bindParam(1, $order_id);
$statement_query_order->execute();

$query_order_result = $statement_query_order->fetch(PDO::FETCH_ASSOC);

$query_order_for_testing = '無關';
if ($query_order_result) {
    $query_order_for_testing = $query_order_result['ORDER_FOR_TESTING'];
}

if ($query_order_result == null) {
    array_push($data_error, '訂單不存在');
} else if ($query_order_result['ORDER_FOR_TESTING'] == 0 && $admin_level > 2) {
    array_push($data_error, '無權歸屬測試單');
}

// 判斷：是否有錯誤回饋，「有」則回傳前端、「無」則根據輸入資料新增細項
if (count($data_error) > 0) {
    $error_feedback = '<p>輸入資料有誤，回饋清單如下：</p><ul>';

    foreach ($data_error as $error) {
        switch ($error) {
            case '方案不存在':
                $error_feedback = $error_feedback . '<li>方案【 ' . $project_id . ' 】並不存在。</li>';
                break;
            case '方案已預訂':
                $error_feedback = $error_feedback . '<li>日期【 ' . $booking_date . ' 】已有非測試單預訂，係訂單【 ' . $booked_order_id . ' 】下的【 ' . $booked_order_detail_id . ' 】細項。</li>';
                break;
            case '預約人數不符限制':
                $error_feedback = $error_feedback . '<li>方案【 ' . $project_id . ' 】預約人數應介於 ' . $min_num_people . ' - ' . $max_num_people . ' 之間。</li>';
                break;
            case '訂單不存在':
                $error_feedback = $error_feedback . '<li>訂單【 ' . $order_id . ' 】並不存在。</li>';
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

    $order_detail_id = insert_max_id($pdo, 'order_details');
    $member_account = $creatingDetails[0]->ORDER_DETAIL_AMOUNT;
    $booking_id = insert_max_id($pdo, 'booking');
    $visible = 1;
    $order_detail_certificate = md5($order_detail_id . $member_account . $order_details_secret_key);

    // 執行：新增訂單細項
    $sql_insert_order_details = "INSERT INTO order_details 
    (ORDER_DETAIL_ID, ORDER_DETAIL_STATUS, ORDER_DETAIL_AMOUNT, 
    ORDER_DETAIL_MC_NAME, ORDER_DETAIL_MC_PHONE, ORDER_DETAIL_MC_EMAIL, 
    ORDER_DETAIL_EC_NAME, ORDER_DETAIL_EC_PHONE, ORDER_DETAIL_EC_EMAIL, 
    ORDER_DETAIL_FOR_TESTING, ORDER_DETAIL_VISIBLE_ON_WEB, ORDER_DETAIL_CERTIFICATE, 
    FK_ORDER_ID_for_ODD)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $statement_insert_order_details = $pdo->prepare($sql_insert_order_details);
    $statement_insert_order_details->bindParam(1, $order_detail_id);
    $statement_insert_order_details->bindParam(2, $order_details_status);
    $statement_insert_order_details->bindParam(3, $creatingDetails[0]->ORDER_DETAIL_AMOUNT);
    $statement_insert_order_details->bindParam(4, $creatingDetails[0]->ORDER_DETAIL_MC_NAME);
    $statement_insert_order_details->bindParam(5, $creatingDetails[0]->ORDER_DETAIL_MC_PHONE);
    $statement_insert_order_details->bindParam(6, $creatingDetails[0]->ORDER_DETAIL_MC_EMAIL);
    $statement_insert_order_details->bindParam(7, $creatingDetails[0]->ORDER_DETAIL_EC_NAME);
    $statement_insert_order_details->bindParam(8, $creatingDetails[0]->ORDER_DETAIL_EC_PHONE);
    $statement_insert_order_details->bindParam(9, $creatingDetails[0]->ORDER_DETAIL_EC_EMAIL);
    $statement_insert_order_details->bindParam(10, $testing);
    $statement_insert_order_details->bindParam(11, $visible);
    $statement_insert_order_details->bindParam(12, $order_detail_certificate);
    $statement_insert_order_details->bindParam(13, $creatingDetails[0]->FK_ORDER_ID_for_ODD);
    $statement_insert_order_details->execute();

    $sql_insert_order_details = "INSERT INTO booking 
    (BOOKING_ID, BOOKING_DATE, BOOKING_NUM_OF_PEOPLE, BOOKING_VISIBLE_ON_WEB, 
    FK_PROJECT_ID_for_BK, FK_ORDER_DETAIL_ID_for_BK)
    VALUES (?, ?, ?, ?, ?, ?)";

    $statement_insert_order_details = $pdo->prepare($sql_insert_order_details);
    $statement_insert_order_details->bindParam(1, $booking_id);
    $statement_insert_order_details->bindParam(2, $booking_date);
    $statement_insert_order_details->bindParam(3, $creatingDetails[0]->BOOKING_NUM_OF_PEOPLE);
    $statement_insert_order_details->bindParam(4, $visible);
    $statement_insert_order_details->bindParam(5, $creatingDetails[0]->PROJECT_ID);
    $statement_insert_order_details->bindParam(6, $order_detail_id);
    $statement_insert_order_details->execute();


    // 執行：因應細項新增而更新訂單總金額
    $sql_query_order_new_amount = "SELECT sum(ORDER_DETAIL_AMOUNT) FROM
    (SELECT * FROM orders as od JOIN order_details as odd ON 
    odd.FK_ORDER_ID_for_ODD = od.ORDER_ID) as t1 
    WHERE t1.ORDER_ID = ? && t1.ORDER_VISIBLE_ON_WEB != 0 && t1.ORDER_DETAIL_VISIBLE_ON_WEB != 0 
    GROUP BY t1.ORDER_ID";
    $statement_query_order_new_amount = $pdo->prepare($sql_query_order_new_amount);
    $statement_query_order_new_amount->bindParam(1, $creatingDetails[0]->FK_ORDER_ID_for_ODD);
    $statement_query_order_new_amount->execute();

    $query_result = $statement_query_order_new_amount->fetch(PDO::FETCH_ASSOC);
    $order_new_amount = $query_result['sum(ORDER_DETAIL_AMOUNT)'];

    $sql_update_order_amount = "UPDATE orders SET ORDER_TOTAL_CONSUMPTION = ? 
    WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
    $statement_update_order_amount = $pdo->prepare($sql_update_order_amount);
    $statement_update_order_amount->bindParam(1, $order_new_amount);
    $statement_update_order_amount->bindParam(2, $creatingDetails[0]->FK_ORDER_ID_for_ODD);
    $statement_update_order_amount->execute();

    echo $order_detail_id . ' 細項新增完成了！';
}
