<?php

// 設定 CORS 權限
// header("Access-Control-Allow-Origin: *");
// header("Content-Type:text/html; charset=utf-8");
header("Access-Control-Allow-Origin: https://fe-sp-0001-kapitan.herokuapp.com");
header('Access-Control-Allow-Methods: POST');

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$session_string = file_get_contents("php://input");

// 執行：查詢現有登入 session 是否存在（有效），並找出持有人是誰
$sql_query_admin_session = 'SELECT ADMIN_ID FROM admin WHERE ADMIN_SESSION = ?';
$statement_query_admin_session = $pdo->prepare($sql_query_admin_session);
$statement_query_admin_session->bindParam(1, $session_string);
$statement_query_admin_session->execute();

$query_result = $statement_query_admin_session->fetch(PDO::FETCH_ASSOC);

// 若　session　無效，向前端返回錯誤訊息，並中止程式碼執行
if ($query_result == null) {
    $return_obj = (object)[
        'sessionCheck' => false,
        'message' => '無效的登入對話！'
    ];

    print json_encode($return_obj);
    exit;
}

// 執行：將登入驗證狀態（true，1）寫入資料庫
$sql_update_signin_auth = 'UPDATE admin SET ADMIN_SIGNIN_AUTHENTICATION = "1" WHERE ADMIN_ID = ?';
$statement_update_signin_authn = $pdo->prepare($sql_update_signin_auth);
$statement_update_signin_authn->bindParam(1, $query_result['ADMIN_ID']);
$statement_update_signin_authn->execute();

// 執行：將 session 檢查成功的訊息回傳前端（准許前進），並親切地打聲招呼
$sql_query_admin_signedin_data = "SELECT ADMIN_NAME FROM admin WHERE ADMIN_SESSION = ?";
$statement_query_admin_signedin_data = $pdo->prepare($sql_query_admin_signedin_data);
$statement_query_admin_signedin_data->bindParam(1, $session_string);
$statement_query_admin_signedin_data->execute();

$query_result = $statement_query_admin_signedin_data->fetch(PDO::FETCH_ASSOC);

$return_obj = (object)[
    'sessionCheck' => true,
    'message' => '歡迎回來，' . $query_result['ADMIN_NAME'],
];

print json_encode($return_obj);
