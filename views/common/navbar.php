<!-- Header -->
<header id="header">
    <a href="<?=URL?>index" class="title">Hyperspace</a>
    <nav>
        <ul>
            <!-- Avec la première version : en repartant de category_form pour aller vers la page d'accueil par exemple,
            category_form ne bougeait plus de l'URL, comme si ça le mettait à la racine.
            L'ajout de "URL" ici permet de régler ce problème-->
            <li><a href="<?= URL ?>index" class="<?= str_contains(FULL_URL, "index") || str_contains(FULL_URL, "home") ? "active" : "" ?>">Accueil</a></li>
            <li><a href="<?= URL ?>categories" class="<?= str_contains(FULL_URL, "categories") ? "active" : "" ?>">Catégories</a></li>
            <li><a href="<?= URL ?>ads"  class="<?= str_contains(FULL_URL, "ads") ? "active" : "" ?>">Annonces</a></li>
            <li><a href="<?= URL ?>ads/high-tech" class="<?= str_contains(FULL_URL, "ads/high-tech") ? "active"  : "" ?>">High-Tech</a></li>
				<li><a href="<?= URL ?>ads/mode" class="<?= str_contains(FULL_URL, "ads/mode") ? "active"  : "" ?>">Mode</a></li>
				<li><a href="<?= URL ?>ads/vehicules" class="<?= str_contains(FULL_URL, "ads/vehicules") ? "active"  : "" ?>">Véhicules</a></li>
				<li><a href="<?= URL ?>ads/maison" class="<?= str_contains(FULL_URL, "ads/high-tech") ? "maison"  : "" ?>">Maison</a></li>
				<li><a href="<?= URL ?>ads/divers" class="<?= str_contains(FULL_URL, "ads/divers") ? "active"  : "" ?>">Divers</a></li>
            <li><a href="<?= URL ?>users"  class="<?= str_contains(FULL_URL, "users") ? "active" : "" ?>">Users</a></li>
        </ul>
    </nav>
</header>