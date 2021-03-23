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
$creatDetails = $json_data->creatDetails;

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    echo '您的權限不足以執行這項操作！';
} else {

    // 執行：查詢方案是否存在
    $project_id = $creatDetails[0]->PROJECT_ID;
    $sql_query_project = "SELECT * FROM projects WHERE PROJECT_ID = ? && PROJECT_VISIBLE_ON_WEB != 0";
    $statement_query_project = $pdo->prepare($sql_query_project);
    $statement_query_project->bindParam(1,  $project_id);
    $statement_query_project->execute();

    $query_project_result = $statement_query_project->fetch(PDO::FETCH_ASSOC);

    // 執行：查詢訂單是否存在
    $order_id = $creatDetails[0]->FK_ORDER_ID_for_ODD;
    $sql_query_order = "SELECT * FROM orders WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
    $statement_query_order = $pdo->prepare($sql_query_order);
    $statement_query_order->bindParam(1, $order_id);
    $statement_query_order->execute();

    $query_order_result = $statement_query_order->fetch(PDO::FETCH_ASSOC);

    $query_results = (array)[
        (object)[
            'unit' => '方案',
            'ID' => $project_id,
            'exisit' => $query_project_result,
        ],
        (object)[
            'unit' => '訂單',
            'ID' => $order_id,
            'exisit' => $query_order_result,
        ],
    ];

    $data_error = false;

    foreach ($query_results as $obj) {
        if ($obj->exisit == null) {
            $data_error = true;
        }
    }

    if (!$data_error) {

        $order_detail_id = insert_max_id($pdo, 'order_details');
        $booking_id = insert_max_id($pdo, 'booking');
        $visible = 1;

        // 執行：新增訂單細項
        $sql_insert_order_details = "INSERT INTO order_details 
        (ORDER_DETAIL_ID, ORDER_DETAIL_STATUS, ORDER_DETAIL_AMOUNT, 
        ORDER_DETAIL_MC_NAME, ORDER_DETAIL_MC_PHONE, ORDER_DETAIL_MC_EMAIL, 
        ORDER_DETAIL_EC_NAME, ORDER_DETAIL_EC_PHONE, ORDER_DETAIL_EC_EMAIL, 
        ORDER_DETAIL_VISIBLE_ON_WEB, FK_ORDER_ID_for_ODD)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $statement_insert_order_details = $pdo->prepare($sql_insert_order_details);
        $statement_insert_order_details->bindParam(1, $order_detail_id);
        $statement_insert_order_details->bindParam(2, $creatDetails[0]->ORDER_DETAIL_STATUS);
        $statement_insert_order_details->bindParam(3, $creatDetails[0]->ORDER_DETAIL_AMOUNT);
        $statement_insert_order_details->bindParam(4, $creatDetails[0]->ORDER_DETAIL_MC_NAME);
        $statement_insert_order_details->bindParam(5, $creatDetails[0]->ORDER_DETAIL_MC_PHONE);
        $statement_insert_order_details->bindParam(6, $creatDetails[0]->ORDER_DETAIL_MC_EMAIL);
        $statement_insert_order_details->bindParam(7, $creatDetails[0]->ORDER_DETAIL_EC_NAME);
        $statement_insert_order_details->bindParam(8, $creatDetails[0]->ORDER_DETAIL_EC_PHONE);
        $statement_insert_order_details->bindParam(9, $creatDetails[0]->ORDER_DETAIL_EC_EMAIL);
        $statement_insert_order_details->bindParam(10, $visible);
        $statement_insert_order_details->bindParam(11, $creatDetails[0]->FK_ORDER_ID_for_ODD);
        $statement_insert_order_details->execute();

        $sql_insert_order_details = "INSERT INTO booking 
        (BOOKING_ID, BOOKING_DATE, BOOKING_NUM_OF_PEOPLE, BOOKING_VISIBLE_ON_WEB, 
        FK_PROJECT_ID_for_BK, FK_ORDER_DETAIL_ID_for_BK)
        VALUES (?, ?, ?, ?, ?, ?)";

        $statement_insert_order_details = $pdo->prepare($sql_insert_order_details);
        $statement_insert_order_details->bindParam(1, $booking_id);
        $statement_insert_order_details->bindParam(2, $creatDetails[0]->BOOKING_DATE);
        $statement_insert_order_details->bindParam(3, $creatDetails[0]->BOOKING_NUM_OF_PEOPLE);
        $statement_insert_order_details->bindParam(4, $visible);
        $statement_insert_order_details->bindParam(5, $creatDetails[0]->PROJECT_ID);
        $statement_insert_order_details->bindParam(6, $order_detail_id);
        $statement_insert_order_details->execute();


        // 執行：因應細項新增而更新訂單總金額
        $sql_query_order_new_amount = "SELECT sum(ORDER_DETAIL_AMOUNT) FROM
        (SELECT * FROM orders as od JOIN order_details as odd ON 
        odd.FK_ORDER_ID_for_ODD = od.ORDER_ID) as t1 
        WHERE t1.ORDER_ID = ? && t1.ORDER_VISIBLE_ON_WEB != 0 && t1.ORDER_DETAIL_VISIBLE_ON_WEB != 0 
        GROUP BY t1.ORDER_ID";
        $statement_query_order_new_amount = $pdo->prepare($sql_query_order_new_amount);
        $statement_query_order_new_amount->bindParam(1, $creatDetails[0]->FK_ORDER_ID_for_ODD);
        $statement_query_order_new_amount->execute();

        $query_result = $statement_query_order_new_amount->fetch(PDO::FETCH_ASSOC);
        $order_new_amount = $query_result['sum(ORDER_DETAIL_AMOUNT)'];

        $sql_update_order_amount = "UPDATE orders SET ORDER_TOTAL_CONSUMPTION = ? 
        WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
        $statement_update_order_amount = $pdo->prepare($sql_update_order_amount);
        $statement_update_order_amount->bindParam(1, $order_new_amount);
        $statement_update_order_amount->bindParam(2, $creatDetails[0]->FK_ORDER_ID_for_ODD);
        $statement_update_order_amount->execute();

        echo $order_detail_id . ' 細項新增完成了！';
    } else {

        foreach ($query_results as $obj) {
            if ($obj->exisit == null) {
                echo $obj->ID . ' ' . $obj->unit . '並不存在。請再檢查一次。<br>';
            }
        }
    }
}
