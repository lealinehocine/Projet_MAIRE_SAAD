<?php
require_once("../init_pdo.php");

session_start();

function setHeaders() {
    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json; charset=utf-8');
}

function requete_get($db,$params) {
    if(isset($params['user'])){
        return $params;
    }
    else{
        http_response_code(403);
        exit(json_encode("user not connected yet"));
    }
}



switch($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        $_SESSION['user']="guigui605";
        $reponse = requete_get($pdo, $_SESSION);
        setHeaders();
        http_response_code(200);
        exit(json_encode($reponse));
     
    default:
        http_response_code(501);
        exit(-1);
}