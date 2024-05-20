<?php
require_once "BaseAnimalTwigController.php";

class AnimalObjectUpdateController extends BaseAnimalTwigController {
    public $template = "animal_object_update.twig";

    public function get(array $context) 
    {
        $id = $this->params['id'];

        $sql = <<<EOL
SELECT * FROM south_pole_objects WHERE id = :id
EOL;
        $query = $this->pdo->prepare($sql);
        $query->bindValue("id", $id);
        $query->execute();

        $data = $query->fetch();

        $context['object'] = $data;

        parent::get($context);
    }


//     public function post(array $context) {

//         $id = $this->params['id'];

//         if(isset($_POST['title'], $_POST['description'], $_POST['type'], $_POST['info'], $_FILES['image'])) {
//         $title = $_POST['title'];
//         $description = $_POST['description'];
//         $type = $_POST['type'];
//         $info = $_POST['info'];

//         $tmp_name = $_FILES['image']['tmp_name'];
//         $name = $_FILES['image']['name'];
//         if(move_uploaded_file($tmp_name, "../public/images/$name")) {
//         $image_url = "/images/$name";
//         } else {
//                 $context['error'] = "Ошибка загрузки изображения";
//                 $this->get($context);
//                 return;
//         }


//         $sql = <<<EOL
// UPDATE south_pole_objects 
// SET title = :title, image = :image_url, description = :description, info = :info, type = :type
// WHERE id = :id
// EOL;


//         $query = $this->pdo->prepare($sql);
//         $query->bindValue("title", $title);
//         $query->bindValue("image_url", $image_url);
//         $query->bindValue("description", $description);
//         $query->bindValue("info", $info);
//         $query->bindValue("type", $type);
//         $query->bindValue("id", $id); // подвязываем id объекта
//         $query->execute();

//         // а дальше как обычно
//         $context['message'] = 'Вы успешно отредактировали объект';
//         $context['id'] = $this->params['id'];

//         $this->get($context);
//         } 
//         else {
//                 $context['error'] = "Вы ввели данные не всех ячеек!";
//                 $this->get($context);
//         }

//     }
public function post(array $context) {
        $id = $this->params['id'];
    
        if(isset($_POST['title'], $_POST['description'], $_POST['type'], $_POST['info'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $info = $_POST['info'];
    
            $image_url = null;
            if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $tmp_name = $_FILES['image']['tmp_name'];
                $name = $_FILES['image']['name'];
                if(move_uploaded_file($tmp_name, "../public/images/$name")) {
                    $image_url = "/images/$name";
                } else {
                    $context['error'] = "Ошибка загрузки изображения";
                    $this->get($context);
                    return;
                }
            }
    
            // Проверяем, было ли загружено новое изображение
            if ($image_url === null) {
                // Если изображение не было загружено, сохраняем предыдущий путь к изображению
                $sqlImage = <<<EOL
    SELECT image FROM south_pole_objects WHERE id = :id
    EOL;
                $queryImage = $this->pdo->prepare($sqlImage);
                $queryImage->bindValue("id", $id);
                $queryImage->execute();
                $row = $queryImage->fetch();
                $image_url = $row['image'];
            }
    
            $sql = <<<EOL
    UPDATE south_pole_objects 
    SET title = :title, image = :image_url, description = :description, info = :info, type = :type
    WHERE id = :id
    EOL;
    
            $query = $this->pdo->prepare($sql);
            $query->bindValue("title", $title);
            $query->bindValue("image_url", $image_url);
            $query->bindValue("description", $description);
            $query->bindValue("info", $info);
            $query->bindValue("type", $type);
            $query->bindValue("id", $id); // подвязываем id объекта
            $query->execute();
    
            // а дальше как обычно
            $context['message'] = 'Вы успешно отредактировали объект';
            $context['id'] = $this->params['id'];
    
            $this->get($context);
        } else {
            $this->get($context);
        }
    }
}




