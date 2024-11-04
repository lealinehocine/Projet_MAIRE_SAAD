<?php
    require_once('template_header.php');
    require_once("template_menu.php");

    $currentPageId = 'dashboard';
    if(isset($_GET['page'])) {
        $currentPageId = $_GET['page'];
        }
?>

<?php 
    switch($currentPageId){
        case "dashboard":
            echo('<h1>Mes statistiques</h1>');
            break;
        case "profil":
            echo('<h1>Mon profil</h1>');
            break;
        case "aliments":
            echo('<h1>Aliments</h1>');
            break;
        case "journal":
            echo('<h1>Mon journal</h1>');
            break;
        case "login":
            echo('<h1>Connexion</h1>'); //doit se transformer en déconnexion quand on est connecté!
            break;
        default:
            echo('<h1>iMieuxManger</h1>');
            break;
    }
?>

<?php
renderMenuToHTML($currentPageId);
?>

<?php
$pageToInclude = $currentPageId . ".php";
if(is_readable($pageToInclude))
require_once($pageToInclude);
else
require_once("error.php");
?>


<?php
require_once('template_footer.php');
?>