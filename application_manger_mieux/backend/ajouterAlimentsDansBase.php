<?php
    require("init_pdo.php");
    $nomFichierAliments = "aliments.csv";
    $matrice = array();
    $fileAliments = fopen($nomFichierAliments, "r");
    while(!feof($fileAliments)){
        $ligneDeMatrice = array();
        $ligne = fgets($fileAliments);
        $valeur = "";
        for($i=0;$i<strlen($ligne);$i++){
            if($ligne[$i]==="\n"){
                array_push($matrice,$ligneDeMatrice);
            }
            else if($ligne[$i]===";"){
                array_push($ligneDeMatrice,$valeur);
                $valeur = "";
            }
            else{
                $valeur = $valeur.$ligne[$i];
            }
        }
    }
    fclose($fileAliments);

    foreach($matrice[0] as $index=>$value){
        if($index !== 0){
            $request = "INSERT INTO `caracteristiques_de_sante` (designation) VALUES (\"$value\");";
            $reponse = $pdo->query($request);
        }
    }

    foreach($matrice as $index=>$ligne){
        if($index !== 0){
            $id_aliment = "";
            foreach($ligne as $indexLigne=>$value){
                if($indexLigne === 0){
                    $ajouterAliment = $pdo->query("INSERT INTO `aliment` (nom) VALUES (\"$value\");");
                    $id_aliment = $pdo->query("SELECT Aliment.id_aliment FROM Aliment WHERE nom=\"$value\"");
                    $id_aliment = $id_aliment->fetch()[0];
                }
                else{
                    $premiereLigne = $matrice[0];
                    if($value !== "" && $id_aliment !== ""){
                        $request = $pdo->query("INSERT INTO `a_comme_caracteristiques` (Id_aliment,Id_caracteristique,Pourcentage) VALUES(\"$id_aliment\",(SELECT caracteristiques_de_sante.id_caracteristique FROM caracteristiques_de_sante WHERE designation=\"$premiereLigne[$indexLigne]\"),\"$value\")");
                    }
                }
            }
        }
    }