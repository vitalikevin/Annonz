<?php
require_once "Model.class.php";
require_once "Ad.class.php";


class AdsManager extends Model
{
    // on conserve les annonces dans un tableau privé
    private $ads;


    /****
     * @param $ad
     * Ajout d'un ad au tableau $ads
     */
    public function addAd($ad)
    {
        $this->ads[] = $ad;
    }

    //retourne un tableau
    public function getAllAds()
    {
        return $this->ads;
    }

    public function getAd($id)
    {
        $results = array();

        $req = $this->getDatabase()->prepare("SELECT ads.*, pictures.path, categories.categoryName  FROM ads INNER JOIN pictures ON ads.id = pictures.idAd INNER JOIN categories_ads ON ads.id = categories_ads.idAd INNER JOIN categories ON categories_ads.idCategory = categories.id WHERE ads.id = ? ");
        $req->execute([$id]);
        $ads = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();


        // On ajoute chaque annonce au manager après les avoir récupérées
        foreach ($ads as $ad) {
            $new_ad = new Ad(
                $ad['id'],
                $ad['title'],
                $ad['description'],
                $ad['price'],
                $ad['idUser'],
                $ad['categoryName'],
                $ad['path'],
                $ad['active']
            );
            return $new_ad;
        }
    }

    public function getAdsCurrentUser()
    {
        if (isLogin()) {
            $id_user = $_SESSION['id'];
            return $this->getAllAdsByUser($id_user);
        }
    }

    public function getAllAdsByUser($id_user)
    {
        $results = array();

        $req = $this->getDatabase()->prepare("SELECT ads.*, pictures.path, users.username,categories.categoryName FROM ads INNER JOIN pictures ON ads.id = pictures.idAd LEFT JOIN users ON ads.idUser = users.id INNER JOIN categories_ads ON ads.id = categories_ads.idAd INNER JOIN categories ON categories_ads.idCategory = categories.id WHERE idUser = ? ");

        $req->execute([$id_user]);
        $ads = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();


        foreach ($ads as $ad) {
            $new_ad = new Ad(
                $ad['id'],
                $ad['title'],
                $ad['description'],
                $ad['price'],
                $ad['idUser'],
                $ad['categoryName'],
                $ad['path'],
                $ad['active']
            );
            array_push($results, $new_ad);
        }
        return $results;
    }

    // charge toutes les annonces dans le manager
    public function loadAllAds()
    {


        $req = $this->getDatabase()->prepare('SELECT ads.*, categories.categoryName, pictures.path FROM ads INNER JOIN pictures ON ads.id = pictures.idAD INNER JOIN categories_ads ON ads.id = categories_ads.idAd INNER JOIN categories ON categories_ads.idCategory = categories.id');
        $req->execute();
        $ads = $req->fetchAll(PDO::FETCH_ASSOC); 
        $req->closeCursor();


        // on a récupéré toutes les annonces, on les ajoute à leur manager
        foreach ($ads as $ad) {
            $new_ad = new Ad(
                $ad['id'],
                $ad['title'],
                $ad['description'],
                $ad['price'],
                $ad['idUser'],
                $ad['categoryName'],
                $ad['path'],
                $ad['active']
            );
            $this->addAd($new_ad);
        }
    }


    public function editAd($ad, $categoryId, $path)
    {
        $type = null;
        $message = null;

        try {
            $req = $this->getDatabase();
            $req1 = $req->prepare('UPDATE ads SET title = :title, description = :description, price = :price WHERE id = :id');
            $req1->execute([
                'id' => $ad->getId(),
                'title' => $ad->getTitle(),
                'description' => $ad->getDescription(),
                'price' => $ad->getPrice()
            ]);

            $req2 = $req->prepare('UPDATE categories_ads SET idAd = :idAd, idCategory = :idCategory WHERE idAd = :idAd');
            $req2->execute([
                'idAd' => $ad->getId(),
                'idCategory' => $categoryId
            ]);

            $req3 = $req->prepare('UPDATE pictures SET idAd = :idAd, path = :path WHERE adId = :adId');
            $req3->execute([
                'adId' => $ad->getId(),
                'path' => $path
            ]);


            if ($req1->rowCount() && $req2->rowCount() && $req3->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'Annonce mise à jour';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'Annonce non mise à jour 1';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Annonce non mise à jour 2 ' . $e->getMessage();
        }

        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "ads");

    }

