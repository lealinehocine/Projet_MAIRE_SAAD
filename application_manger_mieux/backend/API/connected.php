<?php

    include('../config.php'); 
    require_once('../init_pdo.php');
    session_start();
    // Vérifier si le formulaire a été soumis
    function connectUser($pdo,$tryLogin,$tryPwd) {
        $tryLogin = $_POST['login'];
        $tryPwd = $_POST['password'];
        
        try {
            // Préparer la requête pour rechercher l'utilisateur dans la base de données
            $stmt = $pdo->prepare("SELECT * FROM personne WHERE login = :login");
            $stmt->bindParam(':login', $tryLogin);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ); // Récupère l'utilisateur si trouvé
            // Vérifier si l'utilisateur existe et si le mot de passe est correct
            if ($tryPwd == $user->PASSWORD && $user != null) { // password_verify pour vérifier le mot de passe haché
                // Connexion réussie
                $_SESSION['user'] = $tryLogin; // Stocker le login dans la session
                return 200; // Assurer qu'on arrête l'exécution du script après la redirection
            } else {
                // Mot de passe incorrect ou utilisateur introuvable
                echo "Erreur de login/mot de passe";
            }
        } catch (PDOException $e) {
            // Si erreur de connexion à la base de données
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    } 

    function disconnectUser(){
        session_unset();
        session_destroy();
    }

    switch($_SERVER["REQUEST_METHOD"]) {
        case 'POST':
            if(isset($_POST['login']) && isset($_POST['password'])){
                $reponse = connectUser($pdo,$_POST['login'],$_POST['password']);
                http_response_code($reponse);
                exit();
            }

            case 'GET':
                if(isset($_SESSION['user'])){
                    disconnectUser();
                    http_response_code(200);
                    exit();
                }
        }
    ?>
