<?php
require_once "Model.class.php";
require_once "Ad.class.php";

/*******
 * Class UsersManager
 * La classe UserSManager a pour vocation de gérer les objets Users que l'applictaion va créer et manipuler
 */
class AdsManager extends Model
{
    // on conserve les users dans un tableau privé
    private $ads;


    /****
     * @param $user
     * Ajout d'un user au tableau $users
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
        /** vous pouvez écrire les requêtes pour les différents managers de DB, ou bien vous focaliser sur celui de votre choix */
        if (DB_MANAGER == PDO) // version PDO
        {
            $req = $this->getDatabase()->prepare("SELECT * FROM ads WHERE id = ? ");
            $req->execute([$id]);
            $ads = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
        }


        // on a récupéré tous les utilisateurs, on les ajoute au manager de users
        foreach ($ads as $ad) {
            $new_ad = new Ad(
                $ad['id'],
                $ad['title'],
                $ad['description'],
                $ad['price']
            );
            return $new_ad;
        }
    }

    /*public function getAds()
    {
        $req = $this->getDatabase()->prepare('SELECT ads.*, categories.categoryName FROM ads INNER JOIN categories_ads ON ads.id = categories_ads.id_annonce INNER JOIN categories ON categories_ads.id_categorie = categories.id');
        $req->execute();
        $ads = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $ads;
    }*/

    public function getAdsCurrentUser(){
        if (isLogin()) {
            $id_user = $_SESSION['id'];
            return $this->getAllAdsByUser($id_user);
        }
    }

    public function getAllAdsByUser($id_user)
    {
        $results = array();
        /** vous pouvez écrire les requêtes pour les différents managers de DB, ou bien vous focaliser sur celui de votre choix */
        if (DB_MANAGER == PDO) // version PDO
        {
            $req = $this->getDatabase()->prepare("SELECT ads.id, ads.title, ads.description, ads.price, ads.idUser, users.username,categories.categoryName FROM ads LEFT JOIN users ON ads.idUser = users.id INNER JOIN categories_ads ON ads.id = categories_ads.id_annonce INNER JOIN categories ON categories_ads.id_categorie = categories.id WHERE idUser = ? ");
            
            $req->execute([$id_user]);
            $ads = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
        }
        
        // on a récupéré tous les utilisateurs, on les ajoute au manager de users
        foreach ($ads as $ad) {
            $new_ad = new Ad(
                $ad['id'],
                $ad['title'],
                $ad['description'],
                $ad['price'],
                $ad['idUser'],
                $ad['categoryName']
            );
            array_push($results, $new_ad);
        }
        return $results ;
    }

    // charge tous les users dans le manager
    public function loadAllAds()
    {
        /** vous pouvez écrire les requêtes pour les différents managers de DB, ou bien vous focaliser sur celui de votre choix */
        if (DB_MANAGER == PDO) // version PDO
        {

            $req = $this->getDatabase()->prepare('SELECT ads.*, categories.categoryName FROM ads INNER JOIN categories_ads ON ads.id = categories_ads.id_annonce INNER JOIN categories ON categories_ads.id_categorie = categories.id');
            $req->execute();
            $ads = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
        }
        

        // on a récupéré tous les utilisateurs, on les ajoute au manager de users
        foreach ($ads as $ad) {
            $new_ad = new Ad(
                $ad['id'],
                $ad['title'],
                $ad['description'],
                $ad['price'],
                $ad['idUser'],
                $ad['categoryName'] 
            );
            $this->addAd($new_ad);
        }
    }


    public function editAd($ad)
    {
        $type=null;
        $message=null;
        if (DB_MANAGER == PDO) // version PDO
        {
            try {
                $req = $this->getDatabase()->prepare('UPDATE ads SET title = :title, description = :description, price = :price WHERE id = :id');
                $req->execute([
                    'id' => $ad->getId(),
                    'title' => $ad->getTitle(),
                    'description' => $ad->getDescription(),
                    'price' => $ad->getPrice()
                ]);
                if ($req->rowCount()) {
                    // Une ligne a été mise à jour => message de succès
                    $type = 'success';
                    $message = 'Annonce mise à jour';
                } else {
                    // Aucune ligne n'a été mise à jour => message d'erreur
                    $type = 'error';
                    $message = 'Annonce non mise à jour';
                }
            } catch (Exception $e) {
                // Une exception a été lancée, récupération du message de l'exception
                $type = 'error';
                $message = 'Annonce non mise à jour: ' . $e->getMessage();
            }
        }
        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "ads");
    }

    public function newAd($ad,$categoryId,$type=null,$message=null)
    {
        
        if (DB_MANAGER == PDO) // version PDO
        {
            try {
                $req = $this->getDatabase();
                $req1= $req->prepare('INSERT INTO ads (title, description, price, idUser) VALUES (:title, :description, :price, :idUser)');
                $req1->execute([
                    'title' => $ad->getTitle(),
                    'description' => $ad->getDescription(),
                    'price' => $ad->getPrice(),
                    'idUser' => $ad->getIdUser()
                ]);
                // Récupération du dernier ID inséré dans la base de données, qui correspond à l'ID de l'annonce
                $adId = $req->lastInsertId();

                // Insertion dans la table categories_ads qui fait le lien entre ads et categories
            $req2 = $req->prepare('INSERT INTO categories_ads (id_annonce, id_categorie) VALUES (:id_annonce, :id_categorie)');
            $req2->execute([
                'id_annonce' => $adId, 
                'id_categorie' => $categoryId
            ]);

                if ($req1->rowCount() && $req2->rowCount()) {
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
        }
        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "ad_form"); //redirection vers le formulaire en cas d'erreur dans l'ajout
    }

    public function deleteAd($ad,$type=null,$message=null)
    {
   
        if (DB_MANAGER == PDO) // version PDO
        {
            try {
                $req = $this->getDatabase()->prepare('DELETE FROM ads WHERE id = :id');
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
        }
        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "ads");
    }
  
}
