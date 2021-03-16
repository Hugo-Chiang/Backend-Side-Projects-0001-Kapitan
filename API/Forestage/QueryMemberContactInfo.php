<?php

// header("Access-Control-Allow-Origin: *");
// header("Content-Type:text/html; charset=utf-8");
header("Access-Control-Allow-Origin: https://side-projects-01-kapitan.herokuapp.com");
header('Access-Control-Allow-Methods: GET');

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

$sqlQueryMemberContactInfo =
    "SELECT MEMBER_NAME, MEMBER_PHONE, MEMBER_ACCOUNT, MEMBER_EC_NAME, MEMBER_EC_PHONE, MEMBER_EC_EMAIL 
FROM members WHERE MEMBER_ID like 'MB0000001'";

$result = $pdo->query($sqlQueryMemberContactInfo);
$data = $result->fetchAll();

print json_encode($data);
