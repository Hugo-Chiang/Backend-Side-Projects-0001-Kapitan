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

// 執行：根據輸入帳密找出特定登入者
$sql_query_admin_account = 'SELECT ADMIN_ID FROM admin WHERE ADMIN_ACCOUNT = ? && ADMIN_PASSWORD = ?';
$statement_query_admin_account = $pdo->prepare($sql_query_admin_account);
$statement_query_admin_account->bindParam(1, $json_data->account);
$statement_query_admin_account->bindParam(2, $json_data->password);
$statement_query_admin_account->execute();

$query_result = $statement_query_admin_account->fetch(PDO::FETCH_ASSOC);

// 帳密錯誤向前端返回錯誤訊息，並中止程式碼執行
if ($query_result == null) {
    $return_obj = (object)[
        'singInStatus' => false,
        'message' => '帳號或密碼錯誤'
    ];

    print json_encode($return_obj);
    exit;
}

$admin_id = $query_result['ADMIN_ID'];

// 執行：根據輸入帳密找出特定登入者及其身分識別號（ADMIN_IDENTIFIER）
$sql_query_admin_identifier = 'SELECT ADMIN_IDENTIFIER FROM admin WHERE ADMIN_ID = ?';
$statement_query_admin_identifier = $pdo->prepare($sql_query_admin_identifier);
$statement_query_admin_identifier->bindParam(1, $admin_id);
$statement_query_admin_identifier->execute();

$query_result = $statement_query_admin_identifier->fetch(PDO::FETCH_ASSOC);

// 產生新的登入用 token
$basic_token = (function () {
    $resource = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $garbled = '';

    for ($i = 0; $i < 20; $i++) {
        $garbled .= $resource[rand(0, 20 - 1)];
    }

    return $garbled;
})();

$new_token = str_shuffle($basic_token . $query_result['ADMIN_IDENTIFIER']);

// 執行：將新 toke 寫入資料庫，並連帶產生到期日
$time_now = time();
$exp_time = $time_now + (60 * 60 * 24 * 7);
$exp_time = date("Y-m-d H:i:s", $exp_time);

$sql_update_new_token = 'UPDATE admin SET ADMIN_TOKEN = ?, ADMIN_SIGNIN_TIMEOUT= ? WHERE ADMIN_ID = ?';
$statement_update_new_token = $pdo->prepare($sql_update_new_token);
$statement_update_new_token->bindParam(1, $new_token);
$statement_update_new_token->bindParam(2, $exp_time);
$statement_update_new_token->bindParam(3, $admin_id);
$statement_update_new_token->execute();

// 執行：將新 toke 與到期日回傳予前端，以利進行登入驗證
$sql_query_admin_signedin_data = "SELECT ADMIN_NAME, ADMIN_TOKEN, ADMIN_SIGNIN_TIMEOUT FROM admin WHERE ADMIN_ID = ?";
$statement_query_admin_signedin_data = $pdo->prepare($sql_query_admin_signedin_data);
$statement_query_admin_signedin_data->bindParam(1, $admin_id);
$statement_query_admin_signedin_data->execute();

$query_result = $statement_query_admin_signedin_data->fetch(PDO::FETCH_ASSOC);

$return_obj = (object)[
    'singInStatus' => true,
    'message' => '歡迎回來，' . $query_result['ADMIN_NAME'],
    'token' => $query_result['ADMIN_TOKEN'],
    'expDate' => $query_result['ADMIN_SIGNIN_TIMEOUT']
];

print json_encode($return_obj);
