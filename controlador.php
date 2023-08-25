<?php
require_once 'model.php';
require 'enviamentcorreusAlumnat.php';
$model = new Model();
$alumnes = $model->obtenirUsuaris();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["usuari"]) or isset($_POST["contrasenya"]) or isset($_POST["CodiPracticeTest"])){
        if(enviarCorreu($_POST["nom"],$_POST["cognoms"],$_POST["correu"],$_POST["curs"],$_POST["usuari"],$_POST["contrasenya"],$_POST["CodiPracticeTest"], $_POST["dataExamen"])){
            $model->actualitzarExamenDataCredencials($_POST["id"], $_POST["comentaris"], 1,$_POST["usuari"],$_POST["contrasenya"],$_POST["CodiPracticeTest"],$_POST["dataExamen"]);
            header('Location: .'); // Redirigir a la página actual
            exit; // Terminar la ejecución del script después de la redirección
        }
    }
}

?>