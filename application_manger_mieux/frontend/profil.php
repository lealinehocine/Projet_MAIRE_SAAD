<table>

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
    </table>

<!-- Lorsqu'on appuie sur Edit, les champs deviennent des input (sauf login (et noms?)) et le bouton devient Save -->
<button>Edit</button>



<!-- DANS UN 1ER TEMPS : les infos par defaut doivent venir d'un GET sur les infos du user -->
<!-- La requete POST se trouvera dans le login -->
<!-- DANS UN 2ND TPS : faire un JS pour que Edit transforme les td en input comme dans TD5 exo2 -->
<!-- Save doit envoyer un PUT pour modifier user meme dans la base de données : jQuery/ajax?-->



<!-- Faire un bouton "supprimer mon compte" à l'avenir? (DELETE)-->