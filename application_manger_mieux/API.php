<?php
    require_once("init_pdo.php");
    
    function setHeaders() {
        // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json; charset=utf-8');
    }

    /*aliment
    a comme caractéristiques
    caractéristiques de santé
    contient
    est_composé_de
    mange
    personne
    pratique sportive
    repas
    sexe
    tranche d age*/



    
    // ==============
    // Responses
    // ==============
    switch($_SERVER["REQUEST_METHOD"]) {
        case 'GET':
            if(!isset($_GET['table'])){
                setHeaders();
                http_response_code(400);
                exit(json_encode("Table non précisée"));
            }
            else{
                $reponse = requete_get($pdo, $_GET);
                setHeaders();
                http_response_code(200);
                exit(json_encode($reponse));
            }
        case 'POST':
            if(!isset($_POST['table'])){
                setHeaders();
                http_response_code(400);
                exit(json_encode("Table non précisée"));
            }
            else{
                $reponse = requete_post($pdo, $_POST);
                setHeaders();
                http_response_code(201);
                exit(json_encode($reponse))
            }
        case 'PUT':
            $parameters = json_decode(file_get_contents('php://input'),true);
            if(!isset($parameters['table'])){
                setHeaders();
                http_response_code(400);
                exit(json_encode("Table non précisée"));
            }
        case 'DELETE':
            $parameters = json_decode(file_get_contents('php://input'),true);
            if(!isset($parameters['table'])){
                setHeaders();
                http_response_code(400);
                exit(json_encode("Table non précisée"));
            }
        default:
            http_response_code(501);
            exit(-1);
    }
