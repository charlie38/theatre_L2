<?php

	$titre = "Réservations d'un spectacle";
	include('entete.php');

	// construction de la requete
	$requete_1 = ("
		SELECT DISTINCT noSpec, to_char(dateRep)
		FROM theatre.LesRepresentations
    ");

	// analyse de la requete et association au curseur
    $curseur = oci_parse ($lien, $requete_1) ;

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
			echo "<p class=\"erreur req_1\"><b>req1 : Aucune représentation dans la base de données</b></p>" ;

		}
		else {

            do{
                // on récupère les resultats de l'itération courrante
                $noSpec = oci_result($curseur, 1) ;
                $dateRep = oci_result($curseur, 2) ;


                // on effectue la requête courrante
                $requete_2 = ("
                    SELECT R.noSpec, S.nomS, R.dateRep, COUNT(T.noSerie)
                    FROM theatre.LesRepresentations R
                    JOIN theatre.LesSpectacles S ON (R.noSpec = S.noSpec)
                    JOIN theatre.LesTickets T ON (R.dateRep = T.dateRep AND R.noSpec = T.noSpec)
                    WHERE (R.noSpec = $noSpec AND to_char(R.dateRep) = '$dateRep')
                    GROUP BY R.noSpec, S.nomS, R.dateRep
                ");

                // analyse de la requete et association au curseur2
                $curseur_2 =  oci_parse ($lien, $requete_2) ;

                // execution de la requete2
                $ok_2 = @oci_execute ($curseur_2) ;

                // s'il y a eu des erreurs:
                if (!$ok_2) {

                    // oci_execute a échoué, on affiche l'erreur
                    $error_message = oci_error($curseur_2);
                    echo "<p class=\"erreur\">{$error_message['message']}</p>";
            
                } 
                // sinon
                else {
                        // on récupère le résultat
                        $res_2 = oci_fetch ($curseur_2);

                        if (!$res_2) {

                            // il n'y a aucun résultat
                
                        } 
                        // on affiche le tableau courant
                        else {
                            echo "<table><tr><th>Spectacle</th><th>NoSpectacle</th><th>Date</th><th>Nombre tickets</th></tr>" ;

                            do {

                                $noSpec = oci_result($curseur_2, 1) ;
                                $nomS = oci_result($curseur_2, 2) ;
                                $dateRep = oci_result($curseur_2, 3) ;
                                $total = oci_result($curseur_2, 4) ;
                                echo "<tr><td>$noSpec</td><td>$nomS</td><td>$dateRep</td><td>$total</td></tr>";
                
                            } while (oci_fetch ($curseur_2));
                
                            echo "</table>";
                        }

                }

            } while ($res = oci_fetch($curseur));

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>