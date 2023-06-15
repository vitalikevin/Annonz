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
            <h1 class="major">Liste de toutes les catégories</h1>
            <!-- Table -->
                <div class="table-wrapper">
                    <table>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom de la catégorie</th>
                            <th>Description de la catégorie</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // $users est défini dans le controlleur, on peut l'utiliser dans la vue
                        foreach ($categories as $category)
                        { ?>
                            <tr>
                                <td><?= htmlentities($category->getId()) ?></td>
                                <td><?= htmlentities($category->getCategoryName()) ?></td>
                                <td><?= htmlentities($category->getCategoryDescription()) ?></td>
                                <td>
                                    <a class='btn btn-primary' href='category_form/<?= $category->getId() ?>' role='button'>Modifier</a>
                                    <a class='btn btn-primary' href='deleteCategory/<?= $category->getId() ?>' role='button' onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')">Supprimer</a>
                                   
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='category_form' role='button'>Ajouter une catégorie</a>
    </div>

        </div>
    </section>

</div>

<?php require_once "views/common/footer.php"; ?>
</body>
</html>