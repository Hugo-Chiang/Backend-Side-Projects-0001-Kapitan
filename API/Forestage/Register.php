<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");
// 導入自定義函式庫
include("../../Lib/Functions.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

$member_account = $json_data->account;
$member_password = hash('sha256', $json_data->password);
$status = 1;
$visible = 1;
$sigin_auth = 1;

// 執行：二次把關會員帳號（電郵）是否有重複註冊
$sql_query_member_account = 'SELECT * FROM members WHERE MEMBER_ACCOUNT LIKE ? && MEMBER_VISIBLE_ON_WEB != 0';

$statement_query_member_account = $pdo->prepare($sql_query_member_account);
$statement_query_member_account->bindParam(1, $member_account);
$statement_query_member_account->execute();

$query_result = $statement_query_member_account->fetch(PDO::FETCH_ASSOC);

if ($query_result != null && $query_result['MEMBER_ACCOUNT'] == $member_account) {

    echo '信箱 ' . $member_account . ' 已被註冊過。請再檢查一次！';
} else {

    // 執行：依據使用者填寫的資料創建會員（註冊）
    $member_id = insert_max_id($pdo, 'members');

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

    $sql_insert_member_info = "INSERT INTO members 
    (MEMBER_ID, MEMBER_REGISTERED_DATE, MEMBER_STATUS, MEMBER_ACCOUNT, MEMBER_PASSWORD, 
    MEMBER_SESSION, MEMBER_SIGNIN_TIMEOUT, MEMBER_SIGNIN_AUTHENTICATION, MEMBER_VISIBLE_ON_WEB) 
    VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?)";
    $statement_insert_member_info = $pdo->prepare($sql_insert_member_info);
    $statement_insert_member_info->bindParam(1, $member_id);
    $statement_insert_member_info->bindParam(2, $status);
    $statement_insert_member_info->bindParam(3, $member_account);
    $statement_insert_member_info->bindParam(4, $member_password);
    $statement_insert_member_info->bindParam(5, $session);
    $statement_insert_member_info->bindParam(6, $exp_time);
    $statement_insert_member_info->bindParam(7, $sigin_auth);
    $statement_insert_member_info->bindParam(8, $visible);
    $statement_insert_member_info->execute();

    // 執行：將 session 與到期日回傳予前端，以利進行登入驗證
    $sql_query_member_signedin_data = "SELECT MEMBER_SESSION, MEMBER_SIGNIN_TIMEOUT FROM members WHERE MEMBER_ID = ?";
    $statement_query_member_signedin_data = $pdo->prepare($sql_query_member_signedin_data);
    $statement_query_member_signedin_data->bindParam(1, $member_id);
    $statement_query_member_signedin_data->execute();

    $query_result = $statement_query_member_signedin_data->fetch(PDO::FETCH_ASSOC);

    $return_obj = (object)[
        'singInStatus' => true,
        'session' => $query_result['MEMBER_SESSION'],
        'expDate' => $query_result['MEMBER_SIGNIN_TIMEOUT'],
        'message' => '太好了！您已成為甲必丹的會員了。<p>現將引導您回到首頁...</p>'
    ];

    print json_encode($return_obj);
}
