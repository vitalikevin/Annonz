<?php

if (isLogin()) {
	echo "Bonjour " . $_SESSION['username'] . " ! ";
} ?>


<?php require_once "views/common/header.php"; ?>
<body class="is-preload">

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

</head>



	<!-- Header -->
	<header id="header">
		<nav>
			<ul>


				<!-- Boutons disponibles uniquement pour les utilisateurs connectés-->

				<?php if (isLogin()) { ?>
					<li><a href="account" class="<?= str_contains(FULL_URL, "logout") ? "active" : "" ?>">Mon compte</a></li>
					<li><a href="logout" class="<?= str_contains(FULL_URL, "logout") ? "active" : "" ?>">Déconnexion</a></li>

				<?php } else { ?>
					<li><a href="user_form" class="<?= str_contains(FULL_URL, "user_form") ? "active" : "" ?>">Inscription</a></li>
					<li><a href="connexion" class="<?= str_contains(FULL_URL, "connexion") ? "active" : "" ?>">Connexion</a></li>
				<?php } ?>




			</ul>
		</nav>
	</header>


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
