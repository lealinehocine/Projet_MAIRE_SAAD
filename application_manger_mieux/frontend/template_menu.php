<?php
    function renderMenuToHTML($currentPageId) {

    $mymenu = array(

        'index' => array( 'Mes statistiques' ), //voir si index fichier à part comme projet précédent
        'profil' => array( 'Mon profil' ),
        'aliments' => array('Aliments'),
        'journal' => array('Mon journal'),
        'login'=> array('Connexion')
        );
        
        echo ("<nav class=\"menu\"><ul>");

        foreach($mymenu as $pageId => $pageParameters) {

            $url = "index.php?page=" . $pageId ; //garder cette forme d'url?

            if($pageId == $currentPageId){
            echo ("<li class=\"li_menu\" id=\"currentpage\"><a href=\"$url\">$pageParameters[0]</a></li>");}
            else{
                echo ("<li class=\"li_menu\"><a href=\"$url\">$pageParameters[0]</a></li>");
            }
        }
        echo ("</ul>
        </nav>");
        }
?>