<?php
    require_once("../init_pdo.php");
    
    function setHeaders() {
        // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json; charset=utf-8');
    }

    function requete_get($db, $login) {

        $sql = "SELECT * FROM `Personne` WHERE `login` = :login";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $res;
    }

    function requete_post($db, $post) {//post contient date, et midi/soir/matin
        
        $requete = "INSERT INTO `Personne` (`login`, `id_tranche_d_age`, `id_sexe`, `id_pratique`, `email`, `date_naissance`, `nom`, `admin`, `prenom`, `password`) 
VALUES ('" . $post['login'] . "', " . $post['id_tranche_d_age'] . ", " . $post['id_sexe'] . ", " . $post['id_pratique'] . ", '" . $post['email'] . "', '" . $post['date_naissance'] . "', '" . $post['nom'] . "', 0, '" . $post['prenom'] . "', '" . $post['password'] . "')";
        try{
            $reponse = $db->query($requete);
        }   
        catch(e){
            http_response_code(500);
            setHeaders();
            exit(json_encode("There has been an issue with the request"));
        }
        
        $requete = $db->query("SELECT * FROM `Personne` WHERE `login`=\"".$post['login']."\"");
        $res = $requete->fetchAll(PDO::FETCH_OBJ);
        http_response_code(201);
        return $res;
    }

    function requete_put($db, $params) {
        //$safeName = htmlspecialchars($params['name']);
        $requete = "UPDATE `Personne` SET `id_tranche_d_age`=\"".$params['id_tranche_d_age']."\", `id_sexe`=\"".$params['id_sexe']."\", `id_pratique`=\"".$params['id_pratique']."\", `email`=\"".$params['email']."\", `nom`=\"".$params['nom']."\" WHERE `login`=\"".$params['login']."\"";
        try{
            $reponse = $db->query($requete);
        }
        catch(e){
            http_response_code(500);
            setHeaders();
            exit(json_encode("There has been an issue with the request"));
        }
        
        $requete = $db->query("SELECT * FROM `Personne` WHERE `login`='".$params['login']."'");
        $res = $requete->fetchAll(PDO::FETCH_OBJ);
        http_response_code(201);
        return $res;   
    }
    

    function requete_delete($db, $params){
        if(!isset($params['login'])) {
            http_response_code(400);
            setHeaders();
            exit(json_encode("Tried to delete without id"));
        }
        else {
            $requete = "DELETE FROM `Personne` WHERE `login`=\"".$params['login']."\"";
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
            if(!isset($parameters["login"])){
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