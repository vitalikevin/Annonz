<?php
class Category extends Model
{
    private $id;
    private $categoryName;
    private $categoryDescription;


    public function __construct($id, $categoryName, $categoryDescription)
    {
        $this->id = $id ;
        $this->categoryName = $categoryName ;
        $this->categoryDescription = $categoryDescription ;
    }

   
    public function getId()
    {
        return $this->id;
    }

   
    public function setId($id): void
    {
        $this->id = $id;
    }

  
    public function getCategoryName()
    {
        return $this->categoryName;
    }


    public function setCategoryName($categoryName): void
    {
        $this->categoryName = $categoryName;
    }

    
    public function getCategoryDescription()
    {
        return $this->categoryDescription;
    }

    
    public function setCategoryDescription($categoryDescription): void
    {
        $this->categoryDescription = $categoryDescription;
    }

    
}


    