<?php

$titre = "Choix de la catégorie";
include('entete.php');

$requete = ("
	SELECT DISTINCT noDossier
	FROM theatre.LesTickets
	ORDER BY noDossier
");

$curseur = oci_parse ($lien, $requete);

$ok = @oci_execute ($curseur);

if (!$ok) {

	$error_message = oci_error($curseur);
	echo "<p class=\"erreur\">{$error_message['message']}</p>";

}
else {

	$res = oci_fetch ($curseur);

	if (!$res) {

		echo "<p class=\"erreur\"><b>Aucun dossier dans la base de donnée</b></p>";

	}
	else {

		echo ("
			<form action=\"SpectaclesDossier_v3_action.php\" method=\"post\">
				<label for=\"noDossier\">Sélectionnez un numéro de dossier :</label>
				<select id=\"noDossier\" name=\"noDossier\">
		");

		do {

			$no = oci_result($curseur, 1);
			echo ("<option value=\"$no\">$no</option>");

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

oci_free_statement($curseur);

include('pied.php');

?>
