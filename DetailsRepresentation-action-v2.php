<?php

    // récupération du nom du spectacle
	$spectacle = $_POST['spectacle'];

    $titre = "Détails des représentations pour $spectacle";
    include('entete.php');

    $requete = ("
        SELECT to_char(daterep, 'Day, DD-Month-YYYY HH:MI') as daterep
        FROM theatre.LesSpectacles NATURAL JOIN theatre.LesRepresentations
        WHERE lower(nomS) = lower(:n)
    ");

    // analyse de la requete et association au curseur
    $curseur = oci_parse ($lien, $requete) ;

    // affectation de la variable
    oci_bind_by_name ($curseur, ':n', $spectacle);

    // execution de la requete
    $ok = @oci_execute ($curseur) ;
    // on teste $ok pour voir si oci_execute s'est bien passé
    if (!$ok) {

        // oci_execute a échoué, on affiche l'erreur
        $error_message = oci_error($curseur);
        echo "<p class=\"erreur\">{$error_message['message']}</p>";

    }
    else {

        // oci_execute a réussi, on fetch sur le premier résultat
        $res = oci_fetch ($curseur);

        if (!$res) {

            // il n'y a aucun résultat
            echo "<p class=\"erreur\"><b>Aucune représentation associée à ce spectacle ou spectacle inconnu</b></p>" ;

        }
        else {

            // on affiche la table qui va servir a la mise en page du resultat
            echo "<table><tr><th>Dates de représentation</th></tr>" ;

            // on affiche un résultat et on passe au suivant s'il existe
            do {

                $dateRep = oci_result($curseur, 1);
                echo "<tr><td>$dateRep</td></tr>";

            } while (oci_fetch ($curseur));

            echo "</table>";
        }

    }

    // on libère le curseur
    oci_free_statement($curseur);

    include('pied.php');

?>