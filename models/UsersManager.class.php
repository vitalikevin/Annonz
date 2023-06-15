<?php
require_once "Model.class.php";
require_once "User.class.php";

/*******
 * Class UsersManager
 * La classe UserSManager a pour vocation de gérer les objets Users que l'applictaion va créer et manipuler
 */
class UsersManager extends Model
{
    // on conserve les users dans un tableau privé
    private $users;

    

    /****
     * @param $user
     * Ajout d'un user au tableau $users
     */
    public function addUser($user)
    {
        $this->users[] = $user;
    }

    //retourne un tableau
    public function getAllUsers()
    {
        return $this->users;
    }

    public function getUser($id)
    {
        $results = array();
        /** vous pouvez écrire les requêtes pour les différents managers de DB, ou bien vous focaliser sur celui de votre choix */
        if (DB_MANAGER == PDO) // version PDO
        {
            $req = $this->getDatabase()->prepare("SELECT * FROM users WHERE id = ? ");
            $req->execute([$id]);
            $users = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
        }


        // on a récupéré tous les utilisateurs, on les ajoute au manager de users
        foreach ($users as $user) {
            $new_user = new User(
                $user['id'],
                $user['username'],
                $user['password'],
                $user['email'],
                $user['lastname'],
                $user['firstname'],
                $user['phone'],
                $user['birthDate'],
                $user['address'],
                $user['postalCode'],
                $user['city'],
                $user['token'],
            );
            return $new_user;
        }
    }

      

    // charge tous les users dans le manager
    public function loadAllUsers()
    {
        /** vous pouvez écrire les requêtes pour les différents managers de DB, ou bien vous focaliser sur celui de votre choix */
        if (DB_MANAGER == PDO) // version PDO
        {
            $req = $this->getDatabase()->prepare("SELECT * FROM users ");
            $req->execute();
            $users = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
        }
        else if (DB_MANAGER == MEDOO) // version MEDOO
        {
            $users = $this->getDatabase()->select("users", "*") ;
        }

        // on a récupéré tous les utilisateurs, on les ajoute au manager de users
        foreach ($users as $user) {
            $new_user = new User(
                $user['id'],
                $user['username'],
                $user['password'],
                $user['email'],
                $user['lastname'],
                $user['firstname'],
                $user['phone'],
                $user['birthDate'],
                $user['address'],
                $user['postalCode'],
                $user['city'],
                $user['token'],
            );
            $this->addUser($new_user);
        }
    }

    public function editUser($user)
    {
        $type=null;
        $message=null;
        if (DB_MANAGER == PDO) // version PDO
        {
            try {
                $req = $this->getDatabase()->prepare('UPDATE users SET username = :username, password = :password, email = :email, lastname = :lastname,
                firstname = :firstname, phone = :phone, birthDate = :birthDate, address = :address, postalCode = :postalCode, city = :city WHERE id = :id');
                $req->execute([
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'password' => $user->getPassword(),
                    'email' => $user->getEmail(),
                    'lastname' => $user->getLastname(),
                    'firstname' => $user->getFirstname(),
                    'phone' => $user->getPhone(),
                    'birthDate' => $user->getBirthDate(),
                    'address' => $user->getAddress(),
                    'postalCode' => $user->getPostalCode(),
                    'city' => $user->getCity()
                ]);
                if ($req->rowCount()) {
                    // Une ligne a été mise à jour => message de succès
                    $type = 'success';
                    $message = 'Utilisateur mis à jour';
                } else {
                    // Aucune ligne n'a été mise à jour => message d'erreur
                    $type = 'error';
                    $message = 'Utilisateur non mis à jour';
                }
            } catch (Exception $e) {
                // Une exception a été lancée, récupération du message de l'exception
                $type = 'error';
                $message = 'Utilisateur non mis à jour: ' . $e->getMessage();
            }
        }
        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "users");
    }

    public function newUser($user)
    {
        
        if (DB_MANAGER == PDO) // version PDO
        {
            $email=filter_var(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            if(!$user->getUserByEmail($email)) {
                if ($_POST['password']===$_POST['password2']) {
                if(preg_match("/^(?=.*\d)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}$/", $_POST['password']))
                {
                    $token=bin2hex(random_bytes(16));
            try {
                $req = $this->getDatabase()->prepare('INSERT INTO users (username, password, email, lastname, firstname, phone, birthDate, address, postalCode, city, token) VALUES (:username, :password, :email, :lastname, :firstname, :phone, :birthDate, :address, :postalCode, :city, :token)');
                $req->execute([
                    'username' => $user->getUsername(),
                    'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                    'email' => $user->getEmail(),
                    'lastname' => $user->getLastname(),
                    'firstname' => $user->getFirstname(),
                    'phone' => $user->getPhone(),
                    'birthDate' => $user->getBirthDate(),
                    'address' => $user->getAddress(),
                    'postalCode' => $user->getPostalCode(),
                    'city' => $user->getCity(),
                    'token' => $token

                ]); 
                
                if ($req->rowCount()) {
                    $url = URL;
                    $content="<p><a href='$url/validation/$token'>Merci de cliquer sur ce lien pour activer votre compte</a></p>";
                   
                    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                    $headers = array(
                        'MIME-Version' => '1.0',
                        'Content-type' => 'text/html; charset=iso-8859-1',
                        'X-Mailer' => 'PHP/' . phpversion()
                    );
                    mail($user->getEmail(),"Veuillez activer votre compte", $content, $headers);
                    //echo "Inscription réussie. Vous allez recevoir un mail pour activer votre compte";
                    $type = 'success';
                    $message = 'Inscription réussie. Vous allez recevoir un mail pour activer votre compte';
                    $_SESSION['message'] = ['type' => $type, 'message' => $message];
                    header("Location: " . URL . "index"); //redirection vers l'accueil en cas d'inscription réussie
                    exit();
                } else {
                    //echo "Problème lors de l'enregistrement";
                    $type = 'error';
                    $message = 'Problème lors de l\'enregistrement';
                }
            } catch (Exception $e) {
                $type = 'error';
                $message = 'Utilisateur non ajouté: ' . $e->getMessage();
            }
        } else {
        $type = 'error';
        $message = 'Le mot de passe doit comporter au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial';}
        } else {
        $type = 'error';
        $message = 'Les deux mots de passe doivent être identiques';}
        } else {
        $type = 'error';
        $message = 'Un compte existe déjà pour cet email';}
    }
    $_SESSION['message'] = ['type' => $type, 'message' => $message];
    header("Location: " . URL . "user_form"); //redirection vers le formulaire en cas d'erreur dans l'inscription
    }

    public function deleteUser($user)
    {
   
        if (DB_MANAGER == PDO) // version PDO
        {
            try {
                $req = $this->getDatabase()->prepare('DELETE FROM users WHERE id = :id');
                $req->execute(['id' => $user]);
                if ($req->rowCount()) {
                    // Une ligne a été mise à jour => message de succès
                    $type = 'success';
                    $message = 'Utilisateur supprimé';
                } else {
                    // Aucune ligne n'a été mise à jour => message d'erreur
                    $type = 'error';
                    $message = 'Utilisateur non supprimé';
                }
            } catch (Exception $e) {
                // Une exception a été lancée, récupération du message de l'exception
                $type = 'error';
                $message = 'Utilisateur non supprimé: ' /*. $e->getMessage()*/;
            }
        }
        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "users");
    }
}
