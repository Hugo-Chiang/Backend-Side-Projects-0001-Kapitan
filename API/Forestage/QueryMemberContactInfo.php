<?php

header("Access-Control-Allow-Origin: http://localhost:8080");
// header("Access-Control-Allow-Origin: https://fe-sp-0001-kapitan.herokuapp.com");
header('Access-Control-Allow-Methods: GET');
header("Content-Type:text/html; charset=utf-8");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

$sqlQueryMemberContactInfo =
    "SELECT MEMBER_NAME, MEMBER_PHONE, MEMBER_ACCOUNT, MEMBER_EC_NAME, MEMBER_EC_PHONE, MEMBER_EC_EMAIL 
FROM members WHERE MEMBER_ID = 'MB0000001'";

$result = $pdo->query($sqlQueryMemberContactInfo);
$data = $result->fetchAll();

print json_encode($data);
