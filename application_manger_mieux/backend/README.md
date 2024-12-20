# 2 Documentation de l'api :

1) personne

    Url des requêtes : `${prefix_api}Personne.php`
    
    endpoint : GET
        paramètres obligatoires : login
        paramètres facultatifs : 

        réponse :
        {"NOM": , "PRENOM": ,"DATE_NAISSANCE": ,"ID_TRANCHE_D_AGE": ,"ID_PRATIQUE": ,"EMAIL": , "PASSWORD": , "ADMIN": }
    
    endpoint : POST
        type des données de la requête : form-data
        paramètres obligatoires : login, date_naissance, id_tranche_d_age, id_pratique, email, password, admin, nom, prenom
        paramètres facultatifs : 

        réponse :
        {"NOM": , "PRENOM": ,"DATE_NAISSANCE": ,"ID_TRANCHE_D_AGE": ,"ID_PRATIQUE": ,"EMAIL": , "PASSWORD": , "ADMIN": }
        (de l'utilisateur qui vient d'être créé)

    endpoint : PUT
    type des données de la requête : json
        paramètres obligatoires : login, date_naissance, id_tranche_d_age, id_pratique, email, password, admin, nom, prenom
        paramètres facultatifs : 

        réponse :
        {"NOM": , "PRENOM": ,"DATE_NAISSANCE": ,"ID_TRANCHE_D_AGE": ,"ID_PRATIQUE": ,"EMAIL": , "PASSWORD": , "ADMIN": }
        (de l'utilisateur qui vient d'être modifié)

    endpoint : DELETE
    type des données de la requête : json
        paramètres obligatoires : login, date_naissance, id_tranche_d_age, id_pratique, email, password, admin, nom, prenom
        paramètres facultatifs : 

        réponse :
        "utilisateur bien supprimé"

2) aliments

    Url des requêtes : `${prefix_api}Aliments.php`
    
    endpoint : GET
        paramètres obligatoires : 
        paramètres facultatifs :    caracteristiques=true (permet d'avoir dans la réponse la liste des caractéristiques associées à chaque aliment qui correspond à la requête)

                                    id_aliment (filtre avec l'id de l'aliment)
                                    nom (filtre avec le nom de l'aliment)


        réponse :

        sans caracteristiques=true:
        {"NOM": , "ID_ALIMENT": }

        avec caracteristiques=true:
        [
            {
                "ID_ALIMENT":,
                "NOM":,
                "CARACTERISTIQUES:{
                    {"ID_CARACTERISTIQUE":,"DESIGNATION":,"POURCENTAGE"},
                    {"ID_CARACTERISTIQUE":,"DESIGNATION":,"POURCENTAGE"}
                }
            }
            {
                "ID_ALIMENT":,
                "NOM":,
                "CARACTERISTIQUES:{
                    {"ID_CARACTERISTIQUE":,"DESIGNATION":,"POURCENTAGE"},
                    {"ID_CARACTERISTIQUE":,"DESIGNATION":,"POURCENTAGE"}
                }
            }
        ]
    
    endpoint : POST
        type des données de la requête : form-data
        paramètres obligatoires : id_aliment, name
        paramètres facultatifs : 

        réponse :
        {"ID_ALIMENT":,"NOM"}
        (de l'aliment qui vient d'être créé)

    endpoint : PUT
    type des données de la requête : json
        paramètres obligatoires : id_aliment, name
        paramètres facultatifs : 

        réponse :
        {"ID_ALIMENT":,"NOM": }
        (de l'aliment qui vient d'être modifié)

    endpoint : DELETE
    type des données de la requête : json
        paramètres obligatoires : id_aliment
        paramètres facultatifs : 

        réponse :
        "aliment bien supprimé"

