<?php

$titre = "Choix du spectacle";
include('entete.php');

$requete = ("
	SELECT nomS
	FROM theatre.LesSpectacles
	ORDER BY nomS
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

		echo "<p class=\"erreur\"><b>Aucun spectacle dans la base de donnée</b></p>";

	}
	else {

		echo ("
			<form action=\"DetailsRepresentation-action-v2.php\" method=\"post\">
				<label for=\"spectacle\">Sélectionnez un spectacle :</label>
				<select id=\"spectacle\" name=\"spectacle\">
		");

		do {

			$cat = oci_result($curseur, 1);
			echo ("<option value=\"$cat\">$cat</option>");

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