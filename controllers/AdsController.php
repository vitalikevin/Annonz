<?php

require_once "models/AdsManager.class.php";


class AdsController
{
    private $adManager;

    public function __construct()
    {
        $this->adManager = new AdsManager();
        // demande au manager de récupérer toutes les annonces depuis la base de données
        $this->adManager->loadAllAds();
    }

    public function display_all_ads()
    {
        // récupération du tableau des annonces dans une variable $ads
        $ads = $this->adManager->getAllAds() ;
        // chargement de la vue qui utilise $users
        require_once "views/ads.php";
    }

public function getAdsCurrentUser()
    {
        $ads = $this->adManager->getAdsCurrentUser();
        require_once "views/ads.php" ; 
    }

    public function getAd($id_ad)
    {
        $ad = $this->adManager->getAd($id_ad);        
        $ads = array($ad);
        require_once "views/ad_form.php";
    }

    public function getAdsByUser($id_user)
    {
        $ads = $this->adManager->getAllAdsByUser($id_user) ;        
            require_once "views/ads.php" ;
    }
    
    public function addEditAd()
    {
        $categoryId = $_POST['categoryId'];
        
            // Récupération des données du formulaire
            
            if (!empty($_POST['id'])){
                
                $ad = new Ad($_POST['id'], $_POST['title'], $_POST['description'], $_POST['price'], $_POST['idUser'],null);
                $this->adManager->editAd($ad);
                
            } else {
                // Création un nouvel objet Ad
                $ad = new Ad(null, $_POST['title'], $_POST['description'], $_POST['price'], $_POST['idUser'],null);
                // Enregistrement de l'annonce dans la base de données
                $this->adManager->newAd($ad, $categoryId);
            }
        }

        public function deleteAd($ad)
    {
            $this->adManager->deleteAd($ad);      
    }
}
