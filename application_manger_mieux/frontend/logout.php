<p>Vous êtes déconnecté.</p>

<script>

$.ajax({
                    url: `${prefix_api}connected.php`, 
                    type: 'GET',

                    success: function(response) { 
                        window.location.href = './index.php';
        },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la connection : ", error);
            }
        });


</script>