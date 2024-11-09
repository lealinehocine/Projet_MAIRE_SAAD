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
            <td ></td>
            <td>2000 kcal</td>
        </tr>
        <tr>
            <td>Protéines (g)</td>
            <td ></td>
            <td>60 g</td>
        </tr>
        <tr>
            <td>Glucides (g)</td>
            <td ></td>
            <td>275 g</td>
        </tr>
        <tr>
            <td>Sucres (g)</td>
            <td></td>
            <td>moins de 30 g</td>
        </tr>
        <tr>
            <td>Lipides (g)</td>
            <td></td>
            <td>70 g</td>
        </tr>
    </tbody>
</table>

</div>


<script>
    const dateElement = document.getElementById('date_du_jour');
    const today = new Date().toLocaleDateString(); 
    dateElement.textContent = today;
</script>