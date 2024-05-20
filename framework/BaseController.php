<?php
session_set_cookie_params(60*60*10);
session_start();
// класс абстрактный, чтобы нельзя было создать экземпляр
// abstract class BaseController {
//     public PDO $pdo; // добавил поле
//     public array $params;

//     public function setPDO(PDO $pdo) { // и сеттер для него
//         $this->pdo = $pdo;
//     }
//     public function setParams(array $params) {
//         $this->params = $params;
//     }
//     public function getContext(): array {

//         return []; // по умолчанию пустой контекст
//     }
//     public function process_response() {
//         session_set_cookie_params(60 * 60 * 10);
//         session_start();

//         $method = $_SERVER['REQUEST_METHOD']; // вытаскиваем метод
//         $context = $this->getContext();
//         if ($method == 'GET') { // если GET запрос то вызываем get
//             $this->get($context);
//         } else if ($method == 'POST') { // если POST запрос то вызываем get
//             $this->post($context);
//         }
//     }
//     // с помощью функции get будет вызывать непосредственно рендеринг
//     // так как рендерить необязательно twig шаблоны, а можно, например, всякий json
//     // то метод сделаем абстрактным, ну типа кто наследуем BaseController
//     // тот обязан переопределить этот метод
//     public function get(array $context) {} // ну и сюда добавил в качестве параметра 
//     public function post(array $context) {} // и сюда
// }

abstract class BaseController {
    public PDO $pdo; // добавил поле
    public array $params;

    public function setPDO(PDO $pdo) { // и сеттер для него
        $this->pdo = $pdo;
    }
    public function setParams(array $params) {
        $this->params = $params;
    }
    public function getContext(): array {
        return []; // по умолчанию пустой контекст
    }
    
    public function process_response() {
        //session_set_cookie_params(60*60*10);
        //session_start();

        $method = $_SERVER['REQUEST_METHOD'];
        $context = $this->getContext(); // вызываю context тут
        if ($method == 'GET') {
            $this->get($context); // а тут просто его пробрасываю внутрь
        } else if ($method == 'POST') {
            $this->post($context); // и здесь
        }
    }

    public function get(array $context) {}
    public function post(array $context) {}

}