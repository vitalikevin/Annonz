<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>

<body class="is-preload">
<?php require_once "views/common/navbar.php";?>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Formulaire d'inscription</h1>
</div>
<div class='row'>

<!-- sans URL avant addEditCategory, l'update ne marchait pas, c'était un problème d'URL quand il y avait 2 niveaux.
Le rajouter (et l'afficher !) a permis de régler le problème-->





    <form method='post' action='<?= URL ?>addEditCategory'>  
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id' value='<?= isset($category) ? $category->getId() : '' ?>'>
        <div class='form-group my-3'>
            <label for='categoryName'>Nom de la catégorie</label>
            <input type='text' name='categoryName' class='form-control' id='categoryName' placeholder="Nom de la catégorie"
                required autofocus value='<?= isset($category) ? htmlentities($category->getCategoryName()) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='categoryDescription'>Description de la catégorie</label>
            <input type='text' name='categoryDescription' class='form-control' id='categoryDescription' placeholder='Description de la catégorie' required
                value='<?= isset($category) ? htmlentities($category->getCategoryDescription()) : '' ?>'>
        </div>
<button type='submit' class='btn btn-primary my-3' name='submit'>Valider</button>
</form>
</div>

<?php require_once "views/common/footer.php"; ?>
</body>
</html>






