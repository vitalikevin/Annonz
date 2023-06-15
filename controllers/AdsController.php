<?php

require_once "models/AdsManager.class.php";


class AdsController
{
    private $adManager;

    public function __construct()
    {
        $this->adManager = new AdsManager();
        // on demande au manager de charger tous les utilisateurs depuis la base de données
        $this->adManager->loadAllAds();
    }

    /** fontion appelée par la route /allusers */
    public function display_all_ads()
    {
        // on récupère le tableau des utilisateurs dans une variable $users
        $ads = $this->adManager->getAllAds() ;
        // et on charge la vue qui utilisera $users
        require_once "views/ads.php";
    }

    public function getAds()
    {
        // on récupère le tableau des utilisateurs dans une variable $users
        $ads = $this->adManager->getAds();
        return $ads;
    }

public function getAdsCurrentUser()
    {
        $ads = $this->adManager->getAdsCurrentUser();
        require_once "views/ads.php" ; 
    }





    public function getAd($id_ad)
    {
        $ad = $this->adManager->getAd($id_ad);
        // On gère deux types d'affichage : soit l'utilisateur ne précise rien et c'est du json, soit l'utilisateur rajoute ?output=html, dans ce cas il ya un vrai front
        
        $ads = array($ad);
        require_once "views/ad_form.php";
    }

    public function getAdsByUser($id_user)
    {
        $ads = $this->adManager->getAllAdsByUser($id_user) ;

        // On gère deux types d'affichage : soit l'utilisateur ne précise rien et c'est du json, soit l'utilisateur rajoute ?output=html, dans ce cas il ya un vrai front
        
            require_once "views/ads.php" ;
        
        
       
    }
    
    public function addEditAd()
    {
        $categoryId = $_POST['categoryId'];
        
            // Récupère les données du formulaire
            
            if (!empty($_POST['id'])){
                
                $ad = new Ad($_POST['id'], $_POST['title'], $_POST['description'], $_POST['price'], $_POST['idUser']);
                $this->adManager->editAd($ad);
                
            } else {
                // Crée un nouvel objet User
                $ad = new Ad(null, $_POST['title'], $_POST['description'], $_POST['price'], $_POST['idUser'],null);
                // Enregistre l'utilisateur dans la base de données
                $this->adManager->newAd($ad, $categoryId);
            }
        }

        public function deleteAd($ad)
    {
            $this->adManager->deleteAd($ad);      
    }
}
