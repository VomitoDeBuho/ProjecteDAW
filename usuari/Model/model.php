<?php
namespace Model;

use \PDO;

// Funció per netejar i unir els elements d'un array en un string
function netejarArrays($array){
    return implode(', ', $array);
}

// Classe Model que conté la funció per guardar les dades del formulari
class Model {
    public function guardarFormulari($nom, $cognoms, $correu, $curs, $certificacions, $justificant) {
        try {
            require_once 'connexioBBDD.php';

            // Consulta SQL d'inserció
            $sql = "INSERT INTO usuaris (nom, cognoms, correu_electronic, curs, certificacions, justificant)
            VALUES (:nom, :cognoms, :correu, :curs, :certificacions, :justificant)";

            // Preparar la consulta fent servir la connexió establerta
            $stmt = $connexio->prepare($sql);

            // Assignar valors als paràmetres
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':cognoms', $cognoms);
            $stmt->bindParam(':correu', $correu);
            $stmt->bindParam(':curs', $curs);

            // Netejar i unir els arrays de certificacions i justificant
            $certificacions = netejarArrays($certificacions);
            $justificant = netejarArrays($justificant);
            $stmt->bindParam(':certificacions', $certificacions);
            $stmt->bindParam(':justificant', $justificant);

            // Executar la consulta
            $stmt->execute();

        } catch(PDOException $e) {
            echo "Error en la inserció: " . $e->getMessage();
        }
    }
}
?>
