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
$reSetPasswordData = $json_data->reSetPasswordData;

// 執行：檢查 session 與會員編號是否正確對應
$sql_query_session = "SELECT MEMBER_SESSION FROM members WHERE MEMBER_ID = ? && MEMBER_VISIBLE_ON_WEB != 0";
$statement_query_session = $pdo->prepare($sql_query_session);
$statement_query_session->bindParam(1, $member_id);
$statement_query_session->execute();

$query_result = $statement_query_session->fetch(PDO::FETCH_ASSOC);

if ($session == $query_result['MEMBER_SESSION']) {

    // 執行：檢查原密碼是否輸入正確
    $sql_query_password = "SELECT MEMBER_PASSWORD FROM members WHERE MEMBER_ID = ? && MEMBER_VISIBLE_ON_WEB != 0";
    $statement_query_password = $pdo->prepare($sql_query_password);
    $statement_query_password->bindParam(1, $member_id);
    $statement_query_password->execute();

    $query_result = $statement_query_password->fetch(PDO::FETCH_ASSOC);

    $member_original_password = hash('sha256', $reSetPasswordData->originalPassword);


    if ($member_original_password == $query_result['MEMBER_PASSWORD']) {

        $member_new_password = hash('sha256', $reSetPasswordData->newPassword);

        $sql_update_member_info = "UPDATE members SET MEMBER_PASSWORD = ? 
        WHERE MEMBER_ID = ? && MEMBER_VISIBLE_ON_WEB != 0";
        $statement_update_member_info = $pdo->prepare($sql_update_member_info);
        $statement_update_member_info->bindParam(1, $member_new_password);
        $statement_update_member_info->bindParam(2, $member_id);
        $statement_update_member_info->execute();

        echo '您的密碼修改完成了！';
    } else {

        echo '原密碼輸入錯誤！請再試一次。';
    }
} else {

    echo '驗證資訊不正確！建議您重新登入，再試一次。';
}
