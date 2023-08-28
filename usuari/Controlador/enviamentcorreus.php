<?php
// Importo les classes de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Incloeixo els fitxers necessaris per a PHPMailer
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

//Funció que utlitzo per passar d'una llista de certificacions a una string d'una llista per html desordenada
function generarLlistaCertificacions($certificacions) {
    $llista = '<ul>';
    foreach ($certificacions as $certificacion) {
        $llista .= '<li>' . htmlspecialchars($certificacion) . '</li>';
    }
    $llista .= '</ul>';
    return $llista;
}
// Funció per enviar el correu electrònic
//Aquesta funció envia 2 correus electronics
//1 per l'usuari amb la informació que ha emplenat
//2 per l'administrador notificant quin usuari ha demanat una petició
function enviarCorreu($nom, $cognoms, $correu, $curs, $certificacions, $justificant){
    try {
        // Crea un objecte de PHPMailer PER EL MAIL DEL USUARI
        $mailUsuari = new PHPMailer(true);
        // Configuració del servidor SMTP
        $mailUsuari->isSMTP();
        $mailUsuari->Host       = 'smtp.gmail.com';
        $mailUsuari->SMTPAuth   = true;
        $mailUsuari->Username   = 'a.blazquez@sapalomera.cat';
        $mailUsuari->Password   = 'xxxxx';
        $mailUsuari->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailUsuari->Port       = 587;

        // Remitent i destinatari del correu
        $mailUsuari->setFrom('a.blazquez@sapalomera.cat', 'Certificacions MOS');
        $mailUsuari->addAddress($correu, $nom." ".$cognoms);     //Add a recipient

        //Arxiu on per adjuntar el pdf del usuari
        $mailUsuari->addAttachment($justificant['tmp_name'], $justificant['name']);


        //Contingut del mail
        $mailUsuari->isHTML(true);
        $mailUsuari->CharSet = 'UTF-8';
        $mailUsuari->Subject = 'Petició inscripció al exàmen MOS';
        $mailUsuari->Body    = 'Hola, '.$nom.' '.$cognoms.'!'.' del curs: '.$curs.'<br>'."La teva petició per l'exàmen MOS al curs/os:".'<br>'.generarLlistaCertificacions($certificacions).'Ha estat enviada!'."<br>".'<b>'."Quan la teva petició sigui aprobada i validada per l'administrador, rebràs un correu amb la data establerta i la confirmació!".'</b>';
        //Tenco la instancia per poder obrir un altre per l'administrador
        $mailUsuari->send();
        $mailUsuari->smtpClose();
        // Crea un objecte de PHPMailer PER EL MAIL DEL USUARI
        $mailAdmin = new PHPMailer(true);
        $mailAdmin->isSMTP();
        $mailAdmin->Host       = 'smtp.gmail.com';
        $mailAdmin->SMTPAuth   = true;
        $mailAdmin->Username   = 'a.blazquez@sapalomera.cat';
        $mailAdmin->Password   = 'xxxxxx';
        $mailAdmin->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailAdmin->Port       = 587;

        // Remitent i destinatari del correu, aqui m'envio el correu a mi mateix per rebre la notificacio
        $mailAdmin->setFrom('a.blazquez@sapalomera.cat', 'Certificacions MOS');
        $mailAdmin->addAddress('a.blazquez@sapalomera.cat', 'Certificacions MOS');
        //M'adjunto el justificant
        $mailAdmin->addAttachment($justificant['tmp_name'], $justificant['name']);

        $mailAdmin->isHTML(true);
        $mailAdmin->CharSet = 'UTF-8';
        $mailAdmin->Subject = 'Alumne inscrit '.$nom.' '.$cognoms.' del curs: '.$curs ;
        $mailAdmin->Body    = "L'alumne, ".$nom.' '.$cognoms.' del curs: '.$curs.'<br>'."Ha enviat una petició per l'exàmen MOS al curs/os:".'<br>'.generarLlistaCertificacions($certificacions);
        $mailAdmin->send();
        $mailAdmin->smtpClose();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mailAdmin->ErrorInfo}";
    }
}