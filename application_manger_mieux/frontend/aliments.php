<?php
$admin = false; //En attendant que ce soit fait dans le back
?>

<div class="contentAliments">


<form id="addAlimentForm" action="" onsubmit="onFormSubmit();">

    <div class="form-group row">
        <label for="inputNomAliment">Aliment*</label>
        <div>
            <input type="text" id="inputNomAliment" >
        </div>
    </div>

    <div class="form-group row">
        <label for="inputEnergie">Energie</label>
        <div>
            <input type="text" id="inputEnergie" >
        </div>
    </div>

    <div class="form-group row">
        <label for="inputLipides">Lipides</label>
        <div>
            <input type="text" id="inputLipides" >
        </div>
    </div>

    <div class="form-group row">
    <label for="inputGlucose" >Glucose</label>
        <div>
        <input type="text" id="inputGlucose" >
        </div>
    </div>

    <div class="form-group row">
    <label for="inputSucre">Sucres</label>
        <div>
        <input type="text" class="form-control" id="inputSucre" >
        </div>
    </div>

    <div class="form-group row">
    <label for="inputProtéines">Protéines</label>
        <div>
        <input type="text" id="inputProtéines" >
        </div>
    </div>


    <div class="form-group row">
        <span"></span>
        <div >
            <button type="submit" >Enregistrer</button>
        </div>
    </div>

</form>


<table id="tableAliments">
    <thead>
        <tr>
            <th scope="col">Aliment</th>
            <th scope="col">Energie (kcal/100g)</th>
            <th scope="col">Lipides (g/100g)</th>
            <th scope="col">Glucose (g/100g)</th>
            <th scope="col">Sucre (g/100g)</th>
            <th scope="col">Protéines (g/100g)</th>
            <?php
                if($admin){
                    echo '<th scope="col">Edit</th>',
                    '<th scope="col">Delete</th>';
                }
            ?>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


</div>

<script>


function addRowToTable(response) {

    let $ligne = $('<tr></tr>');
    $ligne.append($('<td></td>').text(response.nom));

    let caracteristiques = JSON.parse(response.caracteristiques);

    let energie = getCharacteristic(caracteristiques, "Energie, Règlement UE N° 1169/2011 (kcal/100 g)");
    let lipides = getCharacteristic(caracteristiques, "Lipides (g/100 g)");
    let glucose = getCharacteristic(caracteristiques, "Glucose (g/100 g)");
    let sucres = getCharacteristic(caracteristiques, "Sucres (g/100 g)");
    let proteines = getCharacteristic(caracteristiques, "Protéines, N x 6.25 (g/100 g)");

    // console.log(energie,lipides,glucose,sucres,proteines);

    $ligne.append($('<td></td>').text(energie || "N/A"));
    $ligne.append($('<td></td>').text(lipides || "N/A"));
    $ligne.append($('<td></td>').text(glucose || "N/A"));
    $ligne.append($('<td></td>').text(sucres || "N/A"));
    $ligne.append($('<td></td>').text(proteines || "N/A"));

    $('#tableAliments').append($ligne);

    }

function getCharacteristic(caracteristiques, nomCarac) {
        let carac = caracteristiques.find(item => item.caracteristique === nomCarac);
        return carac ? carac.quantite : null;
    }


//GET 

$(document).ready( function () {


        function fetchAliments() {
            $.ajax({
                url: `${prefix_api}Aliments.php?caracteristiques=true`, 
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    response.forEach(aliment => addRowToTable(aliment));
                    $('#tableAliments').DataTable();
                },
                error: function(xhr, status, error) {
                    console.error("Erreur lors du chargement des aliments : ", error);
                }
            });
        }
        fetchAliments();

    });


//REQUETE POST : créer un aliment dans la base

function onFormSubmit() {
        event.preventDefault();
        let nomAliment = $("#inputNomAliment").val();
        let energie = $("#inputEnergie").val();
        let lipides = $("#inputLipides").val();
        let glucose = $("#inputGlucose").val();
        let sucre = $("#inputSucre").val();
        let proteines = $("#inputProtéines").val();

        let listeCaracteristiques = [energie, lipides, glucose, sucre, proteines]; //liste des pourcentages de chaque caracteristique de l'aliment qu'on vient de créer



        if(nomAliment){ // ne pas créer un aliment déjà existant : se fait dans le back
            let caracteristiquesId;
            let alimentId;
            $.ajax({
                    url: `${prefix_api}Aliments.php`, 
                    type: 'POST',
                    data: {
                        name: nomAliment,
                    },
                    success: function(response) { 
                        alimentId = response[0].ID_ALIMENT;


                        $("#tableAliments").prepend(`
                            <tr>
                                <td>${nomAliment}</td>
                                <td>${energie}</td>
                                <td>${lipides}</td>
                                <td>${glucose}</td>
                                <td>${sucre}</td>
                                <td>${proteines}</td>
                            </tr>
                        `);

        // Appel à Caracteristiques_de_sante pour récupérer les IDs des caractéristiques
        $.ajax({
            url: `${prefix_api}Caracteristiques_de_sante.php`, 
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                function getIdByDesignation(designation) {
                    const result = response.find(item => item.DESIGNATION === designation);
                    return result ? result.ID_CARACTERISTIQUE : null;  
                }
                
                caracteristiquesId = [
                    getIdByDesignation("Energie, Règlement UE N° 1169/2011 (kcal/100 g)"),
                    getIdByDesignation("Lipides (g/100 g)"),
                    getIdByDesignation("Glucose (g/100 g)"),
                    getIdByDesignation("Sucres (g/100 g)"),
                    getIdByDesignation("Protéines, N x 6.25 (g/100 g)")
                ];

                // Maintenant que `alimentId` et `caracteristiquesId` sont définis, on exécute la boucle
                for (let i = 0; i < 5; i++) {
                    $.ajax({
                        url: `${prefix_api}A_comme_caracteristique.php`, 
                        type: 'POST',
                        data: {
                            id_aliment: alimentId,
                            id_caracteristique: caracteristiquesId[i],
                            pourcentage: listeCaracteristiques[i],
                        },
                        success: function(response) { 
                            console.log("ID de l'aliment :", alimentId);
                            console.log("liste ID carac :", caracteristiquesId);
                        },
                        error: function(xhr, status, error) {
                            alert("Erreur lors de l'ajout de l'aliment : " + error);
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des caractéristiques : ", error);
            }
        });
    },
    error: function(xhr, status, error) {
        alert("Erreur lors de l'ajout de l'aliment : " + error);
    }
});



//edituser et delete user à faire

            }else{
                alert("Le nom de l'aliment est obligatoire");
            } 
        } 


</script>


<!-- boutons pour les admins -->
<!-- 
                                <td>
                                    <button class="edit" data-id="${response.id}" onclick="editUser(this)">Edit</button>
                                    <button class="delete" data-id="${response.id}" onclick="deleteUser(${response.id}, this)">Delete</button>
                                </td> -->