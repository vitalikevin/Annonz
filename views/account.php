<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>

<body class="is-preload">

    <?php require_once "views/common/navbar.php"; ?>

    <li><a href="informations" class="<?= str_contains(FULL_URL, "informations") ? "active" : "" ?>">Mes informations</a></li>
    <li><a href="usersAds" class="<?= str_contains(FULL_URL, "usersAds") ? "active" : "" ?>">Mes annonces</a></li>

    <?php require_once "views/common/footer.php"; ?>
</body>

</html>

