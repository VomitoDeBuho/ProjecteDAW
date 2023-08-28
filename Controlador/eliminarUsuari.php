<?php
//Utilitzo la clase model per exportar les dades cap a Model/model.php
use Model\Model;

require_once '../Model/model.php'; // Inclou el fitxer que conté la classe Model
// Creo l'objecte model per poder accedir a les seves funcions i dades
$model = new Model();

// Si es realitza una sol·licitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comprovo si les dades d'identificador (id) i justificant estan establertes
    if (isset($_POST["id"]) && isset($_POST["justificant"])) {
        // Elimino l'usuari utilitzant la funció eliminarUsuari de l'objecte $model
        $model->eliminarUsuari($_POST["id"]);
        // Esborro el fitxer de justificant del directori
        unlink('usuari/Controlador/justificantsPDF/'.$_POST["justificant"]);
    }
}

?>
