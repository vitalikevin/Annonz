<?php //session_start();?>

<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>

<body class="is-preload">

    <?php require_once "views/common/navbar.php"; ?>



    <h1> Réinitialisation du mot de passe </h1>
    <p> Veuillez saisir votre nouveau mot de passe :  </p>

    <form method="POST" action='<?= URL ?>resetPassword'>
    <input type="hidden" name="token" value="<?=$token?>">
        <label for="password"> Nouveau mot de passe :</label>
        <p> <input type="text" name="password" id="password" required> </p>
        <label for="password2"> Confirmer le nouveau mot de passe :</label>
        <p> <input type="text" name="password2" id="password2" required> </p>
        <input type="submit" value="Réinitialiser">
</body>

</html>

