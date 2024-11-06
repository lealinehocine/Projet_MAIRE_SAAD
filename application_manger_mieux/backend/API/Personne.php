<?php
    require_once("../init_pdo.php");
    
    function setHeaders() {
        // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json; charset=utf-8');
    }

    function requete_get($db, $login) {
        $sql = "SELECT * FROM `Personne` WHERE `login`=$login";
        $exe = $db->query($sql);
        $res = $exe->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
/*
    function requete_post($db, $post) {
        $safePost = htmlspecialchars($post['name']);
        if(distance($safePost)<2){
            http_response_code(208);
            setHeaders();
        }
        $requete = "INSERT INTO `Personne` (`login`, `id_tranche_d_age`,`id_sexe`,`id_pratique`,`email`,`age`) VALUES ('".$post['name']."')";
        try{
            $reponse = $db->query($requete);
        }
        catch(e){
            http_response_code(500);
            setHeaders();
            exit(json_encode("There has been an issue with the request"));
        }
        
        $requete = $db->query("SELECT * FROM `Personne` WHERE `login`='".$post['login']."'");
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
        if(!isset($params['login'])) {
            http_response_code(400);
            setHeaders();
            exit(json_encode("Tried to delete without a login"));
        }
        else {
            $safeName = htmlspecialchars($params['login']);
            $requete = "DELETE FROM `Users` WHERE `Users.login`=$params['login']";
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
            if(isset($_GET['login'])){
                $reponse = requete_get($pdo, $_GET['login']);
            }
            else {
                $reponse = "login not precised";
            }
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
            
        default:
            http_response_code(501);
            exit(-1);
    }