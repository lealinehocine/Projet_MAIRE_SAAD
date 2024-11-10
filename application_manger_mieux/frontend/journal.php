<div class="contentJournal">


<form id="addRepasForm" action="" onsubmit="onFormSubmit(event);">

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


<table id="tableJournal">
    <thead>
        <tr>
            <th scope="col">Aliment</th>
            <th scope="col">Quantité</th>
            <th scope="col">Date</th>
            <th scope="col">Repas</th>
            <th scope="col">Modifier</th>
            <th scope="col">Supprimer</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


</div>

<script>

$(document).ready( function () {

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
        let login = "";
        $.ajax({
            url:`${prefix_api}session.php`,
            type:'GET'
        })
        .done(async function (reponse){
            login = reponse["user"];
    
            await $.ajax({
                url:`${prefix_api}Repas.php?login=${login}`,
                type:'GET'
            })
            .done(function (response) {
                let parsedResponse = response;
                let id_repas = [];
                let date = [];
                let matin_midi_soir = [];
                let matin_midi_soir_string = [];
                parsedResponse.forEach( function (element, index, array){
                    id_repas[index]=element["ID_REPAS"];
                    date[index]=element["DATE"];
                    matin_midi_soir[index]=element["MATIN_MIDI_SOIR"];
                    if(matin_midi_soir[index]==1){
                        matin_midi_soir_string[index]="Matin";
                    }
                    else if(matin_midi_soir[index] == 2){
                        matin_midi_soir_string[index]="Midi";
                    }
                    else if(matin_midi_soir[index] == 3){
                        matin_midi_soir_string[index]="Soir";
                    }
                });

                id_repas.forEach(async function (element, index, array){
                    await $.ajax({
                        url:`${prefix_api}Contient.php?id_repas=${element}`,
                        type:'GET'
                    })
                    .done(function (reponse) {
                        let parsedReponse = reponse;
                        let nomsAliments = "";
                        
                        $.ajax({
                            url:`${prefix_api}Aliments.php?id_aliment=${parsedReponse[0]["ID_ALIMENT"]}`,
                            type:'GET'
                        })
                        .done(function (response) {
                            let tableau_reponse = response;
                            nomsAliments = tableau_reponse[0]["NOM"];
                            parsedReponse.forEach(function(contient, indices, tableau){
                                $("#tableJournal tbody").append(`<tr><td>${nomsAliments}</td><td>${parsedReponse[0]["QUANTITE"]}</td><td>${date[index]}</td><td>${matin_midi_soir_string[index]}</td><td><button id="edit" onclick="editRepas(this)">Modifier</button></td><td><button id="edit" onclick="deleteRepas(this)">Supprimer</button></td></tr>`);
                            });
                        });
                        
                    });
                });
            })
            .fail(function(xhr,status,error) {
                console.error("Erreur lors du chargement des repas : ", error);
            });
        });
        $('#tableJournal').DataTable();
    })
            

    function deleteRepas(button){
        let login = "";
        $.ajax({
            url:`${prefix_api}session.php`,
            type:'GET'
        })
        .done(function (reponse){
            login = reponse["user"];
        
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
                id_aliment = reponse[0]["ID_ALIMENT"];
                let id_repas = 0;
                $.ajax({
                    url:`${prefix_api}Repas.php?login=${login}&date=${date}&matin_midi_soir=${matin_midi_soir_nombre}`,
                    type:'GET'
                })
                .done(function (response){
                    id_repas = response[0]["ID_REPAS"];

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
        });
    }

    function editRepas(button) {
        let login = "";
        $.ajax({
            url:`${prefix_api}session.php`,
            type:'GET'
        })
        .done(function (reponse){
            login = reponse["user"];
        
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
                url:`${prefix_api}Repas.php?login=${login}&date=${cells.eq(2).text()}&matin_midi_soir=${matin_midi_soir_nombre}`,
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
                $(button).replaceWith(`<button onclick="saveRepas(this)">Sauvegarder</button>`);
            });
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
                $(button).replaceWith(`<button onclick="editRepas(this)">Modifier</button>`);
            });
        });
    }

    //POST: à faire
    function onFormSubmit(event) {
        let login = "";
        event.preventDefault();
        $.ajax({
            url:`${prefix_api}session.php`,
            type:'GET'
        })
        .done(function (reponse){
            login = reponse["user"];
        

            
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

            if(nomAliment && quantite && date &&repas){ 

            $.ajax({
                url: `${prefix_api}Repas.php`, 

                type: 'POST',
                data: {
                    "login": login,
                    "date":date,
                    "matin_midi_soir":numeroRepas
                }
            })
            .done(function (reponse_post_repas) {
                let id_repas = reponse_post_repas[0]["ID_REPAS"];
                $.ajax({
                    url: `${prefix_api}Aliments.php?nom=${nomAliment}`,
                    type:'GET'
                })
                .done(function (reponse_get_aliment){
                    let id_aliment = reponse_get_aliment[0]["ID_ALIMENT"];
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
                        <button onclick="editRepas(this)">Modifier</button>
                    </td>
                    <td>
                        <button onclick="deleteRepas(this)">Supprimer</button>
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
        });
        // $('#tableJournal').DataTable().clear().destroy();
        // $('#tableJournal').DataTable();
    } 


</script>