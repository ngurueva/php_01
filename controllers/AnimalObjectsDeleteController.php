<?php

class AnimalObjectsDeleteController extends BaseController {
    public function post(array $context)
    {
        $id = $_POST['id'];
        $sql =<<<EOL
DELETE FROM south_pole_objects WHERE id = :id
EOL; // сформировали запрос

        $query = $this->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();

        header("Location: /");
        exit;
    }
}