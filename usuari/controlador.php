<?php
require_once 'model.php';
require_once  'enviamentcorreus.php';

$error_messages = array(
    'nom' => '',
    'cognoms' => '',
    'curs' => '',
    'justificant' => '',
    'correu' => ''
);

$opcions_valides_curs = array(
    'SMX1A', 'SMX1B', 'SMX1C', 'SMX1D', 'SMX1E',
    'SMX2A', 'SMX2B', 'ASIX1', 'ASIX2', 'DAW1', 'DAW2', 'altres'
);
$opcions_certificacions_valides = array('Word', 'Excel', 'Access', 'Outlook', 'Powerpoint');

function sanitizeString($str) {
    return preg_replace('/[^A-Za-z0-9ñÑáéíóúÁÉÍÓÚÜü\s%]/', '', $str);
}

// Resto del código del controlador...

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $secretKey = '6LcB97QnAAAAAFEBcG5MX6bpww93l6xW28WF_UOT';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaData = array(
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($recaptchaData)
        )
    );
    $context = stream_context_create($options);
    $recaptchaResult = file_get_contents($recaptchaUrl, false, $context);
    $recaptchaResult = json_decode($recaptchaResult, true);
    if ($recaptchaResult['success']) {
        $nom = sanitizeString($_POST['nom']);
        $cognoms = sanitizeString($_POST['cognoms']);
        $curs = sanitizeString($_POST['curs']);
        $correu = filter_var($_POST['correu'], FILTER_SANITIZE_EMAIL);
        $justificant = $_FILES['justificant'];
        $certificacions = $_POST['certificacions'] ?? array();

        // Validar que todos los campos estén completados
        if (empty($nom)) {
            $error_messages['nom'] = "El camp Nom es obligatori." . "<br>";
        } elseif (strlen($nom) > 50) {
            $error_messages['nom'] = "El camp Nom ha de tenir menys de 50 caràcters." . "<br>";
        }
        if (empty($cognoms)) {
            $error_messages['cognoms'] = "El camp Cognoms es obligatori." . "<br>";
        } elseif (strlen($cognoms) > 50) {
            $error_messages['cognoms'] = "El camp Cognoms ha de tenir menys de 50 caràcters." . "<br>";
        }
        if (empty($curs)) {
            $error_messages['curs'] = "Has de seleccionar un Curs." . "<br>";
        } elseif (!in_array($curs, $opcions_valides_curs)) {
            $error_messages['curs'] = "Curs seleccionat no vàlid." . "<br>";
        }
        if (empty($justificant['name'])) {
            $error_messages['justificant'] = "Has d'adjuntar un Justificant de pagament (PDF)." . "<br>";
        } elseif ($justificant['type'] !== 'application/pdf') {
            $error_messages['justificant'] = "L' arxiu adjuntat no es un PDF." . "<br>";
        } elseif ($justificant['size'] > 2 * 1024 * 1024) {
            $error_messages['justificant'] = "El PDF no pot superar els 2 MB." . "<br>";
        }
        // Moure l'arxiu adjunt a la carpeta persistent
        $rutaTemporal = $justificant['tmp_name'];
        $nomrArxiu = basename($justificant['name']);
        $carpetaDesti = 'justificantsPDF/'; // Canvieu la carpeta segons la vostra configuració
        $rutaDesti = $carpetaDesti . $nomrArxiu;
        if (!move_uploaded_file($rutaTemporal, $rutaDesti)) {
            $error_messages['justificant'] = "Error al guardar el pdf." . "<br>";
        } else {
            $justificant['tmp_name'] = $rutaDesti;
        }
        // Validar que al menos una certificación se haya marcado
        if (empty($certificacions)) {
            $error_messages['certificacions'] = "S'ha de marcar mínim una certificació." . "<br>";
        } else {
            // Verificar que los valores de certificación sean válidos
            foreach ($certificacions as $certificacio) {
                if (!in_array($certificacio, $opcions_certificacions_valides)) {
                    $error_messages['certificacions'] = "Valor de certificació no vàlid." . "<br>";
                    break; // Romper el bucle si se encuentra un valor no válido
                }
            }
        }
        if (empty($correu) || !filter_var($correu, FILTER_VALIDATE_EMAIL)) {
            $error_messages['correu'] = "Correu electrònic no vàlid." . "<br>";
        }

        if (empty(array_filter($error_messages))) {
            // Aquí podrías realizar validaciones adicionales y procesar el archivo subido
            $model = new Model();
            $resultat = $model->guardarFormulari($nom, $cognoms, $correu, $curs, $certificacions, $justificant);
            if (enviarCorreu($nom, $cognoms, $correu, $curs, $certificacions, $justificant)) {
                $correuEnviat = true;
            };
            // Aquí podrías redirigir a una página de confirmación o mostrar un mensaje
            //print_r($resultat);
        }
    }else{
        $error_messages['captcha'] = "Captcha no vàlid." . "<br>";
    }
}

// Incluye la vista proporcionada
include 'index.php';
?>
