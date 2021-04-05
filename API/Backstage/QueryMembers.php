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

// 拼接：根據是否有查詢姓名或電話，拼接不同的 SQL 查詢語法，以增進搜尋正確度
$sql_query_members_name_input_part = '';
$sql_query_members_phone_input_part = '';

foreach ($json_data as $properity => $value) {
    if ($value != "") {
        switch ($properity) {
            case 'memberName':
                $sql_query_members_name_input_part = ' && MEMBER_NAME LIKE ?';
                break;
            case 'memberPhone':
                $sql_query_members_phone_input_part = ' && MEMBER_PHONE LIKE ?';
                break;
        }
    }
    $json_data->$properity = '%' . $value . '%';
}

// 執行：根據關鍵詞查詢相關會員
$sql_query_members_main_part = 'SELECT * FROM members WHERE MEMBER_ID LIKE ? && MEMBER_STATUS LIKE ? && MEMBER_ACCOUNT LIKE ?';
$sql_query_members_name_uninput_part = ' && (MEMBER_NAME LIKE ? || MEMBER_NAME IS NULL)';
$sql_query_members_phone_uninput_part = ' && (MEMBER_PHONE LIKE ? || MEMBER_PHONE IS NULL)';
$sql_query_members_rest_part = ' && MEMBER_VISIBLE_ON_WEB != 0';

if ($sql_query_members_name_input_part != '' && $sql_query_members_phone_input_part == '') {

    $sql_query_members = $sql_query_members_main_part . $sql_query_members_name_input_part
        . $sql_query_members_phone_uninput_part . $sql_query_members_rest_part;
} else if ($sql_query_members_name_input_part == '' && $sql_query_members_phone_input_part != '') {

    $sql_query_members = $sql_query_members_main_part . $sql_query_members_name_uninput_part
        . $sql_query_members_phone_input_part . $sql_query_members_rest_part;
} else if ($sql_query_members_name_input_part != '' && $sql_query_members_phone_input_part != '') {

    $sql_query_members = $sql_query_members_main_part . $sql_query_members_name_input_part
        . $sql_query_members_phone_input_parts . $sql_query_members_rest_part;
} else {

    $sql_query_members = $sql_query_members_main_part . $sql_query_members_name_uninput_part
        . $sql_query_members_phone_uninput_part . $sql_query_members_rest_part;
}

$statement_query_members = $pdo->prepare($sql_query_members);
$statement_query_members->bindParam(1, $json_data->memberID);
$statement_query_members->bindParam(2, $json_data->memberStatus);
$statement_query_members->bindParam(3, $json_data->memberAccount);
$statement_query_members->bindParam(4, $json_data->memberName);
$statement_query_members->bindParam(5, $json_data->memberPhone);
$statement_query_members->execute();

$query_result = $statement_query_members->fetchAll(PDO::FETCH_ASSOC);

if ($query_result == null) {
    $query_result = (array)[];
} else {
    foreach ($query_result as $index => $sub_arr) {
        $sort_index = find_out_serial('members', $sub_arr['MEMBER_ID']);
        $query_result[$index]['SORT_INDEX'] = $sort_index;
    }
}

print json_encode($query_result);
