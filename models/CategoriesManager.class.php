<?php
require_once "Model.class.php";
require_once "Category.class.php";

/*******
 * Class UsersManager
 * La classe UserSManager a pour vocation de gérer les objets Users que l'applictaion va créer et manipuler
 */
class CategoriesManager extends Model
{
    // on conserve les users dans un tableau privé
    private $categories;


    /****
     * @param $user
     * Ajout d'un user au tableau $users
     */
    public function addCategory($category)
    {
        $this->categories[] = $category;
    }

    //retourne un tableau
    public function getAllCategories()
    {
        return $this->categories;
    }

    public function getCategory($id)
    {
        $results = array();
        /** vous pouvez écrire les requêtes pour les différents managers de DB, ou bien vous focaliser sur celui de votre choix */
        if (DB_MANAGER == PDO) // version PDO
        {
            $req = $this->getDatabase()->prepare("SELECT * FROM categories WHERE id = ? ");
            $req->execute([$id]);
            $categories = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
        }


        // on a récupéré tous les utilisateurs, on les ajoute au manager de users
        foreach ($categories as $category) {
            $new_category = new Category(
                $category['id'],
                $category['categoryName'],
                $category['categoryDescription']
            );
            return $new_category;
        }
    }


    // charge tous les users dans le manager
    public function loadAllCategories()
    {
        /** vous pouvez écrire les requêtes pour les différents managers de DB, ou bien vous focaliser sur celui de votre choix */
        if (DB_MANAGER == PDO) // version PDO
        {
            $req = $this->getDatabase()->prepare("SELECT * FROM categories ");
            $req->execute();
            $categories = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
        } 

        // on a récupéré tous les utilisateurs, on les ajoute au manager de users
        foreach ($categories as $category) {
            $new_category = new Category(
                $category['id'],
                $category['categoryName'],
                $category['categoryDescription']
            );
            $this->addCategory($new_category);
        }
    }



    public function editCategory($category)
    {
        $type=null;
        $message=null;
        if (DB_MANAGER == PDO) // version PDO
        {
            try {
                $req = $this->getDatabase()->prepare('UPDATE categories SET categoryName = :categoryName, categoryDescription = :categoryDescription WHERE id = :id');
                $req->execute([
                    'id' => $category->getId(),
                    'categoryName' => $category->getCategoryName(),
                    'categoryDescription' => $category->getCategoryDescription()
                ]);
                if ($req->rowCount()) {
                    // Une ligne a été mise à jour => message de succès
                    $type = 'success';
                    $message = 'Catégorie mise à jour';
                } else {
                    // Aucune ligne n'a été mise à jour => message d'erreur
                    $type = 'error';
                    $message = 'Catégorie non mise à jour';
                }
            } catch (Exception $e) {
                // Une exception a été lancée, récupération du message de l'exception
                $type = 'error';
                $message = 'Catégorie non mise à jour: ' . $e->getMessage();
            }
        }
        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "categories");
    }

    public function newCategory($category,$type=null,$message=null)
    {
        
        if (DB_MANAGER == PDO) // version PDO
        {
            try {
                $req = $this->getDatabase()->prepare('INSERT INTO categories (categoryName, categoryDescription) VALUES (:categoryName, :categoryDescription)');
                $req->execute([
                    'categoryName' => $category->getCategoryName(),
                    'categoryDescription' => $category->getCategoryDescription()
                ]);
                if ($req->rowCount()) {
                    $type = 'success';
                    $message = 'Catégorie ajoutée';
                    $_SESSION['message'] = ['type' => $type, 'message' => $message];
                    header("Location: " . URL . "categories"); //redirection vers la liste des catégories en cas d'ajout réussi
                    exit();
                } else {
                    $type = 'error';
                    $message = 'Catégorie non ajoutée';
                }
            } catch (Exception $e) {
                $type = 'error';
                $message = 'Catégorie non ajoutée: ' /*. $e->getMessage()*/;
            }
        }
        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "category_form"); //redirection vers le formulaire en cas d'erreur dans l'ajout
    }

    public function deleteCategory($category,$type=null,$message=null)
    {
   
        if (DB_MANAGER == PDO) // version PDO
        {
            try {
                $req = $this->getDatabase()->prepare('DELETE FROM categories WHERE id = :id');
                $req->execute(['id' => $category]);
                if ($req->rowCount()) {
                    // Une ligne a été mise à jour => message de succès
                    $type = 'success';
                    $message = 'Catégorie supprimée';
                } else {
                    // Aucune ligne n'a été mise à jour => message d'erreur
                    $type = 'error';
                    $message = 'Catégorie non supprimée';
                }
            } catch (Exception $e) {
                // Une exception a été lancée, récupération du message de l'exception
                $type = 'error';
                $message = 'Catégorie non supprimée: ' . $e->getMessage();
            }
        }
        $_SESSION['message'] = ['type' => $type, 'message' => $message];
        header("Location: " . URL . "categories");
    }
}