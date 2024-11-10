<?php
    require_once('template_header.php');
    require_once("template_menu.php");


session_start(); 

$currentPageId = 'accueil';

// Si l'utilisateur n'est pas connecté et qu'on demande la page `login`, on l'affiche
if (!isset($_SESSION['user']) && isset($_GET['page']) && $_GET['page'] === 'login') {
    $currentPageId = 'login';
}

// Si l'utilisateur est connecté, on vérifie s'il y a une page demandée
if (isset($_SESSION['user'])) {
    if (isset($_GET['page'])) {
        $currentPageId = $_GET['page'];
    } else {
        $currentPageId = 'dashboard';
    }
}


echo('<h1 class="header">iMieuxManger</h1>');

if($currentPageId!= 'login' && $currentPageId!= 'accueil'){
    renderMenuToHTML($currentPageId);
    }else{
            renderMenuToHomePage($currentPageId);
    }



$pageToInclude = $currentPageId . ".php";
if(is_readable($pageToInclude))
require_once($pageToInclude);
else
require_once("error.php");




require_once('template_footer.php');
?>