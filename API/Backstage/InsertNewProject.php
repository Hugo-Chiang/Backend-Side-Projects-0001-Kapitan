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
$edited_details = $json_data->editedDetails;

// 透過 session 判斷管理員權限是否足夠進行項目編輯
$admin_level = check_admin_permissions($pdo, $session);

if ($admin_level > 2) {

    echo '您的權限不足以執行這項操作！';
} else {
    $project_id = insert_max_id($pdo, 'projects');
    $visible = 1;
    $project_carousel_imgs = json_encode($edited_details->projectCarouselImgs);

    $sql_insert_project_details = "INSERT INTO projects 
    (PROJECT_ID, PROJECT_STATUS, PROJECT_NAME, PROJECT_AVATAR_URL, PROJECT_CAROUSEL_URL, PROJECT_ORIGINAL_PRICE_PER_PERSON, 
    PROJECT_MIN_NUM_OF_PEOPLE, PROJECT_MAX_NUM_OF_PEOPLE, PROJECT_SUMMARY, PROJECT_DESCRIPITION, PROJECT_VISIBLE_ON_WEB, 
    FK_CATEGORY_ID_for_PJ, FK_LOCATION_ID_for_PJ) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement_insert_project_details = $pdo->prepare($sql_insert_project_details);
    $statement_insert_project_details->bindParam(1, $project_id);
    $statement_insert_project_details->bindParam(2, $edited_details->projectStatus);
    $statement_insert_project_details->bindParam(3, $edited_details->projectName);
    $statement_insert_project_details->bindParam(4, $edited_details->projectAvatarPublicID);
    $statement_insert_project_details->bindParam(5, $project_carousel_imgs);
    $statement_insert_project_details->bindParam(6, $edited_details->projectPricePerPerson);
    $statement_insert_project_details->bindParam(7, $edited_details->projectMinNumOfPeople);
    $statement_insert_project_details->bindParam(8, $edited_details->projectMaxNumOfPeople);
    $statement_insert_project_details->bindParam(9, $edited_details->projectSummary);
    $statement_insert_project_details->bindParam(10, $edited_details->projectDescription);
    $statement_insert_project_details->bindParam(11, $visible);
    $statement_insert_project_details->bindParam(12, $edited_details->projectCategory);
    $statement_insert_project_details->bindParam(13, $edited_details->projectDepartureLocation);
    $statement_insert_project_details->execute();

    echo '方案 ' . $project_id . ' 新增完成了！';
}
