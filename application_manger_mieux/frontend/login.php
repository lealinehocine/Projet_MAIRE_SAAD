<!-- page de connexion : session -->

<!-- Multi-utilisateurs. Ajoutez la possibilité de se créer un compte sur le site, de se connecter et
se déconnecter via un mécanisme de session. Bien évidemment, chaque utilisateur aura son propre
journal. Par contre, la liste des aliments sera partagée. -->




<form id="login_form" action="" method="POST"> 
<!-- action à compléter fichier.php -->
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
            <td><input type="submit" value="Se connecter" /></td>
        </tr>
    </table>
</form>

<!-- login existant : géré par le back? ou faire 2 forms différents pour s inscrire. pour s inscrire besoin d autre chose que login et mot de passe -->