<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>
<body class="is-preload">

<?php require_once "views/common/navbar.php"; ?>






<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Liste des annonces</h1>
</div>
<div class='row'>
    <form method='post' action='<?= URL ?>addEditAd'>
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id' value='<?= isset($ad) ? $ad->getId() : '' ?>'>
        <input type='hidden' name='idUser' value='<?= $_SESSION['id']?>'>
        <div class='form-group my-3'>
            <label for='title'>Titre de l'annonce</label>
            <input type='text' name='title' class='form-control' id='title' placeholder="Titre de l'annonce"
                required autofocus value='<?= isset($ad) ? htmlentities($ad->getTitle()) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='description'>Description de l'annonce</label>
            <input type='text' name='description' class='form-control' id='description' placeholder="Description de l'annonce" required
                value='<?= isset($ad) ? htmlentities($ad->getDescription()) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='price'>Prix de vente (€)</label>
            <input type='text' name='price' class='form-control' id='price' placeholder="Prix de vente" required
                value='<?= isset($ad) ? htmlentities($ad->getPrice()) : '' ?>'>
        </div>
   
<button type='submit' class='btn btn-primary my-3' name='submit'>Valider</button>
</form>
</div>

<?php require_once "views/common/footer.php"; ?>
</body>
</html>






