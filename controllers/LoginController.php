<?php

require_once "BaseAnimalTwigController.php";

class LoginController extends BaseAnimalTwigController {
  
    public $template = "login.twig";

    public function get(array $context) // добавили параметр
    { 
        parent::get($context); // пробросили параметр
    }

    public function post(array $context) 
    {
        $username = $_POST['login'];
        $password = $_POST['password'];

        $sql = <<<EOL
        SELECT * FROM users WHERE username = :username AND password = :password
        EOL;

        // подготавливаем запрос к БД
        $query = $this->pdo->prepare($sql);
        // привязываем параметры
        $query->bindValue(":username", $username);
        $query->bindValue(":password", $password);
        // выполняем запрос
        $query->execute();

        $userRow = $query->fetch();

        if ($userRow)
        { 
            $_SESSION['is_logged']=true;
            header("Location: /"); // перенаправляем на главную страницу или на другую страницу
            exit;
        }
        else
           { $_SESSION['is_logged']=false;
            header("Location: /login");
            exit;}

        //echo $_SESSION['is_logged'];
        //return $context;
        //$loginMiddleware = new LoginRequiredMiddleware();
        //$loginMiddleware->apply($this, $context);
        return $context;
      
    }
}