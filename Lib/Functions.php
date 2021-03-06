<?php

// 函式：判斷並寫入最新編號
function aa($pdo, $table_name, $id_name)
{
    // $table_id_prefix = '';
    // $table_id_number_length = 0;

    switch($id_name){
        case 'orders':
            $table_id_template = 'OD0000000';
            break;
        case 'order_details':
            $table_id_template = 'ODD0000000000';
            break;
        case 'booking':
            $table_id_template = 'BK0000000000';
            break;
    }

    $template_split_arr = split('', $table_id_template);
    $count_num = array_count_values($template_split_arr);
    $id_num_len = $count_num['0'];
    $id_num_index = array_search('0', $template_split_arr);
    $id_pefix = substr($table_id_template, 0, $id_num_index);
    $id_num_template = substr($table_id_template, $id_num_index);

    $table_max_id = "SELECT max($id_name) FROM $table_name";
    $table_max_id == null ? $table_max_id = $id_pefix.$id_num_template : $table_max_id ;

    $statement_table_max_id = $pdo->prepare($table_max_id);
    $statement_table_max_id->execute();
    $select_max_id = $statement_table_max_id->fetch();

    // 做到這裡
    $id_number_length = substr($select_max_id[0], 2, 7);

    $id_max_number = (int)substr($select_max_id[0], 2, 7) + 1;
    $insert_id = "";

    if ($id_max_number < 10) {
        $insert_id = "OD000000" . $id_max_number;
    } else if ($id_max_number < 100 && $id_max_number >= 10) {
        $insert_id = "OD00000" . $id_max_number;
    } else if ($id_max_number < 1000 && $id_max_number >= 100) {
        $insert_id = "OD0000" . $maxNumber;
    } else if ($id_max_number < 10000 && $id_max_number >= 1000) {
        $insert_id = "OD000" . $maxNumber;
    } else if ($id_max_number < 100000 && $maxNumber >= 10000) {
        $insert_id = "OD00" . $id_max_number;
    }

    return
}


?>
.