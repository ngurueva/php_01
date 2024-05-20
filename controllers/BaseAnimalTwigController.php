<?php
class BaseAnimalTwigController extends TwigBaseController {
    public function getContext() : array
    {
        $context = parent::getContext(); // вызываем родительский метод

        $query = $this->pdo->prepare("SELECT DISTINCT name FROM types ORDER BY 1");
        $query->execute();
    
        $types = $query->fetchAll();
        $context['types'] = $types;

        // $context["messages"] = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];

        $is_logged = isset($_SESSION['is_logged']) ? $_SESSION['is_logged'] : false;

        $url = $_SERVER["REQUEST_URI"];

        $context['url'] = $url;
       
        if ($is_logged)
        {
            if (!isset($_SESSION['visitedPages'])) {
                $_SESSION['visitedPages'] = [];
            }
            

            $lastVisitedPage = isset($_SESSION['visitedPages'][0]) ? $_SESSION['visitedPages'][0] : '';

            if ($url !== $lastVisitedPage && $url!=='/logout') {
        
                array_unshift($_SESSION['visitedPages'], $url);

                if (count($_SESSION['visitedPages']) > 10) {
                    array_pop($_SESSION['visitedPages']);
                }
            }

            $context["visitedPages"] = isset($_SESSION['visitedPages']) ? $_SESSION['visitedPages'] : [];
        }
        return $context;
    }
}