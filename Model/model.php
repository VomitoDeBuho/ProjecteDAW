<?php

namespace Model;
use \PDO;

// Definició de la classe Model
class Model
{
    // Funció per obtenir la llista d'usuaris de la base de dades
    public function obtenirUsuaris()
    {
        require 'connexioBBDD.php'; // Importar la connexió a la base de dades
        $query = "SELECT * FROM usuaris ORDER BY data_inscripcio DESC;"; // Consulta per seleccionar tots els usuaris
        $stmt = $connexio->prepare($query); // Preparar la consulta
        $stmt->execute(); // Executar la consulta
        $usuaris = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recollir els resultats
        return $usuaris; // Retornar la llista d'usuaris
    }

    // Funció per actualitzar les dades de l'examen i les credencials d'un usuari
    public function actualitzarExamenDataCredencials($id, $comentaris, $credencialsEnviades, $usuari, $contrasenya, $codiPracticeTest, $dataExamen)
    {
        require 'connexioBBDD.php'; // Importar la connexió a la base de dades

        // Preparar i executar la consulta SQL d'actualització
        $query = "UPDATE usuaris SET comentaris = :comentaris, credencials_enviades = :credencialsEnviades, usuari = :usuari, contrasenya = :contrasenya, codiPractice = :codiPractice, dataExamen = :dataExamen WHERE id = :id";
        $stmt = $connexio->prepare($query); // Preparar la consulta
        $stmt->bindParam(':comentaris', $comentaris, PDO::PARAM_STR);
        $stmt->bindParam(':credencialsEnviades', $credencialsEnviades, PDO::PARAM_INT);
        $stmt->bindParam(':usuari', $usuari, PDO::PARAM_STR);
        $stmt->bindParam(':contrasenya', $contrasenya, PDO::PARAM_STR);
        $stmt->bindParam(':codiPractice', $codiPracticeTest, PDO::PARAM_STR);
        $stmt->bindParam(':dataExamen', $dataExamen, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $result = $stmt->execute(); // Executar la consulta

        return $result; // Retornar el resultat de l'execució
    }

    // Funció per guardar un comentari d'un usuari
    public function guardarComentari($id, $comentaris)
    {
        require 'connexioBBDD.php'; // Importar la connexió a la base de dades
        // Preparar i executar la consulta SQL d'actualització
        $query = "UPDATE usuaris SET comentaris = :comentaris WHERE id = :id";
        $stmt = $connexio->prepare($query); // Preparar la consulta
        $stmt->bindParam(':comentaris', $comentaris, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute(); // Executar la consulta

        return $result; // Retornar el resultat de l'execució
    }

    // Funció per eliminar un usuari de la base de dades
    public function eliminarUsuari($id)
    {
        require 'connexioBBDD.php'; // Importar la connexió a la base de dades
        // Preparar i executar la consulta SQL de supressió
        $query = "DELETE FROM usuaris WHERE id = :id";
        $stmt = $connexio->prepare($query); // Preparar la consulta
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute(); // Executar la consulta
        return $result; // Retornar el resultat de l'execució
    }
}

?>
