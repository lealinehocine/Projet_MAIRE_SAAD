<?php
    require_once("../init_pdo.php");
    
    function setHeaders() {
        // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json; charset=utf-8');
    }

    function get_caracteristics($db,$params) {
        $stringParams = "";
        $a_un_parametre_de_filtrage = false;
        foreach($params as $key => $value) {
            if($key!="caracteristiques"){
                $a_un_parametre_de_filtrage = true;
                if($stringParams == ""){
                    $stringParams = "a.".$key."=\"".$value."\"";
                }
                else {
                    $stringParams = $stringParams." AND a.".$key."=\"".$value."\"";
                }
            }
        }
        if(!$a_un_parametre_de_filtrage){
            $stringParams = "1";
        }
        $sql = "SELECT 
            a.id_aliment,
            a.nom,
            JSON_ARRAYAGG(
                JSON_OBJECT('quantite',ac.pourcentage,'caracteristique', c.designation)
                ) AS caracteristiques
        FROM 
            `Aliment` a
        JOIN `a_comme_caracteristiques` ac ON ac.id_aliment = a.id_aliment
        JOIN `caracteristiques_de_sante` c ON c.id_caracteristique = ac.id_caracteristique
        WHERE $stringParams
        GROUP BY a.id_aliment
        ORDER BY a.nom;";
        $exe = $db->query($sql);
        $res = $exe->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    function requete_get($db,$params) {
        $stringParams = "";
        if(isset($params)){
            foreach($params as $key => $value) {
                if($stringParams == ""){
                    $stringParams = "`".$key."`=\"".$value."\"";
                }
                else {
                    $stringParams = $stringParams." AND `".$key."`=\"".$value."\"";
                }
            }
        
            if(count($params) == 0){
                $stringParams = "1";
            }
        }
        else {
            $stringParams = "1";
        }
        $sql = "SELECT * FROM `Aliment` WHERE ".$stringParams." ORDER BY `id_aliment`";
        $exe = $db->query($sql);
        $res = $exe->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    function distance($nouveau_nom, $nomExistant) {
        //renvoie la distance de levenshtein la plus petite entre le nouveau nom d'aliment et les noms déjà existants
        return levenshtein($nouveau_nom,$nomExistant);
    }

    function requete_post($db, $post) {
        $safePost = htmlspecialchars($post['name']);
        $tableau_tous_aliments = requete_get($db,null);
        foreach($tableau_tous_aliments as $key => $value){
            if(distance($value->NOM,$safePost)<2){
                http_response_code(208);
                exit(json_encode("L'aliment existe déjà dans la base. Veuillez essayer de le modifier."));
            }
        }
        $requete = "INSERT INTO `Aliment` (`nom`) VALUES ('".$post['name']."')";
        try{
            $reponse = $db->query($requete);
        }
        catch(e){
            http_response_code(500);
            setHeaders();
            exit(json_encode("There has been an issue with the request"));
        }
        
        $requete = $db->query("SELECT * FROM `Aliment` WHERE `nom`='".$post['name']."'");
        $res = $requete->fetchAll(PDO::FETCH_OBJ);
        http_response_code(201);
        return $res;
    }

    function requete_put($db, $params) {
        //$safeName = htmlspecialchars($params['name']);
        $requete = "UPDATE `Aliment` SET `nom`=\"".$params['name']."\" WHERE `id_aliment`=\"".$params['id_aliment']."\"";
        try{
            $reponse = $db->query($requete);
        }
        catch(e){
            http_response_code(500);
            setHeaders();
            exit(json_encode("There has been an issue with the request"));
        }
        
        $requete = $db->query("SELECT * FROM `Aliment` WHERE `nom`='".$params['name']."'");
        $res = $requete->fetchAll(PDO::FETCH_OBJ);
        http_response_code(201);
        return $res;   
    }
    

    function requete_delete($db, $params){
        if(!isset($params['id_aliment'])) {
            http_response_code(400);
            setHeaders();
            exit(json_encode("Tried to delete without id"));
        }
        else {
            $requete = "DELETE FROM `Aliment` WHERE `id_aliment`=\"".$params['id_aliment']."\"";
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
            if(isset($_GET['caracteristiques']) && $_GET['caracteristiques']==true) {
                $reponse = get_caracteristics($pdo, $_GET);
            }
            else {
                $reponse = requete_get($pdo,$_GET);
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
            if(!isset($parameters["id_aliment"])||!isset($parameters["name"])){
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
                exit(json_encode("Aliment has been successfully deleted"));
            }
            
        default:
            http_response_code(501);
            exit(-1);
    }