<?php

// 導入並設定 CORS 權限
$allow_methods = 'GET';
include("../../Lib/CORS.php");

// 導入 PDO 以安全連線資練庫
include("../../Lib/PDO.php");

$sql_query = 'SELECT ADMIN_NAME FROM admin WHERE ADMIN_ID = "AD0001"';
$result = $pdo->query($sql_query);
$data = $result->fetch(PDO::FETCH_ASSOC);

echo $data['ADMIN_NAME'] . '是這個網站的作者～';
