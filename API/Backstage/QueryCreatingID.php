<?php

// 導入並設定 CORS 權限
$allow_methods = 'POST';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");
// 導入自定義函式庫
include("../../Lib/Functions.php");

$path_string = file_get_contents("php://input");
$insert_max_id;

switch ($path_string) {
    case 'Orders-Manager':
        $table_name = 'orders';
        break;
    case 'Projects-Manager':
        $table_name = 'projects';
        break;
    case 'Members-Manager':
        $table_name = 'members';
        break;
}

$insert_max_id = insert_max_id($pdo, $table_name);

echo $insert_max_id;
