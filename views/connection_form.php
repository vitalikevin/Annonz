<?php //session_start();?>

<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>

<body class="is-preload">

    <?php require_once "views/common/navbar.php"; ?>



    <h1> Connexion </h1>
    <p> Bonjour !
        <br><br> Les autres utilisateurs n'attendent plus que vous...<br><br>
    </p>

    <?php
  

    ?>
    <form method="POST" action='<?= URL ?>authentification'>
        <label for="email"> Adresse email :</label>
        <p> <input type="text" name="email" id="email" required> </p>
        <label for="password"> Mot de passe :</label>
        <p> <input type="text" name="password" id="password" required> </p>
        <input type="submit" value="Connexion">
        <li><a href="forgotPassword"  class="<?= str_contains(FULL_URL, "forgotPassword") ? "active" : "" ?>">Mot de passe oublié ?</a></li>
</body>

</html>