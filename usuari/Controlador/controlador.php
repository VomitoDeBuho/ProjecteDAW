<?php
//ARXIU de validació de les dades per BACKEND


//Utilitzo la clase model per exportar les dades cap a Model/model.php
use Model\Model;
require_once '../Model/model.php';
// Importem el fitxer per a l'enviament de correus
require_once  'enviamentcorreus.php';

// Array per emmagatzemar els missatges d'error
$error_messages = array(
    'nom' => '',
    'cognoms' => '',
    'curs' => '',
    'justificant' => '',
    'correu' => '',
    'captcha' => ''
);

// Opcions vàlides del camp curs
$opcions_valides_curs = array(
    'SMX1A', 'SMX1B', 'SMX1C', 'SMX1D', 'SMX1E',
    'SMX2A', 'SMX2B', 'ASIX1', 'ASIX2', 'DAW1', 'DAW2', 'altres'
);

// Opcions vàlides de certificacions
$opcions_certificacions_valides = array('Word', 'Excel', 'Access', 'Outlook', 'Powerpoint');

// Funció per a sanititzar una cadena ho utilitzo quan no puc utilitzar la nativa de PHP,
//per exemple en el camp correu, m'eliminaria "@" i no puc utilitzar la nativa
function sanitizeString($str) {
    return preg_replace('/[^A-Za-z0-9ñÑáéíóúÁÉÍÓÚÜü\s%]/', '', $str);
}

// Comprova si s'ha fet una petició POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configura l'opció de la petició HTTP per verificar el reCAPTCHA
    //Aquestes son les variables de la API de Google
    //Aquest codi el podeu trovar a la documentacio de recapcha que proporciona google
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

    // Verifica si el reCAPTCHA és vàlid
    if ($recaptchaResult['success']) {
        //Recullo les dades del post
        $nom = sanitizeString($_POST['nom']);
        $cognoms = sanitizeString($_POST['cognoms']);
        $curs = sanitizeString($_POST['curs']);
        $correu = filter_var($_POST['correu'], FILTER_SANITIZE_EMAIL);
        $justificant = $_FILES['justificant'];
        $certificacions = $_POST['certificacions'] ?? array();

        // Validacions dels camps del formulari
        //Comprovar que el camp nom no estigui buit
        if (empty($nom)) {
            $error_messages['nom'] = "El camp Nom es obligatori." . "<br>";
            //Comprovar que el camp nom no tingui menys de 50 caracters
        } elseif (strlen($nom) > 50) {
            $error_messages['nom'] = "El camp Nom ha de tenir menys de 50 caràcters." . "<br>";
        }
        //Comprovar que el camp cognom no estigui buit
        if (empty($cognoms)) {
            $error_messages['cognoms'] = "El camp Cognoms es obligatori." . "<br>";
            //Comprovar que el camp cognom no tingui menys de 50 caracters
        } elseif (strlen($cognoms) > 50) {
            $error_messages['cognoms'] = "El camp Cognoms ha de tenir menys de 50 caràcters." . "<br>";
        }
        //Comprovar que el camp curs no estigui buit
        if (empty($curs)) {
            $error_messages['curs'] = "Has de seleccionar un Curs." . "<br>";
            //Comprovar que el camp curs estigui dintre de l'array anteriorment mencionada
        } elseif (!in_array($curs, $opcions_valides_curs)) {
            $error_messages['curs'] = "Curs seleccionat no vàlid." . "<br>";
        }
        //Comprovar que el camp justificant no estigui buit
        if (empty($justificant['name'])) {
            $error_messages['justificant'] = "Has d'adjuntar un Justificant de pagament (PDF)." . "<br>";
            //Comprovo que sigui un pdf
        } elseif ($justificant['type'] !== 'application/pdf') {
            $error_messages['justificant'] = "L' arxiu adjuntat no es un PDF." . "<br>";
            //Comprovo que el pes sigui inferior a 2MB
        } elseif ($justificant['size'] > 2 * 1024 * 1024) {
            $error_messages['justificant'] = "El PDF no pot superar els 2 MB." . "<br>";
        }
        // Moure l'arxiu adjunt a la carpeta del desti
        $rutaTemporal = $justificant['tmp_name'];
        $nomrArxiu = basename($justificant['name']);
        $carpetaDesti = 'justificantsPDF/';
        $rutaDesti = $carpetaDesti . $nomrArxiu;
        //En cas d'error al moure l'arxiu pdf marcara error
        if (!move_uploaded_file($rutaTemporal, $rutaDesti)) {
            $error_messages['justificant'] = "Error al guardar el pdf." . "<br>";
        } else {
            $justificant['tmp_name'] = $rutaDesti;
        }
        // Validar que no estigui buit el camp certificacions
        if (empty($certificacions)) {
            $error_messages['certificacions'] = "S'ha de marcar mínim una certificació." . "<br>";
        } else {
            // Verificar que los valores de certificación siguin vàlids
            //Faig un bucle i a la que trobo una certificació no valida ho mostro
            foreach ($certificacions as $certificacio) {
                if (!in_array($certificacio, $opcions_certificacions_valides)) {
                    $error_messages['certificacions'] = "Valor de certificació no vàlid." . "<br>";
                    break;
                }
            }
        }
        //Valido que sigui un correu electronic i que no estigui buit
        if (empty($correu) || !filter_var($correu, FILTER_VALIDATE_EMAIL)) {
            $error_messages['correu'] = "Correu electrònic no vàlid." . "<br>";
        }
        // Comprovo si no hi ha missatges d'error
        if (empty(array_filter($error_messages))) {
            // Si no hi ha errors crido al model per guardar les dades i envio el correu
            $model = new Model();
            $resultat = $model->guardarFormulari($nom, $cognoms, $correu, $curs, $certificacions, $justificant);
            if (enviarCorreu($nom, $cognoms, $correu, $curs, $certificacions, $justificant)) {
                // En cas de que tot hagi anat bé s'envia per GET la confirmació del correu enviat
                header('Location: ../?correuEnviat=1');
            };
        }else{
            // En cas d'errors, codifica els missatges d'error i redirigeix amb aquesta informació per get
            $error_messages_encoded = urlencode(json_encode($error_messages));
            header("Location: ../?errors=$error_messages_encoded");
        }

    }else{
        // En cas de problemas amb el captcha, codifica els missatges d'error i redirigeix amb aquesta informació per get
        $error_messages['captcha'] = "Captcha no vàlid." . "<br>";
        $error_messages_encoded = urlencode(json_encode($error_messages));
        header("Location: ../?errors=$error_messages_encoded");
    }
}
?>
