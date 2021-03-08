<?php

// 設定 CORS 權限
header("Access-Control-Allow-Origin: *");
header("Content-Type:text/html; charset=utf-8");
// header("Access-Control-Allow-Origin: https://side-projects-01-kapitan.herokuapp.com");
// header('Access-Control-Allow-Methods: GET');

// 導入 PDO 以安全連線資練庫
include("../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

$sql_query_admin_account = 'SELECT ADMIN_NAME FROM admin WHERE ADMIN_ACCOUNT = ? && ADMIN_PASSWORD = ?';
$statement_query_admin_account = $pdo->prepare($sql_query_admin_account);
$statement_query_admin_account->bindParam(1, $json_data->account);
$statement_query_admin_account->bindParam(2, $json_data->password);
$statement_query_admin_account->execute();

$query_result = $statement_query_admin_account->fetch(PDO::FETCH_ASSOC);

if ($query_result == null) {
    $return_obj = (object)[
        'status' => '登入失敗',
        'message' => '帳號或密碼錯誤'
    ];
} else {
    $return_obj = (object)[
        'status' => '登入成功',
        'message' => '歡迎回來，' . $query_result['ADMIN_NAME']
    ];
}

print json_encode($return_obj);
