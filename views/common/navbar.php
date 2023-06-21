<!-- Header -->
<header id="header">
    <a href="<?=URL?>index" class="title">Anonzz</a>
    <nav>
        <ul>
            <!-- Avec la première version : en repartant de category_form pour aller vers la page d'accueil par exemple,
            category_form ne bougeait plus de l'URL, comme si ça le mettait à la racine.
            L'ajout de "URL" ici permet de régler ce problème-->
            <li><a href="<?= URL ?>index" class="<?= str_contains(FULL_URL, "index") || str_contains(FULL_URL, "home") ? "active" : "" ?>">Accueil</a></li>
            <li><a href="<?= URL ?>categories" class="<?= str_contains(FULL_URL, "categories") ? "active" : "" ?>">Catégories</a></li>
            <li><a href="<?= URL ?>ads/high-tech" class="<?= str_contains(FULL_URL, "ads/high-tech") ? "active"  : "" ?>">High-Tech</a></li>
				<li><a href="<?= URL ?>ads/mode" class="<?= str_contains(FULL_URL, "ads/mode") ? "active"  : "" ?>">Mode</a></li>
				<li><a href="<?= URL ?>ads/vehicules" class="<?= str_contains(FULL_URL, "ads/vehicules") ? "active"  : "" ?>">Véhicules</a></li>
				<li><a href="<?= URL ?>ads/maison" class="<?= str_contains(FULL_URL, "ads/high-tech") ? "maison"  : "" ?>">Maison</a></li>
				<li><a href="<?= URL ?>ads/divers" class="<?= str_contains(FULL_URL, "ads/divers") ? "active"  : "" ?>">Divers</a></li>
                <li><a href="<?= URL ?>ads"  class="<?= str_contains(FULL_URL, "ads") ? "active" : "" ?>">Toutes les annonces</a></li>

            <li><a href="<?= URL ?>users"  class="<?= str_contains(FULL_URL, "users") ? "active" : "" ?>">Users</a></li>
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