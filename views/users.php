<!DOCTYPE HTML>
<html>
<?php require_once "views/common/header.php"; ?>
<body class="is-preload">

<?php require_once "views/common/navbar.php"; ?>

<?php if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    echo '<div class="' . $message['type'] . '"><i class="fa fa-check"></i>' . $message['message'] . '</div>'; //affiche le 'message' avec le style de la class 'type'
    

    unset($_SESSION['message']); // Supprime le message de la session pour le vider
} ?>


<!-- Wrapper -->
<div id="wrapper">

    <!-- Main -->
    <section id="main" class="wrapper">
        <div class="inner">
            <h1 class="major">Liste de tous les utilisateurs</h1>
            <!-- Table -->
                <div class="table-  wrapper">
                    <table>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom d'utilisateur</th>
                            <th>Email</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // $users est défini dans le controlleur, on peut l'utiliser dans la vue
                        foreach ($users as $user)
                        { ?>
                            <tr>
                                <td><?= htmlentities($user->getId()) ?></td>
                                <td><?= htmlentities(remove_accents($user->getUsername())) ?></td>
                                <td><?= htmlentities($user->getEmail()) ?></td>
                                <td><?= htmlentities($user->getFirstname()) ?></td>
                                <td><?= htmlentities($user->getLastname()) ?></td>
                                <td>
                                    <a class='btn btn-primary' href='user_form/<?= $user->getId() ?>' role='button'>Modifier</a>
                                    <a class='btn btn-primary' href='deleteUser/<?= $user->getId() ?>' role='button' onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">Supprimer</a>
                                   
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

        </div>
    </section>

</div>

<?php require_once "views/common/footer.php"; ?>
</body>
</html>