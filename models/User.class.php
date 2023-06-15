<?php

require_once 'Model.class.php';

class User extends Model
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $lastname;
    private $firstname;
    private $phone;
    private $birthDate;
    private $address;
    private $postalCode;
    private $city;
    private $token;
    private $isAdmin;




    public function __construct($id, $username, $password, $email, $lastname, $firstname, $phone, $birthDate, $address, $postalCode, $city, $token)
    {
        $this->id = $id ;
        $this->username = $username ;
        $this->password = $password ;
        $this->email = $email ;
        $this->lastname = $lastname ;
        $this->firstname = $firstname ;
        $this->phone = $phone ;
        $this->birthDate = $birthDate ;
        $this->address = $address ;
        $this->postalCode = $postalCode ;
        $this->city = $city ;
        $this->token = $token ;
    }

  
    public function getId()
    {
        return $this->id;
    }

    
    public function setId($id): void
    {
        $this->id = $id;
    }

   
    public function getUsername()
    {
        return $this->username;
    }

    
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    
    public function getPassword()
    {
        return $this->password;
    }

   
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    
    public function setEmail($email): void
    {
        $this->email = $email;
    }
    
    public function getLastname()
    {
        return $this->lastname;
    }

    
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getAddress()
    {
        return $this->address;
    }

    
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    
    public function setPostalCode($postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getCity()
    {
        return $this->city;
    }

    
    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function getToken()
    {
        return $this->token;
    }

    
    public function setToken($token): void
    {
        $this->token = $token;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    
    public function setIsAdmin($isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getUserByEmail($email) {
        try {
            $req = $this->getDatabase()->prepare("SELECT * FROM users WHERE email = :email ");
            $req->execute(['email'=>$email]);
            if ($req->rowCount()){
                // Renvoie toutes les infos de l'utilisateur
                return $req->fetch();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        } 
        return false;
      } 

      public function getUserByToken($token) {
        try {
            $req = $this->getDatabase()->prepare("SELECT * FROM users WHERE token = :token ");
            $req->execute(['token'=>$token]);
            if ($req->rowCount()){
                // Renvoie toutes les infos de l'utilisateur
                return $req->fetch();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        } 
        return false;
      } 

   

    public function createUser($username, $password, $email, $lastname, $firstname, $phone, $birthDate, $address, $postalCode, $city, $token) {

        $database = $this->getDatabase();

        try {
            $createUserStmt = $database->prepare('INSERT INTO users (username, password, email, lastname, firstname, phone, birthDate, address, postalCode, city, token)
            VALUES (:username, :password, :email, :lastname, :firstname, :phone, :birthDate, :address, :postalCode, :city, :token)');
            $createUserStmt->execute([
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'phone' => $phone,
                'birthDate' => $birthDate,
                'address' => $address,
                'postalCode' => $postalCode,
                'city' => $city,
                'token' => $token,
                
            ]);

            if ($createUserStmt->rowCount()) {
                $type = 'success';
                $message = 'Utilisateur ajouté';
            } else {
                $type = 'error';
                $message = 'Utilisateur non ajouté';
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = 'Utilisateur non ajouté: ' . $e->getMessage();
        }

        return ['type' => $type, 'message' => $message];
    }


}