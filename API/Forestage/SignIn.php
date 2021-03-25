<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

// 執行：根據輸入帳密找出特定登入者
$member_password = hash('sha256', $json_data->password);
$sql_query_member_account = 'SELECT MEMBER_ID FROM members WHERE MEMBER_ACCOUNT = ? && MEMBER_PASSWORD = ?';
$statement_query_member_account = $pdo->prepare($sql_query_member_account);
$statement_query_member_account->bindParam(1, $json_data->account);
$statement_query_member_account->bindParam(2, $member_password);
$statement_query_member_account->execute();

$query_result = $statement_query_member_account->fetch(PDO::FETCH_ASSOC);

// 若帳密錯誤，向前端返回錯誤訊息，並中止程式碼執行
if ($query_result == null) {
    $return_obj = (object)[
        'singInStatus' => false,
        'message' => '帳號或密碼錯誤'
    ];

    print json_encode($return_obj);
    exit;
}

// 執行：選出會員登入所用的密鑰，以利建立登入驗證用的 session
$para = 'members';
$sql_query_secret_key = 'SELECT SECRET_KEY_VALUE FROM secret_keys WHERE SECRET_KEY_USAGE = ?';
$statement_query_secret_key = $pdo->prepare($sql_query_secret_key);
$statement_query_secret_key->bindParam(1, $para);
$statement_query_secret_key->execute();

$member_secret_key_row = $statement_query_secret_key->fetch(PDO::FETCH_ASSOC);

// 加密產生 session
$session = hash('sha256', $member_id . $member_secret_key_row['SECRET_KEY_VALUE']);

// 執行：將新 session 寫入資料庫，並連帶產生到期日
$time_now = time();
$exp_time = $time_now + (60 * 60 * 24 * 3);
$exp_time = date("Y-m-d H:i:s", $exp_time);

$sql_update_new_session = 'UPDATE member SET MEMBER_SESSION = ?, MEMBER_SIGNIN_TIMEOUT = ? WHERE MEMBER_ID = ?';
$statement_update_new_session = $pdo->prepare($sql_update_new_session);
$statement_update_new_session->bindParam(1, $session);
$statement_update_new_session->bindParam(2, $exp_time);
$statement_update_new_session->bindParam(3, $member_id);
$statement_update_new_session->execute();

// 執行：將 session 與到期日回傳予前端，以利進行登入驗證
$sql_query_member_signedin_data = "SELECT MEMBER_SESSION, MEMBER_SIGNIN_TIMEOUT FROM members WHERE MEMBER_ID = ?";
$statement_query_member_signedin_data = $pdo->prepare($sql_query_member_signedin_data);
$statement_query_member_signedin_data->bindParam(1, $member_id);
$statement_query_member_signedin_data->execute();

$query_result = $statement_query_member_signedin_data->fetch(PDO::FETCH_ASSOC);

$return_obj = (object)[
    'singInStatus' => true,
    'session' => $query_result['MEMBER_SESSION'],
    'expDate' => $query_result['MEMBER_SIGNIN_TIMEOUT']
];

print json_encode($return_obj);
