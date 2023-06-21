<?php

if (isLogin()) {
	echo "Bonjour " . $_SESSION['username'] . " ! ";
} ?>



<body class="is-preload">
<?php require_once "views/common/header.php"; ?>

<?php require_once "views/common/navbar.php"; ?>

<!DOCTYPE HTML>
<!--
	Hyperspace by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="public/assets/css/moncss.css" />
	<link rel="stylesheet" href="<?=URL?>public/assets/css/moncss.css" />


</head>





	</div>
	<div id="bar">
		<!-- formulaire de recherche par mot clé -->
		<form action="search.php" method="post">
			Recherche par mots clés:
			<input type="text" name="recherche" />
			<br />
			<input type="radio" name="mode" value="tous_les_mots">Tous les mots
			<input type="radio" name="mode" value="un_mot" checked="checked">Au moins un mot
			<input type="submit" value="Rechercher" name="rechercher" />
		</form>
	</div>
	
		



	<?php require_once "views/common/footer.php"; ?>


		
</body>

</html>
