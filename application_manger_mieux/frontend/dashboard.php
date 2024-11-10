<p id="date_du_jour">Aujourd'hui</p>

<div class="contentStats">


<table id="tableStats">
    <thead>
        <tr>
            <th scope="col">Caractéristique</th>
            <th scope="col">Vous</th>
            <th scope="col">Valeur moyenne pour un adulte</th>
        </tr>
    </thead>
    <tbody>
    <tr>
            <td>Énergie (kcal)</td>
            <td id="energie"></td>
            <td>2000 kcal</td>
        </tr>
        <tr>
            <td>Protéines (g)</td>
            <td id="proteine"></td>
            <td>60 g</td>
        </tr>
        <tr>
            <td>Glucides (g)</td>
            <td id="glucide"></td>
            <td>275 g</td>
        </tr>
        <tr>
            <td>Sucres (g)</td>
            <td id="sucre"></td>
            <td>moins de 30 g</td>
        </tr>
        <tr>
            <td>Lipides (g)</td>
            <td id="lipide"></td>
            <td>70 g</td>
        </tr>
    </tbody>
</table>

<script>
    $(document).ready(loadConsommation());

    async function loadConsommation() {
        let login = "";
        let repas = [];
        let quantites_repas = [];
        let aliments_repas = [];
        let aliments_repas_avec_caracteristiques = [];
        let energie_totale = 0;
        let proteines_totale = 0;
        let glucides_totales = 0;
        let sucre_total = 0;
        let lipides_total = 0;

        try {
            // Récupérer le login de l'utilisateur
            let reponse_get_login = await $.ajax({
                url: `${prefix_api}session.php`,
                type: 'GET'
            });

            login = reponse_get_login["user"];

            let now = new Date();
            let year = now.getFullYear();
            let month = now.getMonth() + 1;
            let day = now.getUTCDate();
            let today = `${year}-${month}-${day}`;

            // Récupérer les repas pour aujourd'hui
            let reponse_get_repas = await $.ajax({
                url: `${prefix_api}Repas.php?login=${login}&date=${today}`,
                type: 'GET'
            });

            repas = reponse_get_repas;

            // Récupérer les détails de chaque repas
            let contientPromises = repas.map(async (un_repas) => {
                let reponse_get_contient = await $.ajax({
                    url: `${prefix_api}Contient.php?id_repas=${un_repas["ID_REPAS"]}`,
                    type: 'GET'
                });

                // Stocker les quantités et les aliments associés
                quantites_repas.push(reponse_get_contient[0]["QUANTITE"]);
                aliments_repas.push(reponse_get_contient[0]["ID_ALIMENT"]);
            });

            // Attendre que toutes les requêtes `Contient` soient terminées
            await Promise.all(contientPromises);

            // Récupérer les caractéristiques pour chaque aliment
            let alimentsPromises = aliments_repas.map(async (idAliment) => {
                let reponse_get_aliments = await $.ajax({
                    url: `${prefix_api}Aliments.php?caracteristiques=true&id_aliment=${idAliment}`,
                    type: 'GET'
                });

                // Ajouter les caractéristiques de chaque aliment
                aliments_repas_avec_caracteristiques.push(reponse_get_aliments);
            });

            // Attendre que toutes les requêtes `Aliments` soient terminées
            await Promise.all(alimentsPromises);

            // Calculer les valeurs nutritionnelles totales
            aliments_repas_avec_caracteristiques.forEach(function(aliment_total,index) {
                energie_totale += JSON.parse(aliment_total[0]["caracteristiques"])[1]["quantite"]*quantites_repas[index]/100;
                proteines_totale += JSON.parse(aliment_total[0]["caracteristiques"])[2]["quantite"]*quantites_repas[index]/100;
                glucides_totales += JSON.parse(aliment_total[0]["caracteristiques"])[3]["quantite"]*quantites_repas[index]/100;
                lipides_total += JSON.parse(aliment_total[0]["caracteristiques"])[4]["quantite"]*quantites_repas[index]/100;
                sucre_total += JSON.parse(aliment_total[0]["caracteristiques"])[5]["quantite"]*quantites_repas[index]/100;
            });


            $("#energie").text(energie_totale);
            $("#proteine").text(proteines_totale);
            $("#glucide").text(glucides_totales);
            $("#lipide").text(lipides_total);
            $("#sucre").text(sucre_total);

        } catch (error) {
            console.error("Erreur lors du chargement des données de consommation :", error);
        }
    }
</script>


</div>


<script>
    const dateElement = document.getElementById('date_du_jour');
    const today = new Date().toLocaleDateString(); 
    dateElement.textContent = today;
</script>
