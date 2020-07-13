<?php

	// récupération de la catégorie
	$categorie = $_POST['categorie'];

	//
	$titre = "Liste des places associées au dossier 11 pour la catégorie $categorie";
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT noPlace, noRang, noZone, nomS
		FROM theatre.LesSieges natural join theatre.LesZones natural join theatre.LesTickets natural join theatre.LesSpectacles
		WHERE lower(nomC) = lower(:n)
		AND noDossier = 11
      order by noPlace
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// affectation de la variable
	oci_bind_by_name ($curseur, ':n', $categorie);

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
			echo "<p class=\"erreur\"><b>Aucune place associée à cette catégorie ou catégorie inconnue</b></p>" ;

		}
		else {

			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>Spectacle</th><th>Place</th><th>Rang</th><th>Zone</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$noPlace = oci_result($curseur, 1) ;
				$noRang = oci_result($curseur, 2) ;
				$noZone = oci_result($curseur, 3) ;
				$nomS = oci_result($curseur, 4) ;
				echo "<tr><td>$nomS</td><td>$noPlace</td><td>$noRang</td><td>$noZone</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
