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
        $sql = "SELECT * FROM `Contient` WHERE $stringParams ORDER BY `id_repas`";
        $exe = $db->query($sql);
        $res = $exe->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    function requete_post($db, $post) {
        $requete = "INSERT INTO `Contient` (`id_repas`,`id_aliment`,`quantite`) VALUES (".$post['id_repas'].",".$post['id_aliment'].",".$post['quantite'].")";
        try{
            $reponse = $db->query($requete);
        }
        catch(e){
            http_response_code(500);
            setHeaders();
            exit(json_encode("There has been an issue with the request"));
        }
        
        $requete = $db->query("SELECT * FROM `Contient` WHERE `id_repas`=\"".$post['id_repas']."\" AND `id_aliment`=\"".$post['id_aliment']."\"");
        $res = $requete->fetchAll(PDO::FETCH_OBJ);
        http_response_code(201);
        return $res;
    }


    // Requetes put et delete pas encore fonctionnelles
    function requete_put($db, $params) {
        //$safeName = htmlspecialchars($params['name']);
        $requete = "UPDATE `Contient` SET `quantite`=\"".$params['quantite']."\",`id_aliment`=\"".$params['id_aliment']."\" WHERE `id_repas`=\"".$params['id_repas']."\"";
        try{
            $reponse = $db->query($requete);
        }
        catch(e){
            http_response_code(500);
            setHeaders();
            exit(json_encode("There has been an issue with the request"));
        }
        
        $requete = $db->query("SELECT * FROM `Contient` WHERE `id_repas`='".$params['id_repas']."'");
        $res = $requete->fetchAll(PDO::FETCH_OBJ);
        http_response_code(201);
        return $res;   
    }
    

    function requete_delete($db, $params){
        if(!isset($params['id_repas'])) {
            http_response_code(400);
            setHeaders();
            exit(json_encode("Tried to delete without id"));
        }
        else {
            $requete = "DELETE FROM `Contient` WHERE `id_repas`=\"".$params['id_repas']."\"";
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
            $reponse = requete_get($pdo, $_GET);
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
            if(!isset($parameters["id_repas"])||!isset($parameters["quantite"])||!isset($parameters["id_aliment"])){
                http_response_code(400);
                exit("missing argument");
            }
            else {
                $reponse = requete_put($pdo, $parameters);
                exit(json_encode($reponse));
            }
            
        case 'DELETE':
            $parameters = json_decode(file_get_contents('php://input'),true);
            if(requete_delete($pdo, $parameters)){
                exit(json_encode("Contient has been successfully deleted"));
            }

        default:
            http_response_code(501);
            exit(-1);
    }