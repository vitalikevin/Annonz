<?php
class CategorieAd extends Model
{
    private $id_annonce;
    private $id_categorie;




    public function __construct($id_annonce,$id_categorie)
    {
        $this->id_annonce = $id_annonce ;
        $this->id_categorie = $id_categorie ;
    }

  
    public function getIdAnnonce()
    {
        return $this->id_annonce;
    }

    
    public function setIdAnnonce($id_annonce): void
    {
        $this->id_annonce = $id_annonce;
    }
    
    public function getIdCategorie()
    {
        return $this->id_categorie;
    }

    
    public function setIdCategorie($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

   

}