<?php
require_once "BaseAnimalTwigController.php";
class ObjectController extends BaseAnimalTwigController {
    public $template = "__object.twig"; // указываем шаблон

    public function getContext(): array
    {
        $context = parent::getContext();
        $query = $this->pdo->prepare("SELECT * FROM south_pole_objects WHERE id= :my_id");
        // подвязываем значение в my_id 
        $query->bindValue("my_id", $this->params['id']);
        $query->execute(); // выполняем запрос

        // тянем данные
        $data = $query->fetch();

        $context['title'] = $data['title'];
        $context['id'] = $data['id'];
        $context['description'] = $data['description']; 
       
        $context["my_session_message"] = isset($_SESSION['welcome_message']) ? $_SESSION['welcome_message'] : "";

        if (isset($_GET['show'])) {
            if ($_GET['show'] == 'image') {
                $context['image'] = $data['image'];
            } elseif ($_GET['show'] == 'info') {
                $context['info'] = $data['info'];
            }
        }

        $context["messages"] = isset($_SESSION['messages']) ? $_SESSION['messages'] : "";

        return $context;
    }
}