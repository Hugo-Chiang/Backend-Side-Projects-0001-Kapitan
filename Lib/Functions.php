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
