<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

// 執行：查詢現有登入 session 是否存在（有效），並找出持有人是誰
$sql_query_member_session = 'SELECT MEMBER_ID, MEMBER_ACCOUNT FROM members WHERE MEMBER_SESSION = ?';
$statement_query_member_session = $pdo->prepare($sql_query_member_session);
$statement_query_member_session->bindParam(1, $json_data->session);
$statement_query_member_session->execute();

$query_result = $statement_query_member_session->fetch(PDO::FETCH_ASSOC);

// 若　session　無效，向前端返回錯誤訊息，反之則回傳詢問的相關資訊
if ($query_result == null) {
    // 執行：查詢驗證失效者帳號的最後登入時間，回饋予前端使用者參考
    $sql_query_member_id = 'SELECT MEMBER_SIGNIN_TIME FROM members WHERE MEMBER_ID = ?';
    $statement_query_member_id = $pdo->prepare($sql_query_member_id);
    $statement_query_member_id->bindParam(1, $json_data->ID);
    $statement_query_member_id->execute();

    $query_result = $statement_query_member_id->fetch(PDO::FETCH_ASSOC);

    $return_obj = (object)[
        'sessionCheck' => false,
        'message' => '無效的登入對話！',
        'signInTime' => $query_result['MEMBER_SIGNIN_TIME'],
    ];
} else {

    $return_obj = (object)[
        'sessionCheck' => true,
        'signInedID' => $query_result['MEMBER_ID'],
        'signInedAccount' => $query_result['MEMBER_ACCOUNT'],
    ];
}

print json_encode($return_obj);
