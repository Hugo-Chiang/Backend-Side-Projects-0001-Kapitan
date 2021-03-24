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

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    echo '您的權限不足以執行這項操作！';
} else {

    $member_account = $edited_details->memberAccount;
    $member_password = hash('sha256', $edited_details->memberPassword);
    $visible = 1;

    // 執行：二次把關會員帳號（電郵）是否有重複註冊
    $sql_query_member_account = 'SELECT * FROM members WHERE MEMBER_ACCOUNT LIKE ? && MEMBER_VISIBLE_ON_WEB != 0';

    $statement_query_member_account = $pdo->prepare($sql_query_member_account);
    $statement_query_member_account->bindParam(1, $member_account);
    $statement_query_member_account->execute();

    $query_result = $statement_query_member_account->fetch(PDO::FETCH_ASSOC);

    if ($query_result != null && $query_result['MEMBER_ACCOUNT'] == $member_account) {

        echo '信箱 ' . $member_account . ' 已被註冊過。請再檢查一次！';
    } else {
        $member_id = insert_max_id($pdo, 'members');

        $sql_insert_member_info = "INSERT INTO members 
            (MEMBER_ID, MEMBER_REGISTERED_DATE, MEMBER_STATUS, MEMBER_ACCOUNT, MEMBER_PASSWORD, 
            MEMBER_NAME, MEMBER_PHONE, MEMBER_AVATAR_URL, 
            MEMBER_EC_NAME, MEMBER_EC_PHONE, MEMBER_EC_EMAIL, MEMBER_VISIBLE_ON_WEB) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement_insert_member_info = $pdo->prepare($sql_insert_member_info);
        $statement_insert_member_info->bindParam(1, $member_id);
        $statement_insert_member_info->bindParam(2, $edited_details->memberRegDate);
        $statement_insert_member_info->bindParam(3, $edited_details->memberStatus);
        $statement_insert_member_info->bindParam(4, $member_account);
        $statement_insert_member_info->bindParam(5, $member_password);
        $statement_insert_member_info->bindParam(6, $edited_details->MCname);
        $statement_insert_member_info->bindParam(7, $edited_details->MCphone);
        $statement_insert_member_info->bindParam(8, $edited_details->memberAvatarURL);
        $statement_insert_member_info->bindParam(9, $edited_details->ECname);
        $statement_insert_member_info->bindParam(10, $edited_details->ECphone);
        $statement_insert_member_info->bindParam(11, $edited_details->ECemail);
        $statement_insert_member_info->bindParam(12, $visible);
        $statement_insert_member_info->execute();

        echo '會員 ' . $member_id . ' 新增完成了！';
    }
}
