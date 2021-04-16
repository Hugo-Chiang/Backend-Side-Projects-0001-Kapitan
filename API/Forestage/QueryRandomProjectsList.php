<?php

// 導入並設定 CORS 權限
$allow_methods = 'GET';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 執行：隨機挑選 6 組方案回傳予前端
$sql_query_random_projects_list = "SELECT 
PROJECT_ID, PROJECT_NAME, PROJECT_AVATAR_URL, PROJECT_SUMMARY, PROJECT_ORIGINAL_PRICE_PER_PERSON, PROJECT_MIN_NUM_OF_PEOPLE, PROJECT_MAX_NUM_OF_PEOPLE, 
FK_CATEGORY_ID_for_PJ FROM projects WHERE PROJECT_STATUS = 1 && PROJECT_VISIBLE_ON_WEB != 0 && PROJECT_FOR_TESTING != 1 ORDER BY RAND() LIMIT 6";
$statement_query_random_projects_list = $pdo->prepare($sql_query_random_projects_list);
$statement_query_random_projects_list->execute();

$result_query_random_projects_list = $statement_query_random_projects_list->fetchAll(PDO::FETCH_ASSOC);

print json_encode($result_query_random_projects_list);
