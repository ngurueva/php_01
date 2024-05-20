<?php
require_once "BaseAnimalTwigController.php";

class TypeCreateController extends BaseAnimalTwigController {
    public $template = "type_create.twig";

    public function get(array $context) // добавили параметр
    { 
        parent::get($context); // пробросили параметр
    }

    public function post(array $context) { // добавили параметр
        
        $type_name = $_POST['type_name'];

        $tmp_name = $_FILES['image']['tmp_name'];
        $name =  $_FILES['image']['name'];

        move_uploaded_file($tmp_name, "../public/media/$name");

        $image_url = "/media/$name";

        // создаем текст запрос
        $sql = <<<EOL
        INSERT INTO types(name, image)
        VALUES(:type_name, :image_url)
        EOL;

        // подготавливаем запрос к БД
        $query = $this->pdo->prepare($sql);
        // привязываем параметры
        $query->bindValue("type_name", $type_name);
        $query->bindValue("image_url", $image_url);

        // выполняем запрос
        $query->execute();
        
        $context['message'] = 'Вы успешно добавили тип';
        $context['id'] = $this->pdo->lastInsertId(); // получаем id нового добавленного объекта

        $this->get($context);
    }
}