    public function newAd($ad, $categoryId, $path, $type = null, $message = null)
    {



        try {
            $req = $this->getDatabase();
            $req1 = $req->prepare('INSERT INTO ads (title, description, price, idUser) VALUES (:title, :description, :price, :idUser)');
            $req1->execute([
                'title' => $ad->getTitle(),
                'description' => $ad->getDescription(),
                'price' => $ad->getPrice(),
                'idUser' => $ad->getIdUser()
            ]);
            // Récupération du dernier ID inséré dans la base de données, qui correspond à l'ID de l'annonce
            $adId = $req->lastInsertId();

            // Insertion dans la table categories_ads qui fait le lien entre ads et categories
            $req2 = $req->prepare('INSERT INTO categories_ads (idAd, idCategory) VALUES (:idAd, :idCategory)');
            $req2->execute([
                'idAd' => $adId,
                'idCategory' => $categoryId
            ]);

            $req3 = $req->prepare('INSERT INTO pictures (idAd, path) VALUES (:adId, :path)');
            $req3->execute([
                'adId' => $adId,
                'path' => $path
            ]);


            if ($req1->rowCount() && $req2->rowCount() && $req3->rowCount()) {
                $type = 'success';
                $message = 'Annonce ajoutée';
                $_SESSION['message'] = ['type' => $type, 'message' => $message];
                header("Location: " . URL . "ads"); //redirection vers la liste des annonces en cas d'ajout réussi
                exit();
            } else {
                $type = 'error';
                $message = 'Annonce non ajoutée 1';
            }
        } catch (Exception $e) {
            $type = 'error';
            $message = 'Annonce non ajoutée 2 ' . $e->getMessage();
        }

        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "ad_form"); //redirection vers le formulaire en cas d'erreur dans l'ajout
    }

    public function deleteAd($ad, $type = null, $message = null)
    {

if (!isAdmin()) {
    $condition = " AND idUser = '" . $_SESSION['id'] . " ' ";
} else $condition = "";

        try {
            $req = $this->getDatabase()->prepare('DELETE FROM ads WHERE id = :id' . $condition);
            $req->execute(['id' => $ad]);
            if ($req->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'Annonce supprimée';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'Annonce non supprimée';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Annonce non supprimée: ' . $e->getMessage();
        }

        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "ads");
    }

    public function getAdsByCategory($category)
    {
        $results = array();

        $req = $this->getDatabase()->prepare("SELECT ads.*, pictures.path, users.username,categories.categoryName FROM ads LEFT JOIN users ON ads.idUser = users.id INNER JOIN pictures ON ads.id = pictures.idAd INNER JOIN categories_ads ON ads.id = categories_ads.idAd INNER JOIN categories ON categories_ads.idCategory = categories.id WHERE categoryName = ? ");

        $req->execute([$category]);
        $ads = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();


        foreach ($ads as $ad) {
            $new_ad = new Ad(
                $ad['id'],
                $ad['title'],
                $ad['description'],
                $ad['price'],
                $ad['idUser'],
                $ad['categoryName'],
                $ad['path'],
                $ad['active']
            );
            array_push($results, $new_ad);
        }
        return $results;
    }

    public function activateAd($ad)
    {

            $req = $this->getDatabase();
            $req1 = $req->prepare('UPDATE ads SET active = :active WHERE id = :id');
            $req1->execute([
                'id' => $ad->getId(),
                'active' => 1
            ]);
    

    header("Location: " . URL . "ads");


}

}