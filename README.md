# Projet_MAIRE_SAAD

# 1 Configuration du site sur une nouvelle machine host :

Pour faire fonctionner ce projet sur une nouvelle machine, il faut :

- créer une base de données dans phpmyadmin
- une fois cette base créée, se rendre dans le fichier application_manger_mieux/backend/config.php et renseigner le nom de la base, le user et le password de phpmyadmin. Si vous hostez le server sur un port différent de 3306, vous devez aussi le modifier en accord avec votre port utilisé.

- rendez-vous dans le fichier application_manger_mieux/frontend/js/config.js et modifier le préfixe de l'api, de façon à ce que ça corresponde à votre arborescence de fichiers sur votre machine.

- Enfin, entrez le lien vers le fichier application_manger_mieux/backend/init_db.php. Cela devrait créer votre base de données et la remplir avec les bonnes informations.