3) repas

    Url des requêtes : `${prefix_api}Repas.php`
    
    endpoint : GET
        paramètres obligatoires : 
        paramètres facultatifs : id_repas, matin_midi_soir (1 pour matin, 2 pour midi, 3 pour soir), date (AAAA-MM-DD)

        réponse :
        {"ID_REPAS":, "DATE":, "MATIN_MIDI_SOIR":}
    
    endpoint : POST
        type des données de la requête : form-data
        paramètres obligatoires : id_repas, matin_midi_soir (1 pour matin, 2 pour midi, 3 pour soir), date (AAAA-MM-DD)
        paramètres facultatifs : 

        réponse :
        {"ID_REPAS":, "DATE":, "MATIN_MIDI_SOIR":}
        (du repas qui vient d'être créé)

    endpoint : PUT
    type des données de la requête : json
        paramètres obligatoires : id_repas, matin_midi_soir (1 pour matin, 2 pour midi, 3 pour soir), date (AAAA-MM-DD)
        paramètres facultatifs : 

        réponse :
        {"ID_REPAS":, "DATE":, "MATIN_MIDI_SOIR":}
        (du repas qui vient d'être modifié)

    endpoint : DELETE
    type des données de la requête : json
        paramètres obligatoires : id_repas
        paramètres facultatifs : 

        réponse :
        "repas bien supprimé"

4) caracteristiques_de_sante

    Url des requêtes : `${prefix_api}Caracteristiques_de_sante.php`
    
    endpoint : GET
        paramètres obligatoires : 
        paramètres facultatifs : id_caracteristique, designation

        réponse :
        {"ID_CARACTERISTIQUE":, "DESIGNATION":}
    
    endpoint : POST
        type des données de la requête : form-data
        paramètres obligatoires : designation
        paramètres facultatifs : 

        réponse :
        {"ID_CARACTERISTIQUE":, "DESIGNATION"}
        (de la caractéristique qui vient d'être créé)

    endpoint : PUT
    type des données de la requête : json
        paramètres obligatoires : id_caracteristique, designation
        paramètres facultatifs : 

        réponse :
        {"ID_CARACTERISTIQUE":, "DESIGNATION"}
        (de la caractéristique qui vient d'être modifiée)

    endpoint : DELETE
    type des données de la requête : json
        paramètres obligatoires : id_caracteristique
        paramètres facultatifs : 

        réponse :
        "caracteristique bien supprimé"

5) a_comme_caracteristique

    Url des requêtes : `${prefix_api}A_comme_caracteristique.php`
    
    endpoint : GET
        paramètres obligatoires : 
        paramètres facultatifs : id_caracteristique, id_aliment, pourcentage

        réponse :
        {"ID_CARACTERISTIQUE":, "ID_ALIMENT":,"POURCENTAGE"}
    
    endpoint : POST
        type des données de la requête : form-data
        paramètres obligatoires : id_caracteristique, id_aliment, pourcentage
        paramètres facultatifs : 

        réponse :
        {"ID_CARACTERISTIQUE":, "ID_ALIMENT":,"POURCENTAGE"}
        (de la relation caractéristique-aliment qui vient d'être créé)

    endpoint : PUT
    type des données de la requête : json
        paramètres obligatoires : id_caracteristique, id_aliment, pourcentage
        paramètres facultatifs : 

        réponse :
        {"ID_CARACTERISTIQUE":, "ID_ALIMENT":,"POURCENTAGE"}
        (de la relation caractéristique-aliment qui vient d'être modifiée)

    endpoint : DELETE
    type des données de la requête : json
        paramètres obligatoires : id_caracteristique, id_aliment
        paramètres facultatifs : 

        réponse :
        "a_comme_caracteristique bien supprimé"


6) contient

    Url des requêtes : `${prefix_api}Contient.php`
    
    endpoint : GET
        paramètres obligatoires : 
        paramètres facultatifs : id_repas, id_aliment, quantite

        réponse :
        {"ID_REPAS":, "ID_ALIMENT":,"QUANTITE"}
    
    endpoint : POST
        type des données de la requête : form-data
        paramètres obligatoires : id_repas, id_aliment, quantite
        paramètres facultatifs : 

        réponse :
        {"ID_REPAS":, "ID_ALIMENT":,"QUANTITE"}
        (de la relation repas_aliment qui vient d'être créé)

    endpoint : PUT
    type des données de la requête : json
        paramètres obligatoires : id_repas, id_aliment, quantite
        paramètres facultatifs : 

        réponse :
        {"ID_REPAS":, "ID_ALIMENT":,"QUANTITE"}
        (de la relation repas_aliment qui vient d'être modifiée)

    endpoint : DELETE
    type des données de la requête : json
        paramètres obligatoires : id_repas, id_aliment
        paramètres facultatifs : 

        réponse :
        "contient bien supprimé"

7) est_compose_de

    Url des requêtes : `${prefix_api}est_compose_de.php`
    
    endpoint : GET
        paramètres obligatoires : 
        paramètres facultatifs : id_aliment, ali_id_aliment, pourcentage

        réponse :
        {"ALI_ID_ALIMENT":, "ID_ALIMENT":,"POURCENTAGE"}
    
    endpoint : POST
        type des données de la requête : form-data
        paramètres obligatoires : id_aliment, ali_id_aliment, pourcentage
        paramètres facultatifs : 

        réponse :
        {"ALI_ID_ALIMENT":, "ID_ALIMENT":,"POURCENTAGE"}
        (de la relation aliment-aliment qui vient d'être créé)

    endpoint : PUT
    type des données de la requête : json
        paramètres obligatoires :id_aliment, ali_id_aliment, pourcentage
        paramètres facultatifs : 

        réponse :
        {"ALI_ID_ALIMENT":, "ID_ALIMENT":,"POURCENTAGE"}
        (de la relation aliment-aliment qui vient d'être modifiée)

    endpoint : DELETE
    type des données de la requête : json
        paramètres obligatoires : id_aliment, ali_id_aliment
        paramètres facultatifs : 

        réponse :
        "relation aliment-aliment bien supprimée"


8) session

    endpoint : GET
        paramètres obligatoires : 
        paramètres facultatifs : 

        réponse :
        {"LOGIN":}