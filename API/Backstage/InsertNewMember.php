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

$member_id = insert_max_id($pdo, 'members');
$member_account = $edited_details->memberAccount;
$member_password = hash('sha256', $edited_details->memberPassword);
$fake_session = 1;
$signin_authentication = 0;
$visible = 1;

// 執行：二次把關會員帳號（電郵）是否有重複註冊，若有則中斷程式碼
$sql_query_member_account = 'SELECT * FROM members WHERE MEMBER_ACCOUNT LIKE ? && MEMBER_VISIBLE_ON_WEB != 0';

$statement_query_member_account = $pdo->prepare($sql_query_member_account);
$statement_query_member_account->bindParam(1, $member_account);
$statement_query_member_account->execute();

$query_result = $statement_query_member_account->fetch(PDO::FETCH_ASSOC);

if ($query_result != null && $query_result['MEMBER_ACCOUNT'] == $member_account) {

    echo '信箱 ' . $member_account . ' 已被註冊過。請再檢查一次！';
    exit;
}

// 透過 session 判斷管理員權限所建會員是否僅供測試
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {
    $testing = 1;
    $member_status = -1;
    $MCname = $edited_details->MCname;

    if ($MCname == '') {
        $MCname = '測試名稱';
    }

    $prefix_index = strpos($MCname, '（測試項目）');
    $str_len = strlen('（測試項目）');

    if ($prefix_index === 0) {
        $MCname  = substr($MCname, $prefix_index + $str_lens);
    }

    $MCname  = '（測試項目）' . $MCname;
} else {

    $testing = 0;
    $member_status = $edited_details->memberStatus;
    $MCname = $edited_details->MCname;
}

// 執行：根據輸入資料建立新會員
$sql_insert_member_info = "INSERT INTO members 
(MEMBER_ID, MEMBER_REGISTERED_DATE, MEMBER_STATUS, MEMBER_ACCOUNT, MEMBER_PASSWORD, 
MEMBER_NICKNAME, MEMBER_NAME, MEMBER_PHONE, MEMBER_AVATAR_URL, 
MEMBER_EC_NAME, MEMBER_EC_PHONE, MEMBER_EC_EMAIL, 
MEMBER_SESSION, MEMBER_SIGNIN_TIMEOUT, MEMBER_SIGNIN_AUTHENTICATION, 
MEMBER_VISIBLE_ON_WEB, MEMBER_FOR_TESTING) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)";
$statement_insert_member_info = $pdo->prepare($sql_insert_member_info);
$statement_insert_member_info->bindParam(1, $member_id);
$statement_insert_member_info->bindParam(2, $edited_details->memberRegDate);
$statement_insert_member_info->bindParam(3, $member_status);
$statement_insert_member_info->bindParam(4, $member_account);
$statement_insert_member_info->bindParam(5, $member_password);
$statement_insert_member_info->bindParam(6, $edited_details->nickname);
$statement_insert_member_info->bindParam(7, $MCname);
$statement_insert_member_info->bindParam(8, $edited_details->MCphone);
$statement_insert_member_info->bindParam(9, $edited_details->memberAvatarURL);
$statement_insert_member_info->bindParam(10, $edited_details->ECname);
$statement_insert_member_info->bindParam(11, $edited_details->ECphone);
$statement_insert_member_info->bindParam(12, $edited_details->ECemail);
$statement_insert_member_info->bindParam(13, $fake_session);
$statement_insert_member_info->bindParam(14, $signin_authentication);
$statement_insert_member_info->bindParam(15, $visible);
$statement_insert_member_info->bindParam(16, $testing);
$statement_insert_member_info->execute();

echo '會員 ' . $member_id . ' 新增完成了！';
