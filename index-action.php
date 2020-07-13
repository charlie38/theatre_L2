<?php
	session_start();
	$_SESSION['login'] = $_POST['login'];
	$_SESSION['motdepasse'] = $_POST['motdepasse'];
	include('entete.php');
	if($lien) {
	   echo '<p class="ok"> Connexion réussie. </p>';
	}
?>
<ul class="menu">
	<li><a href="menu.php">Menu principal</a></li>
</ul>
<?php
	include('pied.php');
?>