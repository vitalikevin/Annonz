<?php

require_once "models/Model.class.php";
require_once "models/User.class.php";

class AuthentificationController extends Model
{



    public function logUser()
    {
        $email = filter_var(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        $user = new User(null, null, null, $email, null, null, null, null, null, null, null, null);
        $userInfos = $user->getUserByEmail($email);

        if ($userInfos) {
            if (password_verify($_POST['password'], $userInfos['password'])) {
                if ($userInfos['actif']) {
                    $_SESSION['is_login']=true;
                    $_SESSION['is_actif']=$userInfos['actif'];
                    $_SESSION['isAdmin']=$userInfos['isAdmin'];
                    $_SESSION['id']=$userInfos['id'];
                    $_SESSION['username']=$userInfos['username'];
                    $_SESSION['password']=$userInfos['password'];
                    $_SESSION['email']=$userInfos['email'];
                    $_SESSION['lastname']=$userInfos['lastname'];
                    $_SESSION['firstname']=$userInfos['firstname'];
                    $_SESSION['phone']=$userInfos['phone'];
                    $_SESSION['birthDate']=$userInfos['birthDate'];
                    $_SESSION['address']=$userInfos['address'];
                    $_SESSION['postalCode']=$userInfos['postalCode'];
                    $_SESSION['city']=$userInfos['city'];
                    $_SESSION['token']=$userInfos['token'];

                    $type = 'success';
                    $message = 'Connexion réussie';
                } else {
                $type = 'error';
                $message = 'Veuillez activer votre compte';
                }
            } else {
            $type = 'error';
            $message = 'Mot de passe incorrect';}
        } else {
        $type = 'error';
        $message = 'Cette adresse email n\'est liée à aucun compte existant';
    }
    $_SESSION['message'] = ['type' => $type, 'message' => $message];
    header("Location: " . URL . "index");
    }

    function activUser($token) {

        if (DB_MANAGER == PDO) {
        
        $user = new User(null, null, null, null, null, null, null, null, null, null, null, $token);
        $userInfos = $user->getUserByToken($token);

        if($user){
            if(!$userInfos['actif']){
                try {
                    $req = $this->getDatabase()->prepare('UPDATE users SET token = NULL, actif = 1 WHERE token= :token');
                    
                        $req->execute(['token'=> $token]);
                        if ($req->rowCount()){
                             //return array("success", "Votre compte est activé, vous pouvez vous connecter"); 
                             $type = 'success';
                             $message = 'Votre compte a bien été activé, vous pouvez dès maintenant vous connecter en utilisant vos identifiants';

                        }else {
                        //return array("error", "Problème lors de l'activation"); 
                        $type = 'error';
                        $message = 'Problème lors de l\'activation';
                    }
                } catch (Exception $e) {
                    //return array("error",  $e->getMessage());
                    $type = 'error';
                    $message = 'Problème lors de l\'activation';
                }              
            }else {
            //return array("error", "Ce compte est déjà actif");
            $type = 'error';
            $message = 'Ce compte est déjà actif';
            }
        }else {
        //return array("error", "Lien invalide !");
        $type = 'error';
        $message = 'Lien invalide !';}
        
    }
    $_SESSION['message'] = ['type' => $type, 'message' => $message];
    header("Location: " . URL . "index");
}

function forgotPassword() {
    $email = filter_var(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
    //$email = filter_var(filter_input(INPUT_POST, $_POST['email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL); --> pourquoi mettre $_POST['email'] ça fait que getUserByEmail return false ???
    $user = new User(null, null, null, $email, null, null, null, null, null, null, null, null);
    $userInfos = $user->getUserByEmail($email);

    if($userInfos){
        $token=bin2hex(random_bytes(16));
        $date=time()+1200; //+1200 car dans l'index j'ai défini le fuseau horaire de Paris. Sinon, +1200 revient 1h40 en arrière et je dois donc mettre +8400 pour faire +20 minutes
        $tokenValidityDate = date('Y-m-d H:i:s', $date); //conversion du format timestamp Unix en datetime  

        try {
            $req = $this->getDatabase()->prepare('UPDATE users SET token = :token, tokenValidityDate = :tokenValidityDate WHERE email = :email');
            $req->execute(['token'=> $token, 'tokenValidityDate'=> $tokenValidityDate, 'email'=> $email]); //$userInfos->getEmail() à la place ?,
            if ($req->rowCount()){
                $url = URL;
                $content="<p><a href='$url/resetPassword/$token'>Merci de cliquer sur ce lien pour réinitialiser votre mot de passe</a></p>";
                // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                $headers = array(
                    'MIME-Version' => '1.0',
                    'Content-type' => 'text/html; charset=iso-8859-1',
                    'X-Mailer' => 'PHP/' . phpversion()
                );
                mail($email,"Réinitialisation de mot de passe", $content, $headers);
                //return array("success", "Vous allez recevoir un mail pour réinitialiser votre mot de passe".$content);
                $type = "success";
                $message = "Vous allez recevoir un mail pour réinitialiser votre mot de passe";
            }else {
            //return array("error", "Problème lors du process de réinitialisation");
            $type = "error";
            $message = "Problème lors du process de réinitialisation 1";
            }
            
        } catch (Exception $e) {
            //return array("error",  $e->getMessage());
            $type = "error";
            $message = "Problème lors du process de réinitialisation";
        }
    } else {
    //array("error", "Aucun compte ne correspond à cet email.");
    $type = "error";
    $message = "Aucun compte ne correspond à cet email";
    }
    $_SESSION['message'] = ['type' => $type, 'message' => $message];
    header("Location: " . URL . "index");
}

function resetPassword() {
    
    $token=htmlspecialchars($_POST['token']);
    $user = new User(null, null, null, null, null, null, null, null, null, null, null, $token);
    $userInfos = $user->getUserByToken($token);


    if($userInfos){
        if (time()<$userInfos['tokenValidityDate']){
            if ($_POST['password']===$_POST['password2']){
                if(preg_match("/^(?=.*\d)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}$/", $_POST['password'])){
                    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
                    try {
                        $req = $this->getDatabase()->prepare('UPDATE users SET token = NULL, password = :password, actif = 1 WHERE token= :token');
                        $req->execute(['password'=> $password, 'token'=> $token]);
                        if ($req->rowCount()){
                            $content="<p>Votre mot de passe a été réinitialisé</p>";
                            $headers = array(
                                'MIME-Version' => '1.0',
                                'Content-type' => 'text/html; charset=iso-8859-1',
                                'X-Mailer' => 'PHP/' . phpversion()
                            );
                            mail($userInfos['email'],"Réinitialisation de mot de passe", $content, $headers);
                            //return array("success", "Votre mot de passe a bien été réinitialisé");
                            $type = "success";
                            $message = "Votre mot de passe a bien été réinitialisé, vous pouvez maintenant vous connecter";
                        }else {
                            //return array("error", "Problème lors de la réinitialisation");
                            $type = "error";
                            $message = "Problème lors de la réinitialisation 1";
                        }
                    } catch (Exception $e) {
                        //return array("error",  $e->getMessage());
                        $type = "error";
                        $message = "Problème lors de la réinitialisation 2";
                    } 
                }else {
                    //return array("error", "Le mot de passe doit comporter au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial");
                    $type = "error";
                    $message = "Le mot de passe doit comporter au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial";
                }
            }else {
                //return array("error", "Les 2 saisies de mot de passe doivent être identiques.");
                $type = "error";
                $message = "Les 2 saisies de mot de passe doivent être identiques.";
            }
        }else {
            //return array("error", "Le lien n'est plus valide ! Veuillez <a href='?p=forgot'>recommencer</a>");
            $type = "error";
            $message = "Le lien n'est plus valide ! Veuillez recommencer";
        }
    }else {
        //return array("error", "Les données ont été corrompues ! Veuillez <a href='?p=forgot'>recommencer</a>");
        $type = "error";
        $message = "Les données ont été corrompues ! Veuillez recommencer";
    }
    $_SESSION['message'] = ['type' => $type, 'message' => $message];
    header("Location: " . URL . "index");
}

public function logout(){
    session_unset();
	session_destroy();
}

}