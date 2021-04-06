<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string);

$selected_categories = $json_data->selectedCategories;
$budget = $json_data->budget;
$sort = $json_data->sort;

// 判斷：地點分類是否為全空，全空則回傳空陣列，反之則根據所選分類 ID 進行查詢
if (count($selected_categories) == 0) {

    $result_query_projects_list = [];
} else {
    // 將所選分類 ID 串接為 SQL 所用的字串
    $category_id_str = '';

    foreach ($selected_categories as $category_id) {
        $category_id_str = $category_id_str . ',' . "'" . $category_id . "'";
    }

    $category_id_str = substr($category_id_str, 1, strlen($category_id_str) - 1);
    $category_id_str = "(" . $category_id_str  . ")";

    // 執行：根據篩選條件找出相對應的方案
    $sql_query_projects_list = "SELECT 
    PROJECT_ID, PROJECT_NAME, PROJECT_AVATAR_URL, PROJECT_SUMMARY, PROJECT_ORIGINAL_PRICE_PER_PERSON, PROJECT_MIN_NUM_OF_PEOPLE, PROJECT_MAX_NUM_OF_PEOPLE, 
    FK_CATEGORY_ID_for_PJ FROM projects WHERE FK_CATEGORY_ID_for_PJ IN " . $category_id_str . " && PROJECT_ORIGINAL_PRICE_PER_PERSON <= ? 
    && PROJECT_STATUS > 0 && PROJECT_VISIBLE_ON_WEB != 0 ORDER BY " . $sort;
    $statement_query_projects_list = $pdo->prepare($sql_query_projects_list);
    $statement_query_projects_list->bindParam(1, $budget);
    $statement_query_projects_list->execute();

    $result_query_projects_list = $statement_query_projects_list->fetchAll(PDO::FETCH_ASSOC);
}

print json_encode($result_query_projects_list);
