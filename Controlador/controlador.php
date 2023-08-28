<?php

//Utilitzo la clase model per exportar les dades cap a Model/model.php
use Model\Model;
// Ruta a la biblioteca descargada de google per el google auth
//SENSE COMPOSER
require_once 'google/vendor/autoload.php';

// Codi de configuració de la api de google
$client = new Google_Client();
$client->setClientId('977667408700-9nj1gbh0h574j5hbpe48k5c6cl6vp7nf.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/projecteDAW/index.php');
// Especificar els ambits que demano a la api
$client->setScopes(['openid', 'profile', 'email']);

// Obrim una sessio per obtenir el token de sessio de google
session_start();

// Verifico si l'usuari ha entrat i s'ha loguejat
if (!isset($_SESSION['google_access_token'])) {
    // Comprovo si hi ha un codi d'autorització a la URL
    if (isset($_GET['code'])) {
        // Obtinc el token d'accés utilitzant el codi d'autorització
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        // Emmagatzemo el token d'accés a la variable de sessió
        $_SESSION['google_access_token'] = $token;
    } else {
        // Si no hi ha un codi d'autorització, genero la URL d'autenticació de Google
        $authUrl = $client->createAuthUrl();
        // Redirigeixo l'usuari a la pàgina d'autenticació de Google
        header("Location: $authUrl");
        exit(); // Finalitzo l'execució del script
    }
}


// Obtenir el token de acces desde la sesió (si está configurat)
$accessToken = isset($_SESSION['google_access_token']) ? $_SESSION['google_access_token'] : null;

// Obtenir la informació del usuari autenticat
$infoUsuari = null;
if ($accessToken && isset($accessToken['id_token'])) {
    $infoUsuari = $client->verifyIdToken($accessToken['id_token']);
}

// Verifico la informació del usuari y si té access
if (!$infoUsuari || $infoUsuari['email'] !== 'a.blazquez@sapalomera.cat') {
    // Si no te acces el rediregeixo cap a l'acces_denegat
    unset($_SESSION['google_access_token']);
    header("Location: Controlador/acces_denegat.php");
    exit();
}

// Importo el model per treballar amb la base de dades
//Utilitzo dos rutes per que com estic fent MVC a vegades s'ha d'accedir per un altre lloc
if (file_exists('Model/model.php')) {require_once('Model/model.php');}
if (file_exists('../Model/model.php')) {require_once('../Model/model.php');}

//Importo la funcio per enviar correus al alumnat, que utilitzaré en cas de que hi hagi un POST
require 'enviamentcorreusAlumnat.php';

//Creo l'objecte model per poder utilitzar els metodes que hi han
$model = new Model();
$alumnes = $model->obtenirUsuaris();

// Si es realitza una sol·licitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comprovo si les dades d'usuari, contrasenya o CodiPracticeTest estan establertes
    if (isset($_POST["usuari"]) or isset($_POST["contrasenya"]) or isset($_POST["CodiPracticeTest"])) {
        // Si l'enviament del correu és exitós amb les dades proporcionades
        if (enviarCorreu($_POST["nom"], $_POST["cognoms"], $_POST["correu"], $_POST["curs"], $_POST["usuari"], $_POST["contrasenya"], $_POST["CodiPracticeTest"], $_POST["dataExamen"])) {
            // Actualitzo les dades de l'examen i les credencials a la base de dades
            $model->actualitzarExamenDataCredencials($_POST["id"], $_POST["comentaris"], 1, $_POST["usuari"], $_POST["contrasenya"], $_POST["CodiPracticeTest"], $_POST["dataExamen"]);
            // Redirigeixo a la pàgina actual
            header('Location: ../');
            exit; // Finalitzo l'execució del script després de la redirecció
        }
    }
}

?>
