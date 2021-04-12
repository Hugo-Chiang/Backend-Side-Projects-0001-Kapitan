<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");
// 導入自定義函式庫
include("../../Lib/Functions.php");

// 接收前端字串資料
$email = file_get_contents("php://input");

// 執行：查詢輸入電郵是否已經訂閱。若有，則通知前端並中止程式碼
$sql_query_subscribed = 'SELECT * FROM edm_list WHERE EDM_ADDRESS LIKE ?';

$statement_query_subscribed = $pdo->prepare($sql_query_subscribed);
$statement_query_subscribed->bindParam(1, $email);
$statement_query_subscribed->execute();

$query_result = $statement_query_subscribed->fetch(PDO::FETCH_ASSOC);

if ($query_result != null) {

    $subscribed_email = $query_result['EDM_ADDRESS'];

    // 向前端回傳結果：重複訂閱
    $return_obj = (object)[
        'status' => false,
        'message' => '<p>信箱【 ' . $subscribed_email . ' 】已經訂閱電子報了。如欲取消，請來信<a href="mailto:service@Kapitan.com"> service@Kapitan.com </a>聯絡甲必丹客服。</p><p>謝謝您的支持！</p>',
    ];

    print json_encode($return_obj);
    exit;
}

// 執行：根據輸入資料建立新會員
$edm_id = insert_max_id($pdo, 'edm_list');
$status = 1;

$sql_insert_new_subscription = "INSERT INTO edm_list 
(EDM_ID, EDM_REGISTERED_DATE, EDM_STATUS, EDM_ADDRESS) 
VALUES (?, NOW(), ?, ?)";
$statement_insert_new_subscription = $pdo->prepare($sql_insert_new_subscription);
$statement_insert_new_subscription->bindParam(1, $edm_id);
$statement_insert_new_subscription->bindParam(2, $status);
$statement_insert_new_subscription->bindParam(3, $email);
$statement_insert_new_subscription->execute();

// 向前端回傳結果：訂閱成功
$return_obj = (object)[
    'status' => true,
    'message' => '感謝您訂閱甲必丹電子報！',
];

print json_encode($return_obj);
