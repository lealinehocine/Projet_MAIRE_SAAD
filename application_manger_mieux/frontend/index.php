<?php
    require_once('template_header.php');
    require_once("template_menu.php");

$succesfullyLogged = true; //A DEFINIR AVEC SESSION DANS LE BACK

if($succesfullyLogged){
    $currentPageId = 'dashboard';
    if(isset($_GET['page'])) {
        $currentPageId = $_GET['page'];
        }
    }else{
        $currentPageId = 'login';
    }


echo('<h1 class="header">iMieuxManger</h1>');

if($currentPageId!= 'login'){
renderMenuToHTML($currentPageId);
}else{
    echo('<h2 class="titre">Se connecter/S\'inscrire</h2>');
}



$pageToInclude = $currentPageId . ".php";
if(is_readable($pageToInclude))
require_once($pageToInclude);
else
require_once("error.php");




require_once('template_footer.php');
?>