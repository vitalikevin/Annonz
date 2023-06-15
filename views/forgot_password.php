<?php //session_start();?>

<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>

<body class="is-preload">

    <?php require_once "views/common/navbar.php"; ?>



    <h1> Mot de passe oublié </h1>
    <p> Veuillez saisir votre adresse email : </p>

    <form method="POST" action='<?= URL ?>forgotPassword2'>
        <label for="email"> Adresse email :</label>
        <p> <input type="text" name="email" id="email" required> </p>
        <input type="submit" value="Envoyer">
</body>

</html>

