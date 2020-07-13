<?php

$titre = "Choix de la catégorie";
include('entete.php');

$requete = ("
	SELECT nomC
	FROM theatre.LesCategories
	ORDER BY nomC
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

		echo "<p class=\"erreur\"><b>Aucune catégorie dans la base de donnée</b></p>";

	}
	else {

		echo ("
			<form action=\"Categorie-action.php\" method=\"post\">
				<label for=\"categorie\">Sélectionnez un ticket :</label>
				<select id=\"categorie\" name=\"categorie\">
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