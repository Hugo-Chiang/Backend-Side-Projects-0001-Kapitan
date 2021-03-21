<?php

header("Access-Control-Allow-Origin: http://localhost:8080");
// header("Access-Control-Allow-Origin: https://fe-sp-0001-kapitan.herokuapp.com");
header("Content-Type:text/html; charset=utf-8");

switch ($allow_methods) {
    case 'GET':
        header('Access-Control-Allow-Methods: GET');
        break;
    case 'POST':
        header('Access-Control-Allow-Methods: POST');
        break;
}
