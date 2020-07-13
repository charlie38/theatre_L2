<?php if(isset($_SESSION['login'])){ ?>
<div id="nav">
    <div id="home" title="retour menu" onclick='window.location.href="menu.php";'></div>
    <div id="new_connection" title="nouvelle connexion" onclick='window.location.href="connexion.php";'></div>
    <div id="previous_page" title="page précédente" onclick='window.location.href="<?php echo $_SERVER['HTTP_REFERER']; ?>";'></div>
</div>
<?php } ?>
