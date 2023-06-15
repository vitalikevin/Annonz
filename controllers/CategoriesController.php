<?php

require_once "models/CategoriesManager.class.php";


class CategoriesController
{
    private $categoryManager;

    public function __construct()
    {
        $this->categoryManager = new CategoriesManager();
        // on demande au manager de charger toutes les catégories depuis la base de données
        $this->categoryManager->loadAllCategories();
    }

    public function display_all_categories()
    {
        // on récupère le tableau des catégories dans une variable $categories
        $categories = $this->categoryManager->getAllCategories();
        // et on charge la vue qui utilisera $categories
        require_once "views/categories.php";
    }

    public function getCategories()
    {
        // on récupère le tableau des categories dans une variable $categories
        $categories = $this->categoryManager->getCategories();
        return $categories;
    }

    public function getCategory($id_category)
    {
        $category = $this->categoryManager->getCategory($id_category);        
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
                // Crée un nouvel objet Category
                $category = new Category(null, $_POST['categoryName'], $_POST['categoryDescription']);
                // Enregistre la catégorie dans la base de données
                $this->categoryManager->newCategory($category);
            }
        }

    public function deleteCategory($category)
    {
            $this->categoryManager->deleteCategory($category);       
    }
}