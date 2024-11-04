<!-- page affichant les aliments de la base avec la possibilité d’en ajouter, d’en supprimer, de les modifier : 
CRUD + datatables (avec pagination car bcp d'aliments dans la base)-->

<table id="tableAliments">
    <thead>
        <tr>
            <th scope="col">Aliment</th>
            <th scope="col">Energie</th>
            <th scope="col">Lipides</th>
            <th scope="col">Glucose</th>
            <th scope="col">Sucre</th>
            <th scope="col">Protéines</th>
            <th scope="col">Alcool</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<form id="addStudentForm" action="" onsubmit="onFormSubmit();">

<!-- Enlever les classes inutiles -->

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
    <label for="inputAlcool" class="col-sm-2 col-form-label">Alcool</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputAlcool" >
        </div>
    </div>

    <div class="form-group row">
        <span class="col-sm-2"></span>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary form-control">Enregistrer</button>
        </div>
    </div>

</form>


<script>

function onFormSubmit() {
        event.preventDefault();
        let nomAliment = $("#inputNomAliment").val();
        let energie = $("#inputEnergie").val();
        let lipides = $("#inputLipides").val();
        let glucose = $("#inputGlucose").val();
        let sucre = $("#inputSucre").val();
        let proteines = $("#inputProtéines").val();
        let alcool = $("#inputAlcool").val();

//GET est testable normalement

        if(nomAliment){ // ne pas créer un aliment déjà existant : se fait dans le back
            //FAIRE 2 requetes? car nomAliment et caractéristiques dans 2 API différentes
            $.ajax({
                    url: `${prefix_api}backend/API.php`, //A MODIFIER

                    type: 'POST',
                    data: {
                        name: nomAliment,
                    },
                    success: function(response) {
/*créer tout le tableau mais vide?*/ 
                        $("#tableAliments").append(`
                            <tr>
                                <td>${nomAliment}</td>
                        
                            </tr>
                        `);
                    },
                    error: function(xhr, status, error) {
                        alert("Erreur lors de l'ajout de l'aliment : " + error);
                    }
                });
            }else{
                alert("Le nom de l'aliment est obligatoire");
            } // faut data = JSON.parse(reponse) et data[id]= pour recup l id pour faire la 2e requete POST
        } 

                                // <td>${email}</td>
                                // <td>
                                //     <button class="edit" data-id="${response.id}" onclick="editUser(this)">Edit</button>
                                //     <button class="delete" data-id="${response.id}" onclick="deleteUser(${response.id}, this)">Delete</button>
                                // </td>
                            

</script>