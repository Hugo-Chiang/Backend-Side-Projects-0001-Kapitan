<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type:text/html; charset=utf-8");
// header("Access-Control-Allow-Origin: https://side-projects-01-kapitan.herokuapp.com");
// header('Access-Control-Allow-Methods: GET');

$json_string = file_get_contents("php://input");
$json_data = json_decode($json_string,false);

include("../Lib/PDO.php");

$sql_insert_order = 
"INSERT INTO orders(ORDER_ID,ORDER_DATE,ORDER_TOTAL_CONSUMPTION,ORDER_TOTAL_DISCOUNT,FK_MEMBER_ID_for_OD) VALUES ('OD0000001',NOW(),'20000','0', ?)";

$statement_insert_order = $pdo->prepare($sql_insert_order);
$statement_insert_order->bindParam(1, $json_data->memberID);
$statement_insert_order->execute();

echo $json_data->memberID.'的訂單完成了！'

?>