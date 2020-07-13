<?php
	$titre = "Représentations vides";
	include('entete.php');

	$requete = ("
		SELECT nomS, dateRep
		FROM theatre.lesSpectacles
		NATURAL JOIN (SELECT R.noSpec AS noSpec, R.dateRep FROM theatre.LesRepresentations R LEFT JOIN theatre.LesTickets T ON ((R.noSpec = T.noSpec) AND (R.dateRep = T.dateRep)) WHERE ((T.noSpec IS NULL) AND (T.dateRep IS NULL)))
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
			echo "<table><tr><th>Spectacle</th><th>Date</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$nomS = oci_result($curseur, 1) ;
				$dateRep = oci_result($curseur, 2) ;
				echo "<tr><td>$nomS</td><td>$dateRep</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>