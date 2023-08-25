<?php
/**
 * Connexió a la base de dades, per evitar fer messy code sempre crido a aquesta variable que está en aquest fitxer
 *
 * @author: Alex Blàzquez Ruiz
 */
try {
    $connexio = new PDO('mysql:host=localhost;dbname=certificacionsmos','administrador','CertificacionsMOS');
}
catch (PDOException $e){
    echo $e->getMessage();
    die();
}
finally {
    $DBH = null;
}
?>
