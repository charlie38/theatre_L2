<?php

	// récupération des variables
	$noSerie = $_POST['noSerie'];

	$titre = "Détails du ticket numéro $noSerie";
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT noSpec, dateRep, noPlace, noRang, dateEmission, noDossier
		FROM theatre.LesTickets
		WHERE noSerie = :n
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// affectation de la variable
	oci_bind_by_name ($curseur,':n', $noSerie);

	// execution de la requete
	$ok = @oci_execute ($curseur);

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
			echo "<p class=\"erreur\"><b>Ticket inconnu</b></p>" ;

		}
		else {

			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>noSpec</th><th>dateRep</th><th>noPlace</th><th>noRang</th><th>dateEmission</th><th>noDossier</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$noSpec = oci_result($curseur, 1) ;
				$dateRep = oci_result($curseur, 2) ;
				$noPlace = oci_result($curseur, 3) ;
				$noRang = oci_result($curseur, 4) ;
				$dateEmission = oci_result($curseur, 5);
				$noDossier = oci_result($curseur, 6);
				echo "<tr><td>$noSpec</td><td>$dateRep</td><td>$noPlace</td><td>$noRang</td><td>$dateEmission</td><td>$noDossier</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
