<!-- page affichant les aliments de la base avec la possibilité d’en ajouter, d’en supprimer, de les modifier : 
CRUD + datatables (avec pagination car bcp d'aliments dans la base)-->

<?php
$admin = false; //En attendant que ce soit fait dans le back
?>

<div class="contentAliments">

<table id="tableAliments">
    <thead>
        <tr>
            <th scope="col">Aliment</th>
            <th scope="col">Energie</th>
            <th scope="col">Lipides</th>
            <th scope="col">Glucose</th>
            <th scope="col">Sucre</th>
            <th scope="col">Protéines</th>
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


<!-- Enlever les classes inutiles -->
<form id="addStudentForm" action="" onsubmit="onFormSubmit();">

    <div class="form-group row">
        <label for="inputNomAliment" class="col-sm-2 col-form-label">Aliment*</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="inputNomAliment" >
        </div>
    </div>

    <div class="form-group row">
        <label for="inputEnergie" class="col-sm-2 col-form-label">Energie</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="inputEnergie" >
        </div>
    </div>

    <div class="form-group row">
        <label for="inputLipides" class="col-sm-2 col-form-label">Lipides</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="inputLipides" >
        </div>
    </div>

    <div class="form-group row">
    <label for="inputGlucose" class="col-sm-2 col-form-label">Glucose</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputGlucose" >
        </div>
    </div>

    <div class="form-group row">
    <label for="inputSucre" class="col-sm-2 col-form-label">Sucre</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputSucre" >
        </div>
    </div>

    <div class="form-group row">
    <label for="inputProtéines" class="col-sm-2 col-form-label">Protéines</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputProtéines" >
        </div>
    </div>


    <div class="form-group row">
        <span class="col-sm-2"></span>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary form-control">Enregistrer</button>
        </div>
    </div>

</form>
</div>

<script>

//GET 

$(document).ready( function () {
    // $('#tableAliment').DataTable();

        function fetchAliments() {
            $.ajax({
                url: `${prefix_api}Aliments.php?caracteristiques=true`, 
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    response.forEach(aliment => addRowToTable(aliment));

                },
                error: function(xhr, status, error) {
                    console.error("Erreur lors du chargement des aliments : ", error);
                }
            });
        }
        function addRowToTable(response) {

            let $ligne = $('<tr></tr>');
            $ligne.append($('<td></td>').text(response.nom));

            let caracteristiques = JSON.parse(response.caracteristiques);

            let energie = getCharacteristic(caracteristiques, "Energie, Règlement UE N° 1169/2011 (kcal/100 g)");
            let lipides = getCharacteristic(caracteristiques, "Lipides (g/100 g)");
            let glucose = getCharacteristic(caracteristiques, "Glucose (g/100 g)");
            let sucres = getCharacteristic(caracteristiques, "Sucres (g/100 g)");
            let proteines = getCharacteristic(caracteristiques, "Protéines, N x 6.25 (g/100 g)");

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

        if(nomAliment){ // ne pas créer un aliment déjà existant : se fait dans le back

            $.ajax({
                    url: `${prefix_api}API.php`, //A MODIFIER

                    type: 'POST',
                    data: {
                        name: nomAliment,
                    },
                    success: function(response) { 

                        let repRequete = JSON.parse(response);
                        let alimentId = repRequete.id;

                        //mettre ici l'autre/les autres requetes ajax, qui permettent de rajouter au back les différents caractéristiques de sante

//ne pas afficher les boutons si pas admin
                        $("#tableAliments").append(`
                            <tr>
                                <td>${nomAliment}</td>
                                <td>${energie}</td>
                                <td>${lipides}</td>
                                <td>${glucose}</td>
                                <td>${sucre}</td>
                                <td>${proteines}</td>
                                <td>
                                    <button class="edit" data-id="${response.id}" onclick="editUser(this)">Edit</button>
                                    <button class="delete" data-id="${response.id}" onclick="deleteUser(${response.id}, this)">Delete</button>
                                </td>
                            </tr>
                        `);
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