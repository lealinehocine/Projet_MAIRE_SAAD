<div class="contentProfil">
    <table id="profil">

    </table>


    <button id="edit" onclick="editProfile(this)">Modifier</button>
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

                $("#profil").append(`<tr><th>Identifiant</th><td><span class="info" id="login">${login}</span></td></tr>
                                        <tr><th>Nom</th><td><span class="info" id="nom">${nom}</span></td></tr>
                                        <tr><th>Prénom</th><td><span class="info" id="prenom">${prenom}</span></td></tr>
                                        <tr><th>Sexe (Homme/Femme)</th><td><span class="info" id="sexe">${sexe_string}</span></td></tr>
                                        <tr><th>Âge</th><td><span class="info" id="age">${age_nombre}</span></td></tr>
                                        <tr><th>Sportif (Faible/Modéré/Elevé)</th><td><span class="info" id="sport">${sport_string}</span></td></tr>`);
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

        const elements = document.querySelectorAll('.info');

        // Pour chaque élément, crée un input, copie la valeur et remplace l'élément
        elements.forEach(element => {
            if(element.id !="login"){
                const input = document.createElement('input');
                input.type = 'text';
                input.value = element.textContent;
                input.id = `new${element.id}`;
                element.parentNode.replaceChild(input, element);
            }
        });
        $(button).replaceWith(`<button onclick="saveProfile(this)">Enregistrer</button>`);
    }

    function saveProfile(button) {
        let login = "";
        $.ajax({
            url:`${prefix_api}session.php`,
            type:'GET'
        })
        .done(function (reponse){
            login = reponse["user"];
        

            let newNom = $("#newnom").val();
            let newPrenom =$("#newprenom").val();
            let newSexe =$("#newsexe").val();
            let newAge = $("#newage").val();
            let newPratique = $("#newsport").val();

            let newSexe_number = 0;

            if(newSexe == "Homme"){
                newSexe_number=1;
            }
            else if(newSexe == "Femme"){
                newSexe_number=2;
            }

            let newPratique_number = 0;

            if(newPratique == "Faible"){
                newPratique_number=1;
            }
            else if(newPratique == "Modéré"){
                newPratique_number=2;
            }
            else if(newPratique == "Elevé"){
                newPratique_number=3;
            }

            $.ajax({
                url:`${prefix_api}Personne.php`,
                type:'PUT',
                contentType:'application/json',
                dataType:'json',
                processData: false,
                data: `{
                        "login":"${login}",
                        "nom":"${newNom}",
                        "prenom":"${newPrenom}",
                        "id_sexe":"${newSexe_number}",
                        "id_pratique":"${newPratique_number}",
                        "email":"test.email@gmail.com",
                        "id_tranche_d_age":"1"
                    }`
            })
            .done(function(reponse){
                const inputs = $("#profil").find('input');
                inputs.each(function() {
                    const newSpan = document.createElement('span');
                    newSpan.classList.add('info');
                    newSpan.id = this.id.replace('new', '');
                    newSpan.textContent = this.value;
                    this.parentNode.replaceChild(newSpan, this);
                });

                // Remplace enregistrer par éditer
                $(button).replaceWith('<button onclick="editProfile(this)">Modifier</button>');
            });
        });
    }


</script>

<!-- Faire un bouton "supprimer mon compte" à l'avenir? (DELETE)-->