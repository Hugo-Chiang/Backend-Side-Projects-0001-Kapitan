<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

$session_string = file_get_contents("php://input");

// 執行：查詢持有該 session 管理員的個資，並回傳前端
$sql_query_admin_info = 'SELECT ADMIN_NAME, ADMIN_LEVEL, ADMIN_AVATAR_URL FROM admin WHERE ADMIN_SESSION = ?';
$statement_query_admin_info = $pdo->prepare($sql_query_admin_info);
$statement_query_admin_info->bindParam(1, $session_string);
$statement_query_admin_info->execute();

$query_result = $statement_query_admin_info->fetch(PDO::FETCH_ASSOC);

// 為前端翻譯資料意義：管理權限部分
switch ($query_result['ADMIN_LEVEL']) {
    case 1:
        $admin_level = '超級管理員';
        break;
    case 2:
        $admin_level = '一般管理員';
        break;
    case 3:
        $admin_level = '測試管理員';
        break;
    default:
        $admin_level = '測試管理員';
        break;
}

$return_obj = (object)[
    'adminName' => $query_result['ADMIN_NAME'],
    'adminLevel' => $admin_level,
    'adminAvatarUrl' => $query_result['ADMIN_AVATAR_URL'],
];

print json_encode($return_obj);
