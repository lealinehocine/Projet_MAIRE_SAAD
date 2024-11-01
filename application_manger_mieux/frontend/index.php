<!-- Indicateurs OMS + stats affichées dashboard -->


<!-- affiche un dashboard i.e. présente les indicateurs que vous aurez choisis : consommation
de sel journalière sur les 7 derniers jours, de calories, ... combien de fruits et/ou légumes
par jours sur les 7 jours, ... possibilité de changer la période ... vous pouvez afficher des
graphiques à l’aide bibliothèques JS (cf. TP4 exo 6) L’idée est de proposer un
tableau de bord synthétique à l’utilisateur afin de l’alerter sur les recommandations qu’il ne suivrait
pas. -->


<!-- juste un test -->
<?php
    require_once('template_header.php');
    $currentPageId = 'index';
?>


<?php  require_once("template_menu.php");

renderMenuToHTML($currentPageId); ?>


<?php
require_once('template_footer.php');
?>