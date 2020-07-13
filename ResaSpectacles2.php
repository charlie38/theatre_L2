<?php
	$titre = "Réservations des spectacles (un curseur)";
	include('entete.php');

	$requete = ("
    SELECT noSpec, nomS, dateRep, count(noSerie) as nbRes
    FROM theatre.lesSpectacles
    NATURAL JOIN theatre.LesRepresentations
    NATURAL JOIN theatre.LesTickets
    GROUP BY noSpec, nomS, dateRep
    ORDER BY noSpec
	");

	$curseur = oci_parse ($lien, $requete);

	$ok = @oci_execute ($curseur);

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
			echo "<p class=\"erreur\"><b>Aucune représentation vide</b></p>" ;

		}
		else {

			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>Numéro du spectacle</th><th>Nom</th><th>Date</th><th>Nombre de places réservées</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$noSpec = oci_result($curseur, 1) ;
                $nomS = oci_result($curseur, 2) ;
                $dateRep = oci_result($curseur, 3) ;
                $nbRes = oci_result($curseur, 4) ;
				echo "<tr><td>$noSpec</td><td>$nomS</td><td>$dateRep</td><td>$nbRes</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>