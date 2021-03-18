<?php

// 導入並設定 CORS 權限
$allow_methods = 'GET';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

$sqlQueryMemberContactInfo =
    "SELECT MEMBER_NAME, MEMBER_PHONE, MEMBER_ACCOUNT, MEMBER_EC_NAME, MEMBER_EC_PHONE, MEMBER_EC_EMAIL 
FROM members WHERE MEMBER_ID = 'MB0000001'";

$result = $pdo->query($sqlQueryMemberContactInfo);
$data = $result->fetchAll();

print json_encode($data);
