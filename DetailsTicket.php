<?php

	$titre = "Détails d'un ticket";
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT noSerie
		FROM theatre.LesTickets
		ORDER BY noSerie
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

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
			echo "<p class=\"erreur\"><b>Aucun ticket dans la base de donnée</b></p>" ;

		}
		else {

			// on affiche le formulaire de sélection
			echo ("
				<form action=\"DetailsTicket_action.php\" method=\"post\">
					<label for=\"sel_noSerie\">Sélectionnez un ticket :</label>
					<select id=\"sel_noSerie\" name=\"noSerie\">
			");

			// création des options
			do {

				$noSerie = oci_result($curseur, 1);
				echo ("<option value=\"$noSerie\">$noSerie</option>");

			} while ($res = oci_fetch ($curseur));

			echo ("
					</select>
					<br /><br />
					<input type=\"submit\" value=\"Valider\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	// travail à réaliser
	// echo (" 
	// 	<p class=\"work\">
	// 		Modifiez cet enchaînement de scripts afin d'afficher pour chaque ticket, en plus des informations déjà existantes, sa date d'émission et son numéro de dossier.
	// 	</p>
	// ");

	include('pied.php');

?>