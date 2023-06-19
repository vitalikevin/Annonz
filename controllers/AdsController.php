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

    
    public function addEditAd()
    {
        $categoryId = $_POST['categoryId'];
        
            // Récupération des données du formulaire

            $photo = $_FILES['photo'];

            if ($photo['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'photos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); //création du répertoire de destination s'il n'existe pas
                }
                $fileName = uniqid() . '_' . $photo['name'];
                $path = $uploadDir . $fileName;
                move_uploaded_file($photo['tmp_name'], $path);
            }

            
            if (!empty($_POST['id'])){
                
                $ad = new Ad($_POST['id'], $_POST['title'], $_POST['description'], $_POST['price'], $_POST['idUser'],null,$path);
                $this->adManager->editAd($ad, $categoryId,$path);
                
            } else {
                // Création un nouvel objet Ad
                $ad = new Ad(null, $_POST['title'], $_POST['description'], $_POST['price'], $_POST['idUser'],null,$path);
                // Enregistrement de l'annonce dans la base de données
                $this->adManager->newAd($ad, $categoryId,$path);

            }

        
        }

        public function deleteAd($ad)
    {
            $this->adManager->deleteAd($ad);      
    }

    public function getAdsByCategory($category)
    {
        $ads = $this->adManager->getAdsByCategory($category);
        require_once "views/ads.php" ;       
    }
}
