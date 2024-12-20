<?php

    include('../config.php'); 
    require_once('../init_pdo.php');
    session_start();

    function connectUser($pdo,$tryLogin,$tryPwd) {
        $tryLogin = $_POST['login'];
        $tryPwd = $_POST['password'];
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM personne WHERE login = :login");
            $stmt->bindParam(':login', $tryLogin);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            // Vérifier si l'utilisateur existe et si le mot de passe est correct
            if ($tryPwd == $user->PASSWORD && $user != null) {
                // Connexion réussie
                $_SESSION['user'] = $tryLogin; // Stocker le login dans la session
                return 200; 
            } else {
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
