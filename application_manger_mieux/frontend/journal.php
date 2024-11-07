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


    $(document).ready(async function (){
        await $.ajax({
            url:`${prefix_api}Repas.php?login=guigui605`,//A MODIFIER POUR OBTENIR LE LOGIN DE LA PERSONNE CONNECTEE PLUS TARD
            type:'GET'
        })
        .done(function (response) {
            let parsedResponse = response;//JSON.parse(response);
            console.log("parsedResponse : ",parsedResponse);
            let id_repas = [];
            let date = [];
            let matin_midi_soir = [];
            let matin_midi_soir_string = [];
            parsedResponse.forEach( function (element, index, array){
                console.log("element : ",element," ; index : ",index," ; array : ",array);
                id_repas[index]=element["ID_REPAS"];
                date[index]=element["DATE"];
                matin_midi_soir[index]=element["MATIN_MIDI_SOIR"];
                console.log("matin_midi_soir : ",matin_midi_soir[index]);
                if(matin_midi_soir[index]==1){
                    matin_midi_soir_string[index]="Matin";
                }
                else if(matin_midi_soir[index] == 2){
                    matin_midi_soir_string[index]="Midi";
                }
                else if(matin_midi_soir[index] == 3){
                    matin_midi_soir_string[index]="Soir";
                }
                console.log("matinmidisoirstring : ",matin_midi_soir_string);
            });

            id_repas.forEach(async function (element, index, array){
                await $.ajax({
                    url:`${prefix_api}Contient.php?id_repas=${element}`,
                    type:'GET'
                })
                .done(function (reponse) {
                    let parsedReponse = reponse;//JSON.parse(reponse);
                    let nomsAliments = new Array();
                    console.log("reponse = ",reponse);
                    parsedReponse.forEach(async function(contient, indice, tbaleau){
                        console.log("#################  ID aliment  :  ",contient["ID_ALIMENT"]);
                        await $.ajax({
                            url:`${prefix_api}Aliments.php?id_aliment=${contient["ID_ALIMENT"]}`,
                            type:'GET'
                        })
                        .done(function (response) {
                            let tableau_reponse = response;//JSON.parse(response);
                            nomsAliments.push(tableau_reponse[0]["NOM"]);//tableau_reponse[0]["NOM"] ???
                            console.log("nomsAliments censé être avant le console log nomsAliments at 0 : ",nomsAliments);
                            parsedReponse.forEach(function(contient, indice, tableau){
                                console.log(nomsAliments[0]);
                                console.log(nomsAliments);
                                console.log(typeof(nomsAliments));
                                $("#tableJournal tbody").prepend(`<tr><td>${nomsAliments.at(indice)}</td><td>${contient["QUANTITE"]}</td><td>${date[indice]}</td><td>${matin_midi_soir_string[indice]}</td><td><button id="edit" onclick="editRepas(this)">Modifier</button></td><td><button id="edit" onclick="deleteRepas(this)">Supprimer</button></td></tr>`);
                            });
                        });
                    });
                });
            });
        })
        .fail(function(xhr,status,error) {
            console.error("Erreur lors du chargement des repas : ", error);
        });
    })
            

    function deleteRepas(button){
        let row = $(button).closest("tr");
        let cells = row.find("td");

        let nomAliment = cells.eq(0).text();
        let quantite = cells.eq(1).text();
        let date = cells.eq(2).text();
        let matin_midi_soir = cells.eq(3).text();
        let matin_midi_soir_nombre=0;
        if(matin_midi_soir == "Matin"){
            matin_midi_soir_nombre=1;
        }
        else if(matin_midi_soir == "Midi"){
            matin_midi_soir_nombre=2;
        }
        else if(matin_midi_soir == "Soir"){
            matin_midi_soir_nombre=3;
        }
        

        //On veut supprimer d'abord la ligne dans contient : il faut pour ça id_aliment et id_repas
        let id_aliment = 0;
        $.ajax({
            url:`${prefix_api}Aliments.php?nom=${nomAliment}`,
            type:'GET'
        })
        .done(function(reponse){
            console.log("reponse aliment get",reponse);
            id_aliment = reponse[0]["ID_ALIMENT"];
            let id_repas = 0;
            $.ajax({
                url:`${prefix_api}Repas.php?login=guigui605&date=${date}&matin_midi_soir=${matin_midi_soir_nombre}`,
                type:'GET'
            })
            .done(function (response){
                id_repas = response[0]["ID_REPAS"];
                

                console.log("id_repas",id_repas);
                console.log("id_aliment",id_aliment);

                $.ajax({
                    url:`${prefix_api}Contient.php`,
                    type:'DELETE',
                    dataType:"json",
                    data: `{\"id_repas\":\"${id_repas}\", "id_aliment":\"${id_aliment}\"}`
                });

                $.ajax({
                    url:`${prefix_api}Repas.php`,
                    type:'DELETE',
                    dataType:'json',
                    data: `{"id_repas":\"${id_repas}\"}`
                });
            });
        });

        $(button).closest('tr').remove();
    }

    function editRepas(button) {
        let row = $(button).closest('tr');
        let cells = row.find('td');

        let id_repas = 0;
        let matin_midi_soir = cells.eq(3).text();
        let matin_midi_soir_nombre=0;
        if(matin_midi_soir == "Matin"){
            matin_midi_soir_nombre=1;
        }
        else if(matin_midi_soir == "Midi"){
            matin_midi_soir_nombre=2;
        }
        else if(matin_midi_soir == "Soir"){
            matin_midi_soir_nombre=3;
        }

        $.ajax({
            url:`${prefix_api}Repas.php?login=guigui605&date=${cells.eq(2).text()}&matin_midi_soir=${matin_midi_soir_nombre}`,
            type:'GET'
        })
        .done(function(response){
            id_repas = response[0]["ID_REPAS"];
        

            // Remplace chaque cellule par un champ input contenant la valeur actuelle
            cells.eq(0).html(`<input type='text' value='${cells.eq(0).text()}' />`);//nom
            cells.eq(1).html(`<input type='text' value='${cells.eq(1).text()}' />`);//qté
            cells.eq(2).html(`<input type='text' value='${cells.eq(2).text()}' />`);//date
            cells.eq(3).html(`<input type='text' value='${cells.eq(3).text()}' />`);//matin_midi_soir


            row.append(`<input type="hidden" id="id_repas" value="${id_repas}"/>`);
            // Remplace le bouton "Edit" par "Save"
            $(button).replaceWith(`<button onclick="saveRepas(this)">Save</button>`);
        });
    }

    function saveRepas(button){
        let row = $(button).closest('tr');
        let cells = row.find('input');
        let id_repas = cells.eq(4).val();


        let matin_midi_soir = cells.eq(3).val();
        let matin_midi_soir_nombre=0;
        if(matin_midi_soir == "Matin"){
            matin_midi_soir_nombre=1;
        }
        else if(matin_midi_soir == "Midi"){
            matin_midi_soir_nombre=2;
        }
        else if(matin_midi_soir == "Soir"){
            matin_midi_soir_nombre=3;
        }

        $.ajax({
            url:`${prefix_api}Repas.php`,
                type:'PUT',
                dataType:'json',
                contentType:"application/json",
                processData: false,
                data: JSON.stringify({
                    'id_repas': id_repas,
                    'date': cells.eq(2).val(),
                    'matin_midi_soir': matin_midi_soir_nombre
                })
        })

        let newAlimentId = 0;
        $.ajax({
            url:`${prefix_api}Aliments.php?nom=${cells.eq(0).val()}`,
            type:'GET'
        })
        .done(function(reponse){
            newAlimentId = reponse[0]["ID_ALIMENT"];
        

            

            $.ajax({
                url:`${prefix_api}Contient.php`,
                type:'PUT',
                dataType:'json',
                contentType:"application/json",
                processData: false,
                data: JSON.stringify({
                    'id_repas': id_repas,
                    'id_aliment': newAlimentId,
                    'quantite': cells.eq(1).val()
                })
            })
            .done(function(){
                for(let i = 0;i<4;i++){
                    cells.eq(i).replaceWith(`${cells.eq(i).val()}`);
                }
                cells.eq(5).remove();
                $(button).replaceWith(`<button onclick="editRepas(this)">Edit</button>`);
            });
        });
    }

    //POST: à faire
    function onFormSubmit(event) {
        event.preventDefault();
        let nomAliment = $("#inputNomAliment").val();
        let quantite = $("#inputQuantite").val();
        let date = $("#inputDate").val();
        let repas = $("#inputNomRepas").val();
        let numeroRepas = 0;
        if(repas ==="Matin"){
            numeroRepas = 1;
        }
        else if(repas ==="Midi"){
            numeroRepas = 2;
        }
        else if(repas === "Soir"){
            numeroRepas = 3;
        }
        // console.log(nomAliment,quantite,date,repas);

        if(nomAliment && quantite && date &&repas){ 

        $.ajax({
            url: `${prefix_api}Repas.php`, 

            type: 'POST',
            data: {
                "login": "guigui605",
                "date":date,
                "matin_midi_soir":numeroRepas
            }
        })
        .done(function (reponse_post_repas) {
            console.log("reponse post repas : ",reponse_post_repas);
            let id_repas = reponse_post_repas[0]["ID_REPAS"];
            console.log("id_repas : ",id_repas);
            $.ajax({
                url: `${prefix_api}Aliments.php?nom=${nomAliment}`,
                type:'GET'
            })
            .done(function (reponse_get_aliment){
                console.log("reponse get aliment : ",reponse_get_aliment);
                let id_aliment = reponse_get_aliment[0]["ID_ALIMENT"];
                console.log("id_aliment : ",id_aliment," ; id_repas : ",id_repas," ; quantité : ",quantite);
                $.ajax({
                    url:`${prefix_api}Contient.php`,
                    type:'POST',
                    data: {
                        "id_aliment": id_aliment,
                        "id_repas": id_repas,
                        "quantite": quantite
                    }
                });
            });
        });

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

        } else {
            alert("Toutes les informations sont obligatoires");
        } 
    } 


</script>