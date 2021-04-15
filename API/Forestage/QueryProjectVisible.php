<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");
// 導入自定義函式庫
include("../../Lib/Functions.php");

// 接收前端字串資料並解析
$project_id = file_get_contents("php://input");

// 執行：根據關鍵詞查詢相關方案
$sql_query_project_visible = "SELECT * FROM projects WHERE PROJECT_ID = ? && PROJECT_STATUS = 0 || PROJECT_VISIBLE_ON_WEB = 0";

$statement_query_project_visible = $pdo->prepare($sql_query_project_visible);
$statement_query_project_visible->bindParam(1, $project_id);
$statement_query_project_visible->execute();

$query_result = $statement_query_project_visible->fetchAll(PDO::FETCH_ASSOC);

if ($query_result == null || false) {
    $query_result = 1;
} else {
    $query_result = 0;
}

echo $query_result;
