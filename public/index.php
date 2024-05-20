<?php
require_once "../vendor/autoload.php";
require_once "../framework/autoload.php";
require_once "../controllers/MainController.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/AnimalObjectCreateController.php";
require_once "../controllers/AnimalObjectsDeleteController.php";
require_once "../controllers/AnimalObjectUpdateController.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/Controller404.php"; 
require_once "../controllers/BaseAnimalTwigController.php";
require_once "../controllers/SetWelcomeController.php";
require_once "../middlewares/LoginRequiredMiddeware.php"; 
require_once "../controllers/TypeCreateController.php";
require_once "../controllers/LoginController.php"; 
require_once "../controllers/LogoutController.php"; 
require_once "../controllers/function.php";

$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true
]);


$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addFilter(new \Twig\TwigFilter('url_decode', 'urlDecodeFilter'));

$pdo = new PDO("mysql:host=localhost;dbname=south_pole;charset=utf8", "root", "");

$router = new Router($twig, $pdo);
$router->add("/", MainController::class) ->middleware(new LoginRequiredMiddleware());;
$router->add("/south_pole_objects/(?P<id>\d+)", ObjectController::class) ->middleware(new LoginRequiredMiddleware());; 
$router->add("/search", SearchController::class) ->middleware(new LoginRequiredMiddleware());;

$router->add("/south_pole_objects/create", AnimalObjectCreateController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/south_pole_objects/type_create", TypeCreateController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/south_pole_objects/delete", AnimalObjectsDeleteController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/south_pole_objects/(?P<id>\d+)/edit", AnimalObjectUpdateController::class)
    ->middleware(new LoginRequiredMiddleware());

$router->add("/login", LoginController::class);
$router->add("/logout", LogoutController::class);

$router->get_or_default(Controller404::class);
//$router->add("/south_pole_objects/(?P<id>\d+)/delete", AnimalObjectsDeleteController::class);


