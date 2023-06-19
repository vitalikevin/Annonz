<?php

if (isLogin()) {
	echo "Bonjour " . $_SESSION['username'] . " ! ";
} ?>

<?= var_dump($_SESSION); ?>



<!DOCTYPE HTML>
<!--
	Hyperspace by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
	<title>Hyperspace by HTML5 UP</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="public/assets/css/style.css" />
	<link rel="stylesheet" href="public/assets/css/moncss.css" />
	<noscript>
		<link rel="stylesheet" href="public/assets/css/noscript.css" />
	</noscript>
</head>

<body class="is-preload">


	<!-- Header -->
	<header id="header">
		<nav>
			<ul>
				<!-- Boutons disponibles pour les utilisateurs connectés et les simples visiteurs -->
				<li><a href="index"
						class="<?= str_contains(FULL_URL, "index") || str_contains(FULL_URL, "home") ? "active" : "" ?>">Accueil</a>
				</li>
				<li><a href="categories"
						class="<?= str_contains(FULL_URL, "categories") ? "active" : "" ?>">Catégories</a></li>
				<li><a href="ads" class="<?= str_contains(FULL_URL, "ads") ? "active" : "" ?>">Annonces</a></li>
				<li> <a href="ads/high-tech" class="<?= str_contains(FULL_URL, "ads/high-tech") ?  "active" : "" ?>">High-Tech</a></li>
				<li><a href="ads/mode" class="<?= str_contains(FULL_URL, "ads/mode") ? "active"  : "" ?>">Mode</a></li>
				<li><a href="ads/vehicules" class="<?= str_contains(FULL_URL, "ads/vehicules") ? "active"  : "" ?>">Véhicules</a></li>
				<li><a href="ads/maison" class="<?= str_contains(FULL_URL, "ads/high-tech") ? "maison"  : "" ?>">Maison</a></li>
				<li><a href="ads/divers" class="<?= str_contains(FULL_URL, "ads/divers") ? "active"  : "" ?>">Divers</a></li>
				<li><a href="users" class="<?= str_contains(FULL_URL, "users") ? "active" : "" ?>">Users</a></li>

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


	<h1>Mes petites annonces</h1>
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
	<div id="main">
		<div id="column_left">
			<h2>Catégories</h2>
			<ul>
				<li><a> Véhicule </a></li>
				<li><a> Immobilier </a></li>
				<li><a> Emploi </a></li>
				<li><a> Rencontre </a></li>
				<li><a> Mode </a></li>
				<li><a> Objets </a></li>
				<li><a> Animaux </a></li>
			</ul>

		</div>
		<div class='row'>
			<div class='jumbotron bg-light m-2 p-2'>
				<h1 class='display-4'>Test titre h1 </h1>
				<p class='lead'>Test texte</p>
				<hr class='my-4'>
				<p>Cliquer sur le bouton ci-dessous pour obtenir une liste des catégories</p>
				<p class='lead'>
					<a class='btn btn-primary btn-lg' href='categories.php' role='button'>Catégories</a>
				</p>
				<p>Cliquer sur le bouton ci-dessous pour obtenir une liste des annonces</p>
				<p class='lead'>
					<a class='btn btn-primary btn-lg' href='ads.php' role='button'>Annonces</a>
				</p>
				<p>Cliquer sur le bouton ci-dessous pour obtenir une liste des utilisateurs</p>
				<p class='lead'>
					<a class='btn btn-primary btn-lg' href='users.php' role='button'>Utilisateurs</a>
				</p>
			</div>

		</div>



		<p class='lead'>
			<a class='btn btn-primary btn-lg' href='user_form.php' role='button'>Créer un compte</a>
		</p>

		<p class='lead'>
			<a class='btn btn-primary btn-lg' href='formulaire_connexion.php' role='button'>Connexion</a>
		</p>

		<!-- Footer -->
		<footer id="footer" class="wrapper style1-alt">
			<div class="inner">
				<ul class="menu">
					<li>&copy; Untitled. All rights reserved.</li>
					<li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
				</ul>
			</div>
		</footer>
</body>

</html>
