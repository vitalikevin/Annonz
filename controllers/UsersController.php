<?php

require_once "models/User.class.php";
require_once "models/UsersManager.class.php";



class UsersController
{
    private $userManager;

    public function __construct()
    {
        $this->userManager = new UsersManager();
        // on demande au manager de charger tous les utilisateurs depuis la base de données
        $this->userManager->loadAllUsers();
    }

    /** fontion appelée par la route /allusers */
    public function display_all_users()
    {
        // on récupère le tableau des utilisateurs dans une variable $users
        $users = $this->userManager->getAllUsers() ;
        // et on charge la vue qui utilisera $users
        require_once "views/users.php";
    }

    public function getUser($id_user)
    {
        $user = $this->userManager->getUser($id_user);
        // On gère deux types d'affichage : soit l'utilisateur ne précise rien et c'est du json, soit l'utilisateur rajoute ?output=html, dans ce cas il ya un vrai front
        
        $users = array($user);
        require_once "views/user_form.php";
    }
    public function addEditUser()
    {

// En cas d'edit, si le champ password est vide, ça signifie que l'utilisateur modifie autre chose et donc on ne touche pas au password.
// Si le champ est rempli, ça signifie que c'est cette donnée qu'il modifie, et donc on hash la nouvelle saisie.

        $password = (!empty($_POST['password'])) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $_SESSION['password'];


            // Récupère les données du formulaire
            
            if (!empty($_POST['id'])){
                
                $user = new User($_POST['id'], $_POST['username'], $password, $_POST['email'], $_POST['lastname'], $_POST['firstname'], $_POST['phone'], $_POST['birthDate'], $_POST['address'], $_POST['postalCode'], $_POST['city'], null);
                $this->userManager->editUser($user);
                
            } else {
                // Crée un nouvel objet User
                $user = new User(null, $_POST['username'], $_POST['password'], $_POST['email'], $_POST['lastname'], $_POST['firstname'], $_POST['phone'], $_POST['birthDate'], $_POST['address'], $_POST['postalCode'], $_POST['city'], null);
                // Enregistre l'utilisateur dans la base de données
                $this->userManager->newUser($user);
            }
        }

    public function deleteUser($user)
    {
            $this->userManager->deleteUser($user);
                   
    }

}

