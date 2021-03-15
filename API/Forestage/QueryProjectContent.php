<?php

// 設定 CORS 權限
header("Access-Control-Allow-Origin: *");
header("Content-Type:text/html; charset=utf-8");
// header("Access-Control-Allow-Origin: https://side-projects-01-kapitan.herokuapp.com");
// header('Access-Control-Allow-Methods: GET');

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

$project_id = file_get_contents("php://input");

// 執行：根據方案 ID 回傳該方案所有的行銷資訊
$sql_query_project_content = "SELECT * FROM projects WHERE PROJECT_ID = ?";
$statement_query_project_content = $pdo->prepare($sql_query_project_content);
$statement_query_project_content->bindParam(1, $project_id);
$statement_query_project_content->execute();

$query_project_content_result = $statement_query_project_content->fetch(PDO::FETCH_ASSOC);

// 執行：根據方案 ID 回傳該方案所有的出發地點資訊
$sql_query_project_departure_location = "SELECT LOCATION_ID, LOCATION_NAME, LOCATION_LNG, LOCATION_LAT, LOCATION_DESCRIPTION  FROM 
(SELECT * FROM projects as pj 
JOIN departure_location as dl 
ON pj.FK_LOCATION_ID_for_PJ = dl.LOCATION_ID) as t1 
WHERE t1.PROJECT_ID = ?";
$statement_query_project_departure_location = $pdo->prepare($sql_query_project_departure_location);
$statement_query_project_departure_location->bindParam(1, $project_id);
$statement_query_project_departure_location->execute();

$query_project_departure_location_result = $statement_query_project_departure_location->fetch(PDO::FETCH_ASSOC);

// 執行：根據方案 ID 回傳該方案的所有預約狀態
$sql_query_project_booking = "SELECT * FROM booking WHERE FK_ORDER_DETAIL_ID_for_BK = ?";
$statement_query_project_booking = $pdo->prepare($sql_query_project_booking);
$statement_query_project_booking->bindParam(1, $project_id);
$statement_query_project_booking->execute();

$query_query_project_booking_result = $statement_query_project_booking->fetchAll(PDO::FETCH_ASSOC);

// 向前端回傳內容
$return_obj = (object)[
    'projectBooking' => $query_query_project_booking_result,
    'projectContent' => $query_project_content_result,
    'projectDepartureLocation' => $query_project_departure_location_result
];

print json_encode($return_obj);
