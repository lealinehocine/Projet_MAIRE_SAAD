<!-- page affichant les aliments de la base avec la possibilité d’en ajouter, d’en supprimer,de les modifier : 
CRUD + datatables (avec pagination car bcp d'aliments dans la base)-->


<!-- Voir quelles caractéristiques on garde : lipides, calories etc... -->
<table>
    <thead>
        <tr>
            <th scope="col">Aliment</th>
            <th scope="col">Lipides</th>
            <th scope="col">Glucides</th>
            <th scope="col">Protéines</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<form id="addStudentForm" action="" onsubmit="onFormSubmit();">
    <div class="form-group row">
        <label for="inputNomAliment" class="col-sm-2 col-form-label">Aliment*</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="inputNomAliment" >
        </div>
    </div>

    <div class="form-group row">
        <label for="inputLipides" class="col-sm-2 col-form-label">Lipides</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="inputLipides" >
        </div>
    </div>

    <div class="form-group row">
    <label for="inputGlucides" class="col-sm-2 col-form-label">Glucides</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputGlucides" >
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


<!-- script à faire (cf brouillon) -->