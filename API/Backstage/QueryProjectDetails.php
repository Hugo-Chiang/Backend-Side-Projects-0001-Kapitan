<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

// 接收前端 JSON 字串資料並解析
$project_id = file_get_contents("php://input");

// 執行：
$sql_query_project_details = "SELECT * FROM
(SELECT * FROM
 (SELECT * FROM projects as pj 
JOIN departure_location as dl ON 
pj.FK_LOCATION_ID_for_PJ = dl.LOCATION_ID) as t1 
JOIN category as cg ON t1.FK_CATEGORY_ID_for_PJ = cg.CATEGORY_ID) as t2 
WHERE t2.PROJECT_ID = ?";

$statement_query_project_details = $pdo->prepare($sql_query_project_details);
$statement_query_project_details->bindParam(1, $project_id);
$statement_query_project_details->execute();

$query_result = $statement_query_project_details->fetch(PDO::FETCH_ASSOC);

print json_encode($query_result);
