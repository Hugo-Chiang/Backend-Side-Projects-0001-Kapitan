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
$member_id = $json_data->memberID;

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    echo '您的權限不足以執行這項操作！';
} else {

    $sql_delete_member = "UPDATE members SET MEMBER_VISIBLE_ON_WEB = 0 WHERE MEMBER_ID = ?";
    $statement_delete_member = $pdo->prepare($sql_delete_member);
    $statement_delete_member->bindParam(1, $member_id);
    $statement_delete_member->execute();

    echo '會員 ' . $member_id . ' 已被刪除了。';
}
