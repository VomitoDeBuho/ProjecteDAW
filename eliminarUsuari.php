<?php
require_once 'model.php';
$model = new Model();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["id"]) && isset($_POST["justificant"])){
        $model->eliminarUsuari($_POST["id"]);
        unlink('usuari/justificantsPDF/'.$_POST["justificant"]);
    }
}

?>