<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>

<body class="is-preload">

    <?php require_once "views/common/navbar.php"; ?>




        <?php 

        // Instanciation de la classe User pour récupérer toutes les infos et les afficher
        
        $user = new User($_SESSION['id'], $_SESSION['username'], $_SESSION['password'], $_SESSION['email'], $_SESSION['lastname'], $_SESSION['firstname'], $_SESSION['phone'], $_SESSION['birthDate'], $_SESSION['address'], $_SESSION['postalCode'], $_SESSION['city'], $_SESSION['token']);
        $test = $user->getUserByEmail($_SESSION['email']);
        ?>

        <div id="main">
		<div id="column_left">
			<h2>Mes informations personnelles</h2>
			<ul>
				<li><a> Mon identifiant : <?= "<br>" . $test['username'] . "<br><br>"?> </a></li> 
				<li><a> Mon adresse email : <?= "<br>" . $test['email'] . "<br><br>"?> </a></li>
				<li><a> Mon numéro de téléphone : <?= "<br>" . $test['phone'] . "<br><br>"?> </a></li>
				<li><a> Mon adresse : <?= "<br>" . $test['address'] . "<br>" . $test['postalCode'] . "<br>" . $test['city'] . "<br><br>"  ?></a></li>
                <a class='btn btn-primary' href='user_form/<?= $user->getId() ?>' role='button'>Modifier mes informations</a> <?= "<br><br>"?>
			</ul>

		</div>



    <?php require_once "views/common/footer.php"; ?>
</body>

</html>