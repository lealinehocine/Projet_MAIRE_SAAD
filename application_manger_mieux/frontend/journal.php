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
<form id="addStudentForm" action="" onsubmit="onFormSubmit(event);">

    <div class="form-group row">
        <label for="inputNomAliment" class="col-sm-2 col-form-label">Aliment*</label>
        <div class="col-sm-3">
            <select class="form-control" id="inputNomAliment">
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
                    <option value="Matin">Matin</option>
                    <option value="Midi">Midi</option>
                    <option value="Soir">Soir</option>
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

<script>

$(document).ready( function () {
    // $('#tableJournal').DataTable();

    //POUR GET 
    // Exécuter ce script après le chargement de la page

        // Fonction pour récupérer les aliments et les ajouter à la liste déroulante
        function fetchAliments() {
            $.ajax({
                url: `${prefix_api}Aliments.php`, 
                type: 'GET',
                success: function(response) {
                    // Vérifier que la réponse est un tableau d'aliments

                    let select = document.getElementById('inputNomAliment');
                    
                    // Ajouter chaque aliment en tant qu'option dans le select
                    response.forEach(aliment => {
                        let option = document.createElement('option');
                        option.value = aliment["NOM"]; 
                        option.textContent = aliment["NOM"]; // Affiche le nom dans l'option
                        select.appendChild(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Erreur lors du chargement des aliments : ", error);
                }
            });
        }

        // Appeler la fonction pour charger les aliments au démarrage
        fetchAliments();
    });


    //POST: à faire
    function onFormSubmit(event) {
        event.preventDefault();
        let nomAliment = $("#inputNomAliment").val();
        let quantite = $("#inputQuantite").val();
        let date = $("#inputDate").val();
        let repas = $("#inputNomRepas").val();


        // console.log(nomAliment,quantite,date,repas);

        if(nomAliment && quantite && date &&repas){ 

            // $.ajax({
            //     url: `${prefix_api}Repas.php`, 

            //         type: 'POST',
            //         data: {
//                         name: nomAliment,
//                     },
//                     success: function(response) { 

//                         let repRequete = JSON.parse(response);
//                         let alimentId = repRequete.id;


                        $("#tableJournal").append(`
                            <tr>
                                <td>${nomAliment}</td>
                                <td>${quantite}</td>
                                <td>${date}</td>
                                <td>${repas}</td>
                                <td>
                                    <button>Edit</button>
                                    <button>Delete</button>

                                </td>
                            </tr>
                        `);

// <button class="edit" data-id="${response.id}" onclick="editUser(this)">Edit</button>
// <button class="delete" data-id="${response.id}" onclick="deleteUser(${response.id}, this)">Delete</button>
//                     },
//                     error: function(xhr, status, error) {
//                         alert("Erreur lors de l'ajout de l'aliment : " + error);
//                     }
//                 });
            
// //edituser et delete user à faire

            }else{
                alert("Toutes les informations sont obligatoires");
            } 
        } 


</script>