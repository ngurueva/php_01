
<?php
require_once "BaseAnimalTwigController.php";
class Controller404 extends BaseAnimalTwigController {
    public $template = "404.twig"; 
    public $title = "Страница не найдена";

    public function getContext(): array
    {
        $context = parent::getContext();
        $image = "public/images/025_image.gif";
        $context['image'] = $image;

        return $context;
    }
    public function get(array $context)
    {
        http_response_code(404);
        parent::get($context);
    }
    
}

