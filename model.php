<?php
class Model {
    public function obtenirUsuaris() {
        require 'connexioBBDD.php';
        $query = "SELECT * FROM usuaris";
        $stmt = $connexio->prepare($query);
        $stmt->execute();
        $usuaris = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuaris;
    }
    //actualitzarComentarisICredencials($_POST["id"], $_POST["comentari"], 1,$_POST["usuari"],$_POST["contrasenya"],$_POST["CodiPracticeTest"],$_POST["dataExamen"]);
    public function actualitzarExamenDataCredencials($id, $comentaris, $credencialsEnviades,$usuari,$contrasenya,$codiPracticeTest,$dataExamen) {
        require 'connexioBBDD.php';

        // Preparar y ejecutar la consulta SQL de actualización
        $query = "UPDATE usuaris SET comentaris = :comentaris, credencials_enviades = :credencialsEnviades, usuari = :usuari, contrasenya = :contrasenya, codiPractice = :codiPractice, dataExamen = :dataExamen WHERE id = :id";
        $stmt = $connexio->prepare($query);
        $stmt->bindParam(':comentaris', $comentaris, PDO::PARAM_STR);
        $stmt->bindParam(':credencialsEnviades', $credencialsEnviades, PDO::PARAM_INT);
        $stmt->bindParam(':usuari', $usuari, PDO::PARAM_STR);
        $stmt->bindParam(':contrasenya', $contrasenya, PDO::PARAM_STR);
        $stmt->bindParam(':codiPractice', $codiPracticeTest, PDO::PARAM_STR);
        $stmt->bindParam(':dataExamen', $dataExamen, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $result = $stmt->execute();

        return $result;
    }
    public function guardarComentari($id, $comentaris) {
        require 'connexioBBDD.php';
        // Preparar y ejecutar la consulta SQL de actualización
        $query = "UPDATE usuaris SET comentaris = :comentaris WHERE id = :id";
        $stmt = $connexio->prepare($query);
        $stmt->bindParam(':comentaris', $comentaris, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $result = $stmt->execute();

        return $result;
    }

    public function eliminarUsuari($id) {
        require 'connexioBBDD.php';
        // Preparar y ejecutar la consulta SQL de actualización
        $query = "DELETE FROM usuaris WHERE id = :id";
        $stmt = $connexio->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
}
?>