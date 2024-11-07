<?php
    require_once("../init_pdo.php");
    
    function setHeaders() {
        // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json; charset=utf-8');
    }

    function requete_get($db,$params) {
        $stringParams = "";
        foreach($params as $key => $value) {
            if($stringParams == ""){
                $stringParams = $key."=".$value;
            }
            else {
                $stringParams = $stringParams." AND ".$key."=".$value;
            }
        }
        if(count($params) == 0){
            $stringParams = "1";
        }
        $sql = "SELECT * FROM `Caracteristiques_de_sante` WHERE $stringParams ORDER BY `id_caracteristique`";
        $exe = $db->query($sql);
        $res = $exe->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    function requete_post($db, $post) {
        $requete = "INSERT INTO `Caracteristiques_de_sante` (`designation`) VALUES (".$post['designation'].")";
        try{
            $reponse = $db->query($requete);
        }
        catch(e){
            http_response_code(500);
            setHeaders();
            exit(json_encode("There has been an issue with the request"));
        }
        
        $requete = $db->query("SELECT * FROM `Caracteristiques_de_sante` WHERE `designation`=\"".$post['designation']."\"");
        $res = $requete->fetchAll(PDO::FETCH_OBJ);
        http_response_code(201);
        return $res;
    }


    /* Requetes put et delete pas encore fonctionnelles 
    function requete_put($db, $params) {
        if(!isset($params['id'])||!isset($params['name'])||$params['name'] === "") {
            http_response_code(400);
            setHeaders();
            exit(json_encode("id or name not defined"));
        }
        else {
            $safeName = htmlspecialchars($params['name']);
            $requete = "UPDATE `Aliments` SET `Aliments.name`=\"$safeName\" WHERE `Aliments.id`=$params['id']";
            try{
                $reponse = $db->query($requete);
            }
            catch(e){
                http_response_code(500);
                setHeaders();
                exit(json_encode("There has been an issue with the request"));
            }
            
            $requete = $db->query("SELECT * FROM `Aliments` WHERE `nom`='".$params['name']."'");
            $res = $requete->fetchAll(PDO::FETCH_OBJ);
            http_response_code(201);
        return $res;
        }
    }
    

    function requete_delete($db, $params){
        if(!isset($params['id'])) {
            http_response_code(400);
            setHeaders();
            exit(json_encode("id or name not defined"));
        }
        else {
            $safeName = htmlspecialchars($params['name']);
            $requete = "DELETE `Aliments` WHERE `Aliments.id`=$params['id']";
            try{
                $reponse = $db->query($requete);
            }
            catch(e){
                http_response_code(500);
                setHeaders();
                exit(json_encode("There has been an issue with the request"));
            }
            http_response_code(201);
            return true;
        }
    }
    
    */

    // ==============
    // Responses
    // ==============
    switch($_SERVER["REQUEST_METHOD"]) {
        case 'GET':
            $reponse = requete_get($pdo, $_GET);
            setHeaders();
            http_response_code(200);
            exit(json_encode($reponse));
            
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
                exit(json_encode($reponse));
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