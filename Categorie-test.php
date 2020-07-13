<?php

$categorie = $_POST['categorie'];

$titre = "Liste des tickets pour la catégorie $categorie";
include('entete.php');

$requete = ("
    SELECT DISTINCT nomS
    FROM theatre.LesTickets natural join theatre.LesSieges natural join theatre.LesZones natural join theatre.LesSpectacles
    WHERE nomC = :n
");


$curseur = oci_parse ($lien, $requete);

oci_bind_by_name ($curseur, ':n', $categorie);

$ok = @oci_execute ($curseur);

if (!$ok) {

	$error_message = oci_error($curseur);
	echo "<p class=\"erreur\">{$error_message['message']}</p>";

}
else {

	$res = oci_fetch ($curseur);

	if (!$res) {

		echo "<p class=\"erreur\"><b>Aucun ticket associé à cette catégorie ou catégorie inconnue</b></p>";

	}
	else {

		echo ("
			<form action=\"Categorie-test2.php\" method=\"post\">
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