<?php
// Inicialitzar les sessions
session_start();

// Tancar la sessió a Google si s'utilitza l'autenticació amb Google
if (isset($_SESSION['google_access_token'])) {
    require_once 'google/vendor/autoload.php'; // Ruta cap a la biblioteca descarregada
    $client = new Google_Client();
    $client->setClientId('977667408700-9nj1gbh0h574j5hbpe48k5c6cl6vp7nf.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->revokeToken($_SESSION['google_access_token']); // Revoquem el token d'accés a Google
}

// Eliminar totes les sessions locals
session_unset(); // Esborrar totes les variables de sessió
session_destroy(); // Destruir la sessió

// Redirigir de nou a la pàgina d'inici de sessió
header("Location: ../index.php");
exit();
?>
