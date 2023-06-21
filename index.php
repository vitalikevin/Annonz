<?php
session_start();


date_default_timezone_set('Europe/Paris'); 



/***** REQUIRES/INCLUDES *****/
// Chargement du framework Medoo
include_once ("./librairies/medoo/Medoo.php");
// Chargement du framework de routage PHP Router
require_once __DIR__.'/librairies/phprouter/router.php';





/***** SETTINGS/CONSTANTES *****/
define("ROOT_DIR", "annonz") ; // répertoire racine TODO à définir selon le nom de votre projet (dossier qui suit "localhost")
// On définit les différents modes d'accès aux données
define("PDO", 0) ; // connexion par PDO
define("MEDOO", 1) ; // Connexion par Medoo
// Choix du mode de connexion
define("DB_MANAGER", PDO); // TODO choisissez entre PDO ou MEDOO
// Création de deux constantes URL et FULL_URL qui pourront servir dans les controlleurs et/ou vues
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));
define("FULL_URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]/{$_SERVER['REQUEST_URI']}"));


/******** HELPERS *********/
// inclusion des helpers contenant des fonctions utilisables dans toutes les vues
require_once "helpers/string_helper.php";
require_once "helpers/general_helper.php";

/******** CONTROLLERS *********/
// inclusion des controllers (TODO ajoutez les vôtres)
require_once "controllers/WelcomeController.php";
require_once "controllers/UsersController.php";
require_once "controllers/CategoriesController.php";
require_once "controllers/AdsController.php";
require_once "controllers/AuthentificationController.php";


/****** ROUTING *********/
// Réalisation du système de routage
// le fichier .htccess effectue une redirection automatique depuis l'url /nom_de_la_route vers index.php
// On utilise ensuite le micro-framework PHP Router pour gérer les routes


// Pour les routes GET on utilise la fonction get()
// Pour invoquer un contrôleur on crée un callback

/* ETAPE 1 POUR AFFICHER LE MESSAGE SUR LA PAGE INDEX APRES LA CONNEXION*/


if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    echo '<div class="' . $message['type'] . '">' . $message['message'] . '</div>'; //affiche le 'message' avec le style de la class 'type'
    unset($_SESSION['message']); // Supprime le message de la session pour le vider
}





get('/testjson', function(){
    $controller = new WelcomeController();
    $controller->testjson();
});



get('/index', function(){
    $controller = new WelcomeController();
    $controller->index();
});

get('/home', function(){
    $controller = new WelcomeController();
    $controller->index();
});

get('/', function(){
    $controller = new WelcomeController();
    $controller->index();
});

// A PARTIR D'ICI : VRAIES ROUTES DU PROJET



get('/index', function(){
    $controller = new WelcomeController();
    $controller->index();
});

get('/home', function(){
    $controller = new WelcomeController();
    $controller->index();
});

get('/categories', function(){
    $controller = new CategoriesController();
    $controller->display_all_categories();
    require_once "views/categories.php";
});

get('/category_form', function(){
    echo URL;
    include "views/category_form.php";
});

get('/category_form/$id_category', function($id_category){
    echo URL;
    $controller = new CategoriesController();
    $controller -> getCategory($id_category);
});

post('/addEditCategory', function(){
    
    $controller = new CategoriesController();
    $controller -> addEditCategory();
});

get('/deleteCategory/$id_category', function($id_category){
    $controller = new CategoriesController();
    $controller->deleteCategory($id_category);
});

get('/ads', function(){
    $controller = new AdsController();
    $controller->display_all_ads();
});

get('/ad_form', function(){
    echo URL;
    include "views/ad_form.php";
});

get('/ad_form/$id_ad', function($id_ad){
    echo URL;
    $controller = new AdsController();
    $controller -> getAd($id_ad);
});

post('/addEditAd', function(){
    
    $controller = new AdsController();
    $controller -> addEditAd();
});

get('/deleteAd/$id_ad', function($id_ad){
    $controller = new AdsController();
    $controller->deleteAd($id_ad);
});

get('/users', function(){
    $controller = new UsersController();
    $controller->display_all_users();
});

get('/user_form', function(){
    include "views/user_form.php";
});

get('/user_form/$id_user', function($id_user){
    echo URL;
    $controller = new UsersController();
    $controller -> getUser($id_user);
});

post('/addEditUser', function(){
    $controller = new UsersController();
    $controller -> addEditUser();
});

get('/deleteUser/$id_user', function($id_user){
    $controller = new UsersController();
    $controller->deleteUser($id_user);
});

get('/connexion', function(){
    include "views/connection_form.php";
});

post('/authentification', function(){
    $controller = new AuthentificationController();
    $controller -> logUser();
});

get('/validation/$token', function($token){
    $controller = new AuthentificationController();
    $controller -> activUser($token);
});

get('/forgotPassword', function(){
    include "views/forgot_password.php";
});

post('/forgotPassword2', function(){
    $controller = new AuthentificationController();
    $controller -> forgotPassword();
});

get('/resetPassword/$token', function($token){
    include "views/reset_password.php";
});

post('/resetPassword', function(){
    $controller = new AuthentificationController();
    $controller -> resetPassword();
});

get('/logout', function(){
    include "views/logout.php";
});

get('/account', function(){
    include "views/account.php";
});

get('/informations', function(){
    include "views/informations.php";
});


// Route pour voir les annonces d'un user en particulier 

get('/usersAds', function(){
    $controller = new AdsController();
    $controller->getAdsCurrentUser();
});

get('/ads/$category', function($category){
    $controller = new AdsController();
    $controller -> getAdsbyCategory($category);
});

get('/activateAd/$id_ad', function($id_ad){
    $controller = new AdsController();
    $controller -> activateAd($id_ad);
});



















// Autres exemples de routes dont vous pouvez vous inspirer pour écrire les vôtres
/*
// Static GET
// The output -> Index
get('/', '/views/index.php');

// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
get('/user/$id', 'views/user');

// Dynamic GET. Example with 2 variables
// The $name will be available in full_name.php
// The $last_name will be available in full_name.php
// In the browser point to: localhost/user/X/Y
get('/user/$name/$last_name', 'views/full_name.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
get('/product/$type/color/$color', 'product.php');

get('/callback/$name', function($name){
    echo "Callback executed. The name is $name";
});

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
get('/callback/$name/$last_name', function($name, $last_name){
    echo "Callback executed. The full name is $name $last_name";
});

// any can be used for GETs or POSTs
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','/views/404.php');
*/
