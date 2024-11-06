<?php
    require_once("init_pdo.php");
    
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
        $sql = "SELECT * FROM `Aliments` WHERE $stringParams ORDER BY `id`";
        $exe = $db->query($sql);
        $res = $exe->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    function distance() {
        //renvoie la distance de levenshtein la plus petite entre le nouveau nom d'aliment et les noms déjà existants
    }

    function requete_post($db, $post) {
        $safePost = htmlspecialchars($post['name']);
        if(distance($safePost)<2){
            http_response_code(208);
            setHeaders();
            exit(json_encode("The aliment already exists in database. Please check again or try to modify the aliment instead"));
        }
        $requete = "INSERT INTO `Aliments` (`nom`) VALUES ('".$post['name']."')";
        try{
            $reponse = $db->query($requete);
        }
        catch(e){
            http_response_code(500);
            setHeaders();
            exit(json_encode("There has been an issue with the request"));
        }
        
        $requete = $db->query("SELECT * FROM `Aliments` WHERE `nom`='".$post['name']."'");
        $res = $requete->fetchAll(PDO::FETCH_OBJ);
        http_response_code(201);
        return $res;
    }

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

    // ==============
    // Responses
    // ==============
    switch($_SERVER["REQUEST_METHOD"]) {
        case 'GET':
            $reponse = requete_get($pdo);
            setHeaders();
            http_response_code(200);
            exit(json_encode($reponse));

        case 'POST':
            $reponse = requete_post($pdo, $_POST);
            setHeaders();
            http_response_code(201);
            exit(json_encode($reponse));
        
        case 'PUT':
            $parameters = json_decode(file_get_contents('php://input'),true);
            
        case 'DELETE':
            $parameters = json_decode(file_get_contents('php://input'),true);
            if(requete_delete($pdo, $parameters)){
                exit(json_encode("Aliment has been successfully deleted"));
            }
            
        default:
            http_response_code(501);
            exit(-1);
    }