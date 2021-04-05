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
$member_id =  $json_data->memberID;
$edited_details = $json_data->editedDetails;

// 判斷：若會員打算重設密碼，則進行新的加密活動
if ($edited_details->reSetPassword == '') {

    $sql_query_password = "SELECT MEMBER_PASSWORD FROM members WHERE MEMBER_ID = ? && MEMBER_VISIBLE_ON_WEB != 0";
    $statement_query_password = $pdo->prepare($sql_query_password);
    $statement_query_password->bindParam(1, $member_id);
    $statement_query_password->execute();

    $query_result = $statement_query_password->fetch(PDO::FETCH_ASSOC);

    $member_password = $query_result['MEMBER_PASSWORD'];
} else {

    $member_password = hash('sha256', $edited_details->memberPassword);
}

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    if ($testing == 1) {

        // 執行：根據輸入資料更新會員資訊
        $sql_update_member_info = "UPDATE members SET 
        MEMBER_REGISTERED_DATE = ?, MEMBER_ACCOUNT = ?, MEMBER_PASSWORD = ?, 
        MEMBER_NAME = ?, MEMBER_PHONE = ?, MEMBER_AVATAR_URL = ?, 
        MEMBER_EC_NAME = ?, MEMBER_EC_PHONE = ?, MEMBER_EC_EMAIL = ? 
        WHERE MEMBER_ID = ? && MEMBER_VISIBLE_ON_WEB != 0";
        $statement_update_member_info = $pdo->prepare($sql_update_member_info);
        $statement_update_member_info->bindParam(1, $edited_details->memberRegDate);
        $statement_update_member_info->bindParam(2, $edited_details->memberAccount);
        $statement_update_member_info->bindParam(3, $member_password);
        $statement_update_member_info->bindParam(4, $edited_details->MCname);
        $statement_update_member_info->bindParam(5, $edited_details->MCphone);
        $statement_update_member_info->bindParam(6, $edited_details->memberAvatarURL);
        $statement_update_member_info->bindParam(7, $edited_details->ECname);
        $statement_update_member_info->bindParam(8, $edited_details->ECphone);
        $statement_update_member_info->bindParam(9, $edited_details->ECemail);
        $statement_update_member_info->bindParam(10, $member_id);
        $statement_update_member_info->execute();

        echo '會員 ' . $member_id . ' 的資料修改完成了！';
    } else {
        echo '您的權限不足以執行這項操作！';
    }
} else {

    // 執行：根據輸入資料更新會員資訊
    $sql_update_member_info = "UPDATE members SET 
    MEMBER_REGISTERED_DATE = ?, MEMBER_STATUS = ?, MEMBER_ACCOUNT = ?, MEMBER_PASSWORD = ?, 
    MEMBER_NAME = ?, MEMBER_PHONE = ?, MEMBER_AVATAR_URL = ?, 
    MEMBER_EC_NAME = ?, MEMBER_EC_PHONE = ?, MEMBER_EC_EMAIL = ? 
    WHERE MEMBER_ID = ? && MEMBER_VISIBLE_ON_WEB != 0";
    $statement_update_member_info = $pdo->prepare($sql_update_member_info);
    $statement_update_member_info->bindParam(1, $edited_details->memberRegDate);
    $statement_update_member_info->bindParam(2, $edited_details->memberStatus);
    $statement_update_member_info->bindParam(3, $edited_details->memberAccount);
    $statement_update_member_info->bindParam(4, $member_password);
    $statement_update_member_info->bindParam(5, $edited_details->MCname);
    $statement_update_member_info->bindParam(6, $edited_details->MCphone);
    $statement_update_member_info->bindParam(7, $edited_details->memberAvatarURL);
    $statement_update_member_info->bindParam(8, $edited_details->ECname);
    $statement_update_member_info->bindParam(9, $edited_details->ECphone);
    $statement_update_member_info->bindParam(10, $edited_details->ECemail);
    $statement_update_member_info->bindParam(11, $member_id);
    $statement_update_member_info->execute();

    echo '會員 ' . $member_id . ' 的資料修改完成了！';
}
