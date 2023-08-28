<?php
//Utilitzo la clase model per exportar les dades cap a Model/model.php
use Model\Model;

// Incloeixo el fitxer model.php que conté la classe Model
require_once '../Model/model.php';

// Creo un objecte model per accedir a les seves funcions
$model = new Model();

// Verifica si la sol·licitud és de tipus POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comprova si les variables "comentaris" i "id" són definides al formulari
    if (isset($_POST["comentaris"]) && isset($_POST["id"])) {
        // Crida el mètode "guardarComentari" de l'objecte Model
        // per desar els comentaris associats a l'ID especificat
        $model->guardarComentari($_POST["id"], $_POST["comentaris"]);
    }
}
?>
