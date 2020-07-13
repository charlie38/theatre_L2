<?php
//Ici on perd la variable categorie... à stocker dans SESSION?!
$categorie = $_POST['categorie'];
$spectacle = $_POST['spectacle'];

$titre = "Liste des tickets pour $spectacle, catégorie : $categorie";
include('entete.php');

$requete = ("
    SELECT dateRep
    FROM theatre.LesTickets natural join theatre.LesSieges natural join theatre.LesZones natural join theatre.LesSpectacles
    WHERE nomC = :n AND nomS = :s
");


$curseur = oci_parse ($lien, $requete);

oci_bind_by_name ($curseur, ':n', $categorie);
oci_bind_by_name ($curseur, ':s', $spectacle);

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
			<form action=\"Categorie-action.php\" method=\"post\">
				<label for=\"spectacle\">Sélectionnez une date de représentation du spectacle :</label>
				<select id=\"spectacle\" name=\"spectacle\">
		");

		do {

            $spec = oci_result($curseur, 1);
            $date = oci_result($curseur, 2);
			echo ("<option value=\"$spec\">$spec $date</option>");

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