<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$member_id = file_get_contents("php://input");

// 執行：
$sql_query_member_info = 'SELECT * FROM members WHERE MEMBER_ID = ? && MEMBER_VISIBLE_ON_WEB != 0';

$statement_query_member_info = $pdo->prepare($sql_query_member_info);
$statement_query_member_info->bindParam(1, $member_id);
$statement_query_member_info->execute();

$query_result = $statement_query_member_info->fetch(PDO::FETCH_ASSOC);

print json_encode($query_result);
