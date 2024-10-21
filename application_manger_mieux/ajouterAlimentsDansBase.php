<?php
    $nomFichierAliments = "aliments.xlsx";
    $matrice = array();
    $fileAliments = fopen($nomFichierAliments, "r");
    while(!feof($fileAliments)){
        $ligneDeMatrice = array();
        $ligne = fgets($fileAliments);
        $valeur = "";
        foreach($ligne as $index=>$char){
            if($char==="\n"){
                array_push($matrice,$ligneDeMatrice);
            }
            else if($char === ","){
                array_push($ligneDeMatrice,$valeur);
            }
            else{
                $valeur = $valeur.$char;
            }
        }
    }
    fclose($fileAliments);

    foreach($matrice as index=>aliment){
        
    }