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
