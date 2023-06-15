<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>
<body class="is-preload">

<?php require_once "views/common/navbar.php"; ?>

<?php if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    echo '<div class="' . $message['type'] . '">' . $message['message'] . '</div>'; //affiche le 'message' avec le style de la class 'type'
    unset($_SESSION['message']); // Supprime le message de la session pour le vider
} ?>








<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Formulaire d'inscription</h1>
</div>
<div class='row'>
    <form method='post' action='<?= URL ?>addEditUser'>
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id' value='<?= isset($user) ? $user->getId() : '' ?>'>
        <div class='form-group my-3'>
            <label for='username'>Votre nom d'utilisateur</label>
            <input type='text' name='username' class='form-control' id='username' placeholder="Nom d'utilisateur"
                required autofocus value='<?= isset($user) ? htmlentities($user->getUsername()) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='password'>Votre mot de passe</label>
            <input type='text' name='password' class='form-control' id='password' placeholder='Mot de passe' <?php if (!isLogin()) { ?> required <?php } ?>>
        </div>
        <div class='form-group my-3'>
            <label for='password2'>Confirmation du mot de passe</label>
            <input type='text' name='password2' class='form-control' id='password2' placeholder='Mot de passe 2' <?php if (!isLogin()) { ?> required <?php } ?>>
        </div>
<div class='form-group my-3'>
    <label for='email'>Votre adresse email</label>
    <input type='email' name='email' class='form-control' id='email' placeholder='Adresse email' required
    value='<?= isset($user) ? htmlentities($user->getEmail()) : '' ?>'>
</div>
<div class='form-group my-3'>
    <label for='lastname'>Votre nom</label>
    <input type='text' name='lastname' class='form-control' id='lastname' placeholder='Nom' required
    value='<?= isset($user) ? htmlentities($user->getLastname()) : '' ?>'>
</div>
<div class='form-group my-3'>
    <label for='firstname'>Votre prénom</label>
    <input type='text' name='firstname' class='form-control' id='firstname' placeholder='firstname' required
    value='<?= isset($user) ? htmlentities($user->getFirstname()) : '' ?>'>
</div>
<div class='form-group my-3'>
    <label for='phone'>Votre numéro de téléphone</label>
    <input type='tel' name='phone' class='form-control' id='phone' placeholder='Numéro de téléphone'
    value='<?= isset($user) ? htmlentities($user->getPhone()) : '' ?>'>
</div>
<div class='form-group my-3'>
    <label for='birthDate'>Votre date de naissance</label>
    <input type='date' name='birthDate' class='form-control' id='birthDate' placeholder='Date de naissance'
    value='<?= isset($user) ? htmlentities($user->getbirthDate()) : '' ?>'>
</div>
<div class='form-group my-3'>
    <label for='address'>Votre adresse postale</label>
    <input type='text' name='address' class='form-control' id='address' placeholder='Adresse postale'
    value='<?= isset($user) ? htmlentities($user->getAddress()) : '' ?>'>
</div>
<div class='form-group my-3'>
    <label for='postalCode'>Votre code postal</label>
    <input type='number' name='postalCode' class='form-control' id='postalCode' placeholder='Code postal'
    value='<?= isset($user) ? htmlentities($user->getPostalCode()) : '' ?>'>
</div>
<div class='form-group my-3'>
    <label for='city'>Votre ville</label>
    <input type='text' name='city' class='form-control' id='city' placeholder='Ville'
    value='<?= isset($user) ? htmlentities($user->getCity()) : '' ?>'>
</div>
<button type='submit' class='btn btn-primary my-3' name='submit'>Valider</button>
</form>
</div>

<?php require_once "views/common/footer.php"; ?>
</body>
</html>






