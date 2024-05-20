<?php
require_once "BaseAnimalTwigController.php"; // импортим TwigBaseController

class MainController extends BaseAnimalTwigController {
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext(): array
    {
        $context = parent::getContext();

        if (isset($_GET['type'])){
            $query = $this->pdo->prepare("SELECT * FROM south_pole_objects WHERE type = :type");
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        }
        else {
            $query = $this->pdo->query("SELECT * FROM south_pole_objects");
        }
        $context['south_pole_objects'] = $query->fetchAll();
        
        return $context;
    }
}