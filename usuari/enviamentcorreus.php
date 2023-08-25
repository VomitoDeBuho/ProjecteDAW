<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


function generarLlistaCertificacions($certificacions) {
    $llista = '<ul>';
    foreach ($certificacions as $certificacion) {
        $llista .= '<li>' . htmlspecialchars($certificacion) . '</li>';
    }
    $llista .= '</ul>';
    return $llista;
}
function enviarCorreu($nom, $cognoms, $correu, $curs, $certificacions, $justificant){
    try {
        //Create an instance; passing `true` enables exceptions
        $mailUsuari = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mailUsuari->isSMTP();                                            //Send using SMTP
        $mailUsuari->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mailUsuari->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mailUsuari->Username   = 'a.blazquez@sapalomera.cat';                     //SMTP username
        $mailUsuari->Password   = 'oDIOALOSNEGROS1233';                               //SMTP password
        $mailUsuari->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mailUsuari->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mailUsuari->setFrom('a.blazquez@sapalomera.cat', 'Certificacions MOS');
        $mailUsuari->addAddress($correu, $nom." ".$cognoms);     //Add a recipient
        //$mail->addAddress('a.blazquez@sapalomera.cat');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        $mailUsuari->addAttachment($justificant['tmp_name'], $justificant['name']);         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mailUsuari->isHTML(true);                                  //Set email format to HTML
        $mailUsuari->CharSet = 'UTF-8';
        $mailUsuari->Subject = 'Petició inscripció al exàmen MOS';
        $mailUsuari->Body    = 'Hola, '.$nom.' '.$cognoms.'!'.' del curs: '.$curs.'<br>'."La teva petició per l'exàmen MOS al curs/os:".'<br>'.generarLlistaCertificacions($certificacions).'Ha estat enviada!'."<br>".'<b>'."Quan la teva petició sigui aprobada i validada per l'administrador, rebràs un correu amb la data establerta i la confirmació!".'</b>';
        $mailUsuari->send();
        $mailUsuari->smtpClose();
        //Admin
        $mailAdmin = new PHPMailer(true);
        $mailAdmin->isSMTP();                                            //Send using SMTP
        $mailAdmin->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mailAdmin->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mailAdmin->Username   = 'a.blazquez@sapalomera.cat';                     //SMTP username
        $mailAdmin->Password   = 'oDIOALOSNEGROS1233';                               //SMTP password
        $mailAdmin->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mailAdmin->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        //Recipients
        $mailAdmin->setFrom('a.blazquez@sapalomera.cat', 'Certificacions MOS');
        $mailAdmin->addAddress('a.blazquez@sapalomera.cat', 'Certificacions MOS');     //Add a recipient
        $mailAdmin->addAttachment($justificant['tmp_name'], $justificant['name']);
        //$mail->addAddress('a.blazquez@sapalomera.cat');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Content
        $mailAdmin->isHTML(true);                                  //Set email format to HTML
        $mailAdmin->CharSet = 'UTF-8';
        $mailAdmin->Subject = 'Alumne inscrit '.$nom.' '.$cognoms.' del curs: '.$curs ;
        $mailAdmin->Body    = "L'alumne, ".$nom.' '.$cognoms.' del curs: '.$curs.'<br>'."Ha enviat una petició per l'exàmen MOS al curs/os:".'<br>'.generarLlistaCertificacions($certificacions);
        $mailAdmin->send();
        $mailAdmin->smtpClose();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mailAdmin->ErrorInfo}";
        echo "Message could not be sent. Mailer Error: {$mailUsuari->ErrorInfo}";
    }
}