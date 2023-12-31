<?php
class Ad extends Model
{
    private $id;
    private $creationDate;
    private $title;
    private $description;
    private $price;
    private $idUser;
    private $categoryName;
    private $path;
    private $active;



    public function __construct($id,$title, $description, $price, $idUser, $categoryName, $path, $active)
    {
        $this->id = $id ;
        $this->title = $title ;
        $this->description = $description ;
        $this->price = $price ;
        $this->idUser = $idUser;
        $this->categoryName = $categoryName;
        $this->path = $path;
        $this->active = $active;

    }

  
    public function getId()
    {
        return $this->id;
    }

    
    public function setId($id): void
    {
        $this->id = $id;
    }

   
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    
    public function setCreationDate($creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    
    public function getTitle()
    {
        return $this->title;
    }

   
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    
    public function setDescription($description): void
    {
        $this->description = $description;
    }
    
    public function getPrice()
    {
        return $this->price;
    }

    
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    
    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
    }
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    
    public function setCategoryName($categoryName): void
    {
        $this->categoryName = $categoryName;
    }

    public function getPath()
    {
        return $this->path;
    }

    
    public function setPath($path): void
    {
        $this->path = $path;
    }    
    
    public function getActive()
    {
        return $this->active;
    }

    
    public function setActive($active): void
    {
        $this->active = $active;
    }

 

    

}