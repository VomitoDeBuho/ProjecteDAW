<?php
require_once 'model.php';
$model = new Model();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["comentaris"]) && isset($_POST["id"])){
        $model->guardarComentari($_POST["id"], $_POST["comentaris"]);
    }
}

?>