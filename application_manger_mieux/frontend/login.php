<!-- page de connexion : session -->

<!-- Multi-utilisateurs. Ajoutez la possibilité de se créer un compte sur le site, de se connecter et
se déconnecter via un mécanisme de session. Bien évidemment, chaque utilisateur aura son propre
journal. Par contre, la liste des aliments sera partagée. -->


<div class="contentLogin">

<form id="login_form" action="" method="POST"> 
<!-- action à compléter fichier.php : dans le back -->
    <table>
        <tr>
            <th>Login :</th>
            <td><input type="text" name="login"></td>
        </tr>
        <tr>
            <th>Mot de passe :</th>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <th></th>
            <td><input class="bouton" type="submit" value="Se connecter" /></td>
        </tr>
    </table>
</form>

<p>OU</p>

<form id="subscription_form" action="" method="POST" onsubmit="onFormSubmit();"> 
<!-- action à compléter fichier.php -->
    <table>
        <tr>
            <th>Login* :</th>
            <td><input type="text" name="login" id="inputLogin"></td>
        </tr>
        <tr>
            <th>Mot de passe* :</th>
            <td><input type="password" name="password" id="inputPass"></td>
        </tr>
        <tr>
            <th>Mail :</th>
            <td><input type="text" name="mail" id="inputMail"></td>
        </tr>
        <tr>
            <th>Nom *:</th>
            <td><input type="text" name="nom" id="inputNom"></td>
        </tr>
        <tr>
            <th>Prénom* :</th>
            <td><input type="text" name="prenom" id="inputPrenom"></td>
        </tr>
        <tr>
            <th>Sexe* :</th>
            <td><select id="inputSexe">
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
            </select></td>
        </tr>
        <tr>
            <th>Date de naissance* :</th>
            <td><input type="date" name="date" id="inputDate"></td>
        </tr>
        <tr>
            <th>Pratique sportive* :</th>
            <td><select id="inputSport">
                <!-- 1 : faible, 2 : modéré, 3 : élevé -->
                    <option value="Faible">Faible</option> 
                    <option value="Modéré">Modéré</option>
                    <option value="Elevé">Elevé</option>
            </select></td>
        </tr>
        <tr>
            <th></th>
            <td><input class="bouton" type="submit" value="S'inscrire" /></td>
        </tr>
    </table>
</form>

</div>


<script>
    function onFormSubmit() {
        event.preventDefault();

        let loginUser = $("#inputLogin").val();
        let motDePasseUser = $("#inputPass").val();
        let mailUser = $("#inputMail").val();
        let nomUser = $("#inputNom").val();
        let prenomUser = $("#inputPrenom").val();
        let sexeUser = $("#inputSexe").val();
        let idSexeUser;
        let dateUser = $("#inputDate").val();
        let pratiqueUser = $("#inputSport").val();
        let idPratiqueUser;


        if(loginUser && motDePasseUser && nomUser && prenomUser && sexeUser && dateUser && pratiqueUser){

            if(sexeUser=="homme"){
                idSexeUser =1;
            }else{
                idSexeUser =2;
                }

                switch(pratiqueUser){
                    case "Faible":
                        idPratiqueUser = 1;
                        break;
                    case "Modéré":
                        idPratiqueUser = 2;
                        break;
                    case "Elevé":
                        idPratiqueUser = 3;
                        break;
                }

            $.ajax({
                    url: `${prefix_api}Personne.php`, 
                    type: 'POST',
                    data: {

                        login: loginUser,
                        id_tranche_d_age: 1,
                        id_sexe : idSexeUser,
                        id_pratique : idPratiqueUser,
                        email: mailUser,
                        date_naissance : dateUser,
                        nom: nomUser,
                        prenom :prenomUser,
                    },
                    success: function(response) { 
                        console.log(response);
        },
            error: function(xhr, status, error) {
                console.error("Erreur lors de l'inscription : ", error);
            }
        });


//console.log ("login :", login, "motDePasse :", motDePasse, "mail :",mail, "nom :", nom, "prenom :", prenom, "sexe :", sexe, "date :", date, "pratique :", pratique)
            }
        }

</script>