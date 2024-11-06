<!-- Track conso user : liste déroulante avec option supprimer + "calendrier" : page affichant son journal avec possibilité d’ajouter une entrée -->

<!-- l’utilisateur doit pouvoir entrer les aliments qu’il consomme et
en quelle quantité à une date donnée. L’historique des aliments consommés pourront être visualisés
sous la forme d’un tableau. Il doit être possible de filtrer ce tableau :
— sur une période donnée (jour, semaine, mois, tout)
— par type d’aliment
— ... -->


<div class="contentJournal">

<table id="tableJournal">
    <thead>
        <tr>
            <th scope="col">Aliment</th>
            <th scope="col">Quantité</th>
            <th scope="col">Date</th>
            <th scope="col">Repas</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- enlever classe inutiles -->
<form id="addStudentForm" action="" onsubmit="onFormSubmit();">

    <div class="form-group row">
        <label for="inputNomAliment" class="col-sm-2 col-form-label">Aliment*</label>
        <div class="col-sm-3">
            <select class="form-control" id="inputNomAliment">
                                    <!-- laisser la premiere option? -->
                    <option value="">Sélectionner un aliment</option>
                    <!-- Les options des aliments seront insérées ici -->
            </select>
        </div>
    </div>

    <div class="form-group row">
    <label for="inputQuantite" class="col-sm-2 col-form-label">Quantité(g)</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputQuantite" >
        </div>
    </div>

    <div class="form-group row">
    <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
        <div class="col-sm-2">
        <input type="date" class="form-control" id="inputDate" >
        </div>
    </div>

    <div class="form-group row">
    <label for="inputNomRepas" class="col-sm-2 col-form-label">Repas</label>
        <div class="col-sm-2">
            <select class="form-control" id="inputNomRepas">
                    <option value="">Sélectionner un repas</option> 
                    <!-- laisser la premiere option? -->
                    <option value="">Matin</option>
                    <option value="">Midi</option>
                    <option value="">Soir</option>
            </select>
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