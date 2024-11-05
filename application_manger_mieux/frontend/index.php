<?php
    require_once('template_header.php');
    require_once("template_menu.php");

    $currentPageId = 'dashboard';
    if(isset($_GET['page'])) {
        $currentPageId = $_GET['page'];
        }
?>

<?php 
            echo('<h1 class="header">iMieuxManger</h1>');
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