<?php

require_once "models/GamesManager.class.php";


class GamesController
{
    private $gameManager;


    // Constructeur de ma classe
    public function __construct()
    {
        $this->gameManager = new GamesManager();
        
    }

/*
    public function all_games()
    {
        $games = $this->gameManager->get_all_games() ;
        print_r($games);
    }
    public function get_games_by_year($year)
    {
        $games = $this->gameManager->get_all_games_by_year($year) ;
        print_r($games);
    }

    public function get_games_by_platform($id_platform)
    {
        $games = $this->gameManager->get_all_games_by_platform($id_platform) ;
        print_r($games);
    }

    public function get_game($id)
    {
        $game = $this->gameManager->get_game($id) ;
        print_r($game);
    }
*/
    
    

    // Méthode appelée pour renvoyer la liste de tous les jeux sortis une année donnée
    public function get_games_by_year($year)
    {
        $games = $this->gameManager->get_all_games_by_year($year) ;
        // On gère deux types d'affichage : soit l'utilisateur ne précise rien et c'est du json, soit l'utilisateur rajoute ?output=html, dans ce cas il ya un vrai front
        if (isset($_GET["output"]) && $_GET["output"] === "html")
        {
            require_once "views/games.php" ;
        }
        else{
            //print_r($games);
            header('Content-Type: application/json; charset=utf-8'); // Ligne à ne mettre que si je souhaite indiquer que les données que je renvoie sont au format JSON
            echo json_encode($games); // Dans le cadre d'une API, pas de vue, juste des donénes brutes à renvoyer
        }
    }

    // Méthode appelée pour renvoyer la liste de tous les jeux sortis une année donnée
    
    public function all_games()
    {
        $games = $this->gameManager->get_all_games() ;
        // On gère deux types d'affichage : soit l'utilisateur ne précise rien et c'est du json, soit l'utilisateur rajoute ?output=html, dans ce cas il ya un vrai front
        if (isset($_GET["output"]) && $_GET["output"] === "html")
        {
            require_once "views/games.php" ;
        }
        else{
            //print_r($games);
            header('Content-Type: application/json; charset=utf-8'); // Ligne à ne mettre que si je souhaite indiquer que les données que je renvoie sont au format JSON
            echo json_encode($games); // Dans le cadre d'une API, pas de vue, juste des donénes brutes à renvoyer
        }
        
    }




    // Méthode appelée pour renvoyer la liste de tous les jeux sortis sur ue plateforme donnée
    public function get_games_by_platform($id_platform)
    {
        $games = $this->gameManager->get_all_games_by_platform($id_platform) ;

        // On gère deux types d'affichage : soit l'utilisateur ne précise rien et c'est du json, soit l'utilisateur rajoute ?output=html, dans ce cas il ya un vrai front
        if (isset($_GET["output"]) && $_GET["output"] === "html")
        {
            require_once "views/games.php" ;
        }
        else{
             //print_r($games);
            header('Content-Type: application/json; charset=utf-8'); // Ligne à ne mettre que si je souhaite indiquer que les données que je renvoie sont au format JSON
            echo json_encode($games); // Dans le cadre d'une API, pas de vue, juste des donénes brutes à renvoyer
        }
       
    }

    // Méthode appelée pour renvoyer les infos d'un unique jeu donné
    public function get_game($id)
    {
        $game = $this->gameManager->get_game($id) ;
        // On gère deux types d'affichage : soit l'utilisateur ne précise rien et c'est du json, soit l'utilisateur rajoute ?output=html, dans ce cas il ya un vrai front
        if (isset($_GET["output"]) && $_GET["output"] === "html")
        {
            $games = array($game);
            require_once "views/games.php" ;
        }
        else{
            //print_r($games);
            header('Content-Type: application/json; charset=utf-8'); // Ligne à ne mettre que si je souhaite indiquer que les données que je renvoie sont au format JSON
            echo json_encode($game); // Dans le cadre d'une API, pas de vue, juste des donénes brutes à renvoyer
        }
    }
    
}
