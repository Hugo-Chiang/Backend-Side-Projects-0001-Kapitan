<?php

// 函式：根據傳入的表格名稱，判斷並寫入最新編號
function insert_max_id($pdo, $table_name)
{

    switch ($table_name) {
        case 'orders':
            $table_id_template = 'OD0000000';
            $table_title = 'ORDER_ID';
            break;
        case 'order_details':
            $table_id_template = 'ODD0000000000';
            $table_title = 'ORDER_DETAIL_ID';
            break;
        case 'booking':
            $table_id_template = 'BK0000000000';
            $table_title = 'BOOKING_ID';
            break;
        case 'projects':
            $table_id_template = 'PJ0000000';
            $table_title = 'PROJECT_ID';
            break;
        case 'members':
            $table_id_template = 'MB0000000';
            $table_title = 'MEMBER_ID';
            break;
        case 'edm_list':
            $table_id_template = 'EM0000000';
            $table_title = 'EDM_ID';
            break;
    }

    $template_split_arr = str_split($table_id_template);
    $count_num = array_count_values($template_split_arr);
    $id_num_len = $count_num['0'];
    $id_num_start_index = array_search('0', $template_split_arr);
    $id_pefix = substr($table_id_template, 0, $id_num_start_index);
    $id_num_template = substr($table_id_template, $id_num_start_index);

    $table_max_id = "SELECT max($table_title) FROM $table_name";

    $statement_table_max_id = $pdo->prepare($table_max_id);
    $statement_table_max_id->execute();
    $select_max_id = $statement_table_max_id->fetch();

    $select_max_id == null ? $select_max_id = $id_pefix . $id_num_template : $select_max_id;

    $id_pefix_len = count($template_split_arr) - $id_num_len;
    $insert_max_num = (int)substr($select_max_id[0], $id_pefix_len + 1) + 1;

    $plus_zero_len = $id_num_len - strlen((string)$insert_max_num);

    $insert_max_id = $id_pefix;

    for ($i = 0; $i < $plus_zero_len; $i++) {
        $insert_max_id = $insert_max_id . '0';
    }

    $insert_max_id = $insert_max_id . (string)$insert_max_num;

    return $insert_max_id;
}

// 函式：根據傳入的表格名稱，判斷並寫入最新編號
function find_out_serial($table_name, $id)
{

    switch ($table_name) {
        case 'orders':
            $prefix = 'OD';
            break;
        case 'order_details':
            $prefix = 'ODD';
            break;
        case 'booking':
            $prefix = 'BK';
            break;
        case 'projects':
            $prefix = 'PJ';
            break;
        case 'members':
            $prefix = 'MB';
            break;
    }

    $id_serial = (int)substr($id, strlen($prefix));

    return $id_serial;
}

// 函式：查詢持有該 session 管理員的等級，並進行回傳
function check_admin_permissions($pdo, $session)
{
    $sql_query_admin_level = 'SELECT ADMIN_LEVEL FROM admin WHERE ADMIN_SESSION = ?';
    $statement_query_admin_level = $pdo->prepare($sql_query_admin_level);
    $statement_query_admin_level->bindParam(1, $session);
    $statement_query_admin_level->execute();

    $query_result = $statement_query_admin_level->fetch(PDO::FETCH_ASSOC);

    return $query_result['ADMIN_LEVEL'];
}

//函式：詢問訂單是否無細項，若無則歸零其總額
function rectify_empty_order($pdo, $order_id)
{
    $sql_query_order_details = 'SELECT * FROM order_details
    WHERE FK_ORDER_ID_for_ODD = ? && ORDER_DETAIL_VISIBLE_ON_WEB != 0';

    $statement_query_order_details = $pdo->prepare($sql_query_order_details);
    $statement_query_order_details->bindParam(1, $order_id);
    $statement_query_order_details->execute();

    $query_result = $statement_query_order_details->fetchAll(PDO::FETCH_ASSOC);

    if ($query_result == false || null) {
        // 執行：根據輸入資料更新訂單資料
        $amount = 0;
        $sql_update_order_data = "UPDATE orders SET ORDER_TOTAL_CONSUMPTION = ? WHERE ORDER_ID = ? && ORDER_VISIBLE_ON_WEB != 0";
        $statement_update_order_data = $pdo->prepare($sql_update_order_data);
        $statement_update_order_data->bindParam(1, $amount);
        $statement_update_order_data->bindParam(2, $order_id);
        $statement_update_order_data->execute();
    }
}
