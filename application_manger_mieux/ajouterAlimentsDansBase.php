<?php
    require("init_pdo.php");
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

    foreach($matrice[0] as $index=>$value){
        if($index > 1){
            $request = "INSERT INTO `caracteristiques_de_sante` (désignation) VALUES ($value);"
            $reponse = $db->query($requete);
        }
    }

    foreach($matrice as $index=>$ligne){
        if($index !== 0){

            foreach($ligne as $indexLigne=>$value){
                $id_aliment = "";
                if($indexLigne === 0){
                    $ajouterAliment = "INSERT INTO `aliments` (nom) VALUES ($value);";
                    $id_aliment = $pdo->query("SELECT Aliment.id_aliment FROM Aliment WHERE nom=$value");
                }
                else{
                    $request = "INSERT INTO `a_comme_caracteristiques` (Id_aliment,Id_caracteristique,Pourcentage) VALUES($id_aliment,(SELECT caracteristiques_de_sante.id_caracteristique FROM caracteristiques_de_sante WHERE designation=$matrice[0][$indexLigne),$value)";
                }
            }

            $request = "INSERT INTO `a_comme_caracteristiques` (Id_aliment,Id_caracteristique,Pourcentage) VALUES()";
        }
    }