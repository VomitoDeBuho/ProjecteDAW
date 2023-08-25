<?php
function netejarArrays($array){
    return implode(', ', $array);
}
class Model {
    public function guardarFormulari($nom, $cognoms, $correu, $curs, $certificacions, $justificant) {
        try {
            require_once 'connexioBBDD.php';
            // Consulta SQL de inserción
            $sql = "INSERT INTO usuaris (nom, cognoms, correu_electronic, curs, certificacions, justificant)
            VALUES (:nom, :cognoms, :correu, :curs, :certificacions, :justificant)";

            // Preparar la consulta usando la conexión establecida
            $stmt = $connexio->prepare($sql);

            // Asignar valores a los parámetros
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':cognoms', $cognoms);
            $stmt->bindParam(':correu', $correu);
            $stmt->bindParam(':curs', $curs);
            $certificacions = netejarArrays($certificacions);
            $justificant = netejarArrays($justificant);
            $stmt->bindParam(':certificacions', $certificacions);
            $stmt->bindParam(':justificant', $justificant);

            // Ejecutar la consulta
            $stmt->execute();

        } catch(PDOException $e) {
            echo "Error al inserir : " . $e->getMessage();
        }
    }
}
?>
