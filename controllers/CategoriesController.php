<?php

require_once "models/CategoriesManager.class.php";


class CategoriesController
{
    private $categoryManager;

    public function __construct()
    {
        $this->categoryManager = new CategoriesManager();
        // on demande au manager de charger tous les utilisateurs depuis la base de données
        $this->categoryManager->loadAllCategories();
    }

    /** fontion appelée par la route /allusers */
    public function display_all_categories()
    {
        // on récupère le tableau des utilisateurs dans une variable $users
        $categories = $this->categoryManager->getAllCategories();
        // et on charge la vue qui utilisera $users
        require_once "views/categories.php";
    }

    public function getCategories()
    {
        // on récupère le tableau des utilisateurs dans une variable $users
        $categories = $this->categoryManager->getCategories();
        return $categories;
    }

    public function getCategory($id_category)
    {
        $category = $this->categoryManager->getCategory($id_category);
        // On gère deux types d'affichage : soit l'utilisateur ne précise rien et c'est du json, soit l'utilisateur rajoute ?output=html, dans ce cas il ya un vrai front
        
        $categories = array($category);
        require_once "views/category_form.php";
    }

    public function addEditCategory()
    {
        
            // Récupère les données du formulaire
            
            if (!empty($_POST['id'])){
                
                $category = new Category($_POST['id'], $_POST['categoryName'], $_POST['categoryDescription']);
                $this->categoryManager->editCategory($category);
                
            } else {
                // Crée un nouvel objet User
                $category = new Category(null, $_POST['categoryName'], $_POST['categoryDescription']);
                // Enregistre l'utilisateur dans la base de données
                $this->categoryManager->newCategory($category);
            }
        }

    public function deleteCategory($category)
    {
            $this->categoryManager->deleteCategory($category);       
    }
}