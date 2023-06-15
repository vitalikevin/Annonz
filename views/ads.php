<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>

<body class="is-preload">

    <?php require_once "views/common/navbar.php"; ?>



    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Main -->
        <section id="main" class="wrapper">
            <div class="inner">
                <h1 class="major">Liste de toutes les annonces</h1>
                <!-- Table -->
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Prix de vente</th>
                                <th>Catégorie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // $users est défini dans le controlleur, on peut l'utiliser dans la vue
                            foreach ($ads as $ad) { ?>
                                <tr>
                                    <td>
                                        <?= htmlentities($ad->getId()) ?>
                                    </td>
                                    <td>
                                        <?= htmlentities($ad->getTitle()) ?>
                                    </td>
                                    <td>
                                        <?= htmlentities($ad->getDescription()) ?>
                                    </td>
                                    <td>
                                        <?= htmlentities($ad->getPrice()) . " €"  ?>
                                    </td>
                                    <td>
                                        <?= htmlentities($ad->getCategoryName()) ?>
                                    </td>                              
                                    <td>

<!-- Boutons de modification et de suppression d'annonce, disponibles uniquement pour un admin ou pour l'utilisateur ayant publié l'annonce-->
                                    <?php if (isAdmin() OR belongsTo($ad)) { ?>
                                        <a class='btn btn-primary' href='ad_form/<?= $ad->getId() ?>' role='button'>Modifier</a>
                                        <a class='btn btn-primary' href='deleteAd/<?= $ad->getId() ?>' role='button' onclick="return confirm('Voulez-vous vraiment supprimer cette annonce ?')">Supprimer</a>
                                    <?php } ?>  
                                    <td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

<!-- Bouton de publication d'annonce, disponible uniquement pour un utilisateur connecté -->

<?php if (isLogin()) { ?>
<div class='row'>
<div class='col'>
    <a class='btn btn-success' href='<?= URL ?>ad_form' role='button'>Publier une annonce</a>
</div>
<?php } ?>
              

                </div>
        </section>

    </div>

    <?php require_once "views/common/footer.php"; ?>
</body>

</html>