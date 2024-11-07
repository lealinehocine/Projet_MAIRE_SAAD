<?php

// if (isset($_POST['login']) && isset($_POST['password'])) {
//     $tryLogin = $_POST['login'];
//     $tryPwd = $_POST['password'];
    
//     try {

//         $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
//         $stmt->bindParam(':login', $tryLogin);
//         $stmt->execute();
//         $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère l'utilisateur si trouvé
        
//         // Vérifier si l'utilisateur existe et si le mot de passe est correct
//         if ($user && password_verify($tryPwd, $user['password'])) { // password_verify pour vérifier le mot de passe haché
//             // Connexion réussie
//             session_start();
//             $_SESSION['user'] = $tryLogin; // Stocker le login dans la session
//             header("Location: index.php");

//         } else {
//             // Mot de passe incorrect ou utilisateur introuvable
//             echo "Erreur de login/mot de passe";
//         }
//     } catch (PDOException $e) {
//         // Si erreur de connexion
//         echo "Erreur de connexion à la base de données : " . $e->getMessage();
//     }
// } else {
//     echo "Merci d'utiliser le formulaire de login.";
// }
?>

    <?php

    include('./config.php'); 
    require_once('./init_pdo.php');

    // Vérifier si le formulaire a été soumis
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $tryLogin = $_POST['login'];
        $tryPwd = $_POST['password'];
        
        try {
            // Préparer la requête pour rechercher l'utilisateur dans la base de données
            $stmt = $pdo->prepare("SELECT * FROM personne WHERE login = :login");
            $stmt->bindParam(':login', $tryLogin);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère l'utilisateur si trouvé
            
            // Vérifier si l'utilisateur existe et si le mot de passe est correct
            if ($user && password_verify($tryPwd, $user['password'])) { // password_verify pour vérifier le mot de passe haché
                // Connexion réussie
                session_start();
                $_SESSION['user'] = $tryLogin; // Stocker le login dans la session
                header("Location: index.php");  // Redirige l'utilisateur vers la page principale
                exit(); // Assurer qu'on arrête l'exécution du script après la redirection
            } else {
                // Mot de passe incorrect ou utilisateur introuvable
                echo "Erreur de login/mot de passe";
            }
        } catch (PDOException $e) {
            // Si erreur de connexion à la base de données
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    } else {
        echo "Merci d'utiliser le formulaire de login.";
    }
    ?>
