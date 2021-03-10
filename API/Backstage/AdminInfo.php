<?php

// 設定 CORS 權限
header("Access-Control-Allow-Origin: *");
header("Content-Type:text/html; charset=utf-8");
// header("Access-Control-Allow-Origin: https://side-projects-01-kapitan.herokuapp.com");
// header('Access-Control-Allow-Methods: GET');

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

$session_string = file_get_contents("php://input");

// 執行：查詢持有該 session 管理員的個資，並回傳前端
$sql_query_admin_info = 'SELECT ADMIN_NAME, ADMIN_AVATAR_URL FROM admin WHERE ADMIN_SESSION = ?';
$statement_query_admin_info = $pdo->prepare($sql_query_admin_info);
$statement_query_admin_info->bindParam(1, $session_string);
$statement_query_admin_info->execute();

$query_result = $statement_query_admin_info->fetch(PDO::FETCH_ASSOC);

$return_obj = (object)[
    'adminName' => $query_result['ADMIN_NAME'],
    'adminAvatarUrl' => $query_result['ADMIN_AVATAR_URL'],
];

print json_encode($return_obj);
