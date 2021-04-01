<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$member_account = file_get_contents("php://input");

// 執行：根據關鍵詞查詢相關會員
$sql_query_member_account = 'SELECT * FROM members WHERE MEMBER_ACCOUNT LIKE ? && MEMBER_VISIBLE_ON_WEB != 0';

$statement_query_member_account = $pdo->prepare($sql_query_member_account);
$statement_query_member_account->bindParam(1, $member_account);
$statement_query_member_account->execute();

$query_result = $statement_query_member_account->fetch(PDO::FETCH_ASSOC);

print json_encode($query_result);
