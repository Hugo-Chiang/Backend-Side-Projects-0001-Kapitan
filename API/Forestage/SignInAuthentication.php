<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$session_string = file_get_contents("php://input");

// 執行：查詢現有登入 session 是否存在（有效），並找出持有人是誰
$sql_query_member_session = 'SELECT MEMBER_ID FROM members WHERE MEMBER_SESSION = ?';
$statement_query_member_session = $pdo->prepare($sql_query_member_session);
$statement_query_member_session->bindParam(1, $session_string);
$statement_query_member_session->execute();

$query_result = $statement_query_member_session->fetch(PDO::FETCH_ASSOC);

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
$sql_update_signin_auth = 'UPDATE members SET MEMBER_SIGNIN_AUTHENTICATION = "1" WHERE MEMBER_ID = ?';
$statement_update_signin_authn = $pdo->prepare($sql_update_signin_auth);
$statement_update_signin_authn->bindParam(1, $query_result['MEMBER_ID']);
$statement_update_signin_authn->execute();

$return_obj = (object)[
    'sessionCheck' => true,
    'signInedID' => $query_result['MEMBER_ID'],
];

print json_encode($return_obj);
