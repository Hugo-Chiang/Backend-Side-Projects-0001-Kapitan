<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

$session = $json_data->session;
$member_id =  $json_data->memberID;
$edited_details = $json_data->editedDetails;

// 執行：檢查 session 與會員編號是否正確對應
$sql_query_session = "SELECT MEMBER_SESSION FROM members WHERE MEMBER_ID = ? && MEMBER_VISIBLE_ON_WEB != 0";
$statement_query_session = $pdo->prepare($sql_query_session);
$statement_query_session->bindParam(1, $member_id);
$statement_query_session->execute();

$query_result = $statement_query_session->fetch(PDO::FETCH_ASSOC);

if ($session == $query_result['MEMBER_SESSION']) {

    $sql_update_member_info = "UPDATE members SET MEMBER_NICKNAME = ?, 
    MEMBER_NAME = ?, MEMBER_PHONE = ?, MEMBER_AVATAR_URL = ?, MEMBER_NICKNAME = ?, 
    MEMBER_EC_NAME = ?, MEMBER_EC_PHONE = ?, MEMBER_EC_EMAIL = ? 
    WHERE MEMBER_ID = ? && MEMBER_VISIBLE_ON_WEB != 0";
    $statement_update_member_info = $pdo->prepare($sql_update_member_info);
    $statement_update_member_info->bindParam(1, $edited_details->nickName);
    $statement_update_member_info->bindParam(2, $edited_details->MCname);
    $statement_update_member_info->bindParam(3, $edited_details->MCphone);
    $statement_update_member_info->bindParam(4, $edited_details->memberAvatarURL);
    $statement_update_member_info->bindParam(5, $edited_details->nickName);
    $statement_update_member_info->bindParam(6, $edited_details->ECname);
    $statement_update_member_info->bindParam(7, $edited_details->ECphone);
    $statement_update_member_info->bindParam(8, $edited_details->ECemail);
    $statement_update_member_info->bindParam(9, $member_id);
    $statement_update_member_info->execute();

    echo '您的個資修改完成了！';
} else {

    echo '驗證資訊不正確！請您重新登入，再試一次。';
}
