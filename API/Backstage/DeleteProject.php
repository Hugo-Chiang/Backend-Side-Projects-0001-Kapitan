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

$session = $json_data->session;
$project_id = $json_data->projectID;

// 執行：詢問方案是否屬於測試項目，以利後續區別相關權限操作
$sql_query_testing_project = "SELECT PROJECT_FOR_TESTING FROM projects WHERE PROJECT_ID = ?";

$statement_query_testing_project = $pdo->prepare($sql_query_testing_project);
$statement_query_testing_project->bindParam(1, $project_id);
$statement_query_testing_project->execute();

$query_result = $statement_query_testing_project->fetch(PDO::FETCH_ASSOC);

$testing = $query_result['PROJECT_FOR_TESTING'];

// 透過 session 判斷管理員權限是否足夠進行方案刪除
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2 && $testing != 1) {

    echo '您的權限不足以執行這項操作！';
    exit;
}

$sql_delete_project = "UPDATE projects SET PROJECT_VISIBLE_ON_WEB = 0 WHERE PROJECT_ID = ?";
$statement_delete_project = $pdo->prepare($sql_delete_project);
$statement_delete_project->bindParam(1, $project_id);
$statement_delete_project->execute();

echo '方案 ' . $project_id . ' 已被刪除了。';
