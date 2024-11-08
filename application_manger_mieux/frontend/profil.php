<!-- Faire une autre option d affichage quand déconnecté -->
<div class="contentProfil">
    <table id="profil">
        <!--
            <tr>
                <th>Login</th>
                <td><span class="info" id="login">userdefault</span></td>
            </tr>
            <tr>
                <th>Nom</th>
                <td><span class="info" id="nom">Nomdefaut</span></td>
            </tr>
            <tr>
                <th>Prénom</th>
                <td><span class="info" id="prenom">Prenomdefaut</span></td>
            </tr>
            <tr>
                <th>Sexe</th>
                <td><span class="info" id="sexe">homme, femme</span></td>
            </tr>
            <tr>
                <th>Tranche d'âge</th>
                <td><span class="info" id="age"> -40, -60, 60+ ans</span></td>
            </tr>
            <tr>
                <th>Pratique sportive</th>
                <td><span class="info" id="sport">bas, moyen, élevé</span></td>
            </tr>
            -->
    </table>

    <!-- Lorsqu'on appuie sur Edit, les champs deviennent des input (sauf login (et noms?)) et le bouton devient Save -->
    <button id="edit" onclick="editProfile(this)">Edit</button>
</div>
<script>
    $(document).ready(createTable());

    function createTable(){
        let login = "";
        $.ajax({
            url:`${prefix_api}session.php`,
            type:'GET'
            })
            .done(function (reponse){
                console.log(reponse);
                login = reponse["user"];

            let nom = "";
            let prenom = "";
            let sexe = "";
            let age = 0;
            let sport = "";

            $.ajax({
                url:`${prefix_api}Personne.php?login=${login}`,
                type:'GET'
            })
            .done(function (reponse){
                console.log("reponse : ",reponse);
                nom = reponse[0]["NOM"];
                prenom = reponse[0]["PRENOM"];
                sexe = reponse[0]["ID_SEXE"];
                age = new Date(reponse[0]["DATE_NAISSANCE"]);
                sport = reponse[0]["ID_PRATIQUE"];
                let sexe_string = "";
                if(sexe === 1){
                    sexe_string = "Homme";
                } else if(sexe === 2){
                    sexe_string = "Femme";
                }
                let now = new Date();
                age_nombre = now.getFullYear()-age.getFullYear();

                if(sport === 1){
                    sport_string = "Faible";
                } else if(sport === 2){
                    sport_string = "Modéré";
                } else if(sport === 3){
                    sport_string = "Elevé";
                }

                $("#profil").append(`<tr><th>Login</th><td><span class="info" id="login">${login}</span></td></tr><tr><th>Nom</th><td><span class="info" id="nom">${nom}</span></td></tr><tr><th>Prénom</th><td><span class="info" id="prenom">${prenom}</span></td></tr><tr><th>Sexe</th><td><span class="info" id="sexe">${sexe_string}</span></td></tr><tr><th>Âge</th><td><span class="info" id="age">${age_nombre}</span></td></tr><tr><th>Pratique sportive</th><td><span class="info" id="sport">${sport_string}</span></td></tr>`);
            });
        });
    }


    function editProfile(button) {
        let login = "";
        $.ajax({
            url:`${prefix_api}session.php`,
            type:'GET'
        })
        .done(function (reponse){
            login = reponse["user"];
        });
        // Sélectionne tous les éléments <span> avec la classe "info"
        const elements = document.querySelectorAll('.info');

        // Pour chaque élément, crée un input, copie la valeur et remplace l'élément
        elements.forEach(element => {
            if(element.id !="login"){
                const input = document.createElement('input');
                input.type = 'text';
                input.value = element.textContent;
                element.parentNode.replaceChild(input, element);
            }
        });
        $(button).replaceWith(`<button onclick="saveProfile(this)">Save</button>`);
    }

    function saveProfile(button) {
        let login = "";
        $.ajax({
            url:`${prefix_api}session.php`,
            type:'GET'
        })
        .done(function (reponse){
            login = reponse["user"];
        });


        let rows = $("#profil").find("tr");
        let cells = [];
        rows.forEach(function(row, indice, array){
            cells.concat(row.find("input"));
        });
        cells.forEach(function(cell, index, tableau){
            
        });

    }


</script>


<!-- DANS UN 1ER TEMPS : les infos par defaut doivent venir d'un GET sur une BDD de users (ou voir avec sessions) -->
<!-- La requete POST se trouvera dans le login si il y a une option "s'inscrire"-->
<!-- DANS UN 2ND TPS : faire un JS pour que Edit transforme les td en input comme dans TD5 exo2 -->
<!-- Save doit envoyer un PUT pour modifier user meme dans la base de données : jQuery/ajax?-->



<!-- Faire un bouton "supprimer mon compte" à l'avenir? (DELETE)-->