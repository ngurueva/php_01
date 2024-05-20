<?php

require_once "BaseAnimalTwigController.php";

class LogoutController extends BaseAnimalTwigController {
  
    public function post(array $context) 
    {
        $_SESSION["is_logged"] = false;
        header("Location: /login");
        exit;
    }
}