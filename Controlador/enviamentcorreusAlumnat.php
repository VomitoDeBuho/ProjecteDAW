<?php
// Importo les classes de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Incloeixo els fitxers necessaris per a PHPMailer
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Funció per enviar el correu electrònic
function enviarCorreu($nom, $cognoms, $correu, $curs, $usuari, $contrasenya, $codiPracticeTest, $diaiHoraExamen){
    try {
        setlocale(LC_TIME, 'ca_ES.utf8'); // Estableixo la configuració regional en català i UTF8
        $mesosEnCatala = array(
            // Array per traduir els noms dels mesos a català
            'January'   => 'gener',
            'February'  => 'febrer',
            'March'     => 'març',
            'April'     => 'abril',
            'May'       => 'maig',
            'June'      => 'juny',
            'July'      => 'juliol',
            'August'    => 'agost',
            'September' => 'setembre',
            'October'   => 'octubre',
            'November'  => 'novembre',
            'December'  => 'desembre'
        );

        // Formata la data i hora de l'examen en català

        $dataFormatejada = strftime('%d de %B de %Y, a les %H:%M', strtotime($diaiHoraExamen));
        $dataFormatejada = str_replace(array_keys($mesosEnCatala), array_values($mesosEnCatala), $dataFormatejada);
        // Crea un objecte de PHPMailer
        $mail = new PHPMailer(true);
        // Configuració del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'a.blazquez@sapalomera.cat';
        $mail->Password   = 'xxxxx';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remitent i destinatari del correu
        $mail->setFrom('a.blazquez@sapalomera.cat', 'Certificacions MOS');
        $mail->addAddress($correu, $nom." ".$cognoms);     //Add a recipient

        //Arxiu on Esta el manual del PDF
        $mail->addAttachment('ManualPDF/ManualdeusodelPracticeTest-Conentorno.pdf', 'Manual de uso del Practice Test - Con entorno.pdf');         //Add attachments

        //Contingut del correu del missatge, aqui icloeixo les credencials que envia l'administrador al index.php
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Petició inscripció al exàmen MOS';
        $mail->Body    = 'Hola, '.$nom.' '.$cognoms.'!'.' del curs: '.$curs.'<br>'."<b>La teva petició per l'exàmen MOS Ha estat aprobada!</b>"."<br>".'<b>Pel dia i hora: </b>'.$dataFormatejada.'<br><b>Adjunto les instruccións per poder accedir!</b>'.'<div>
<p class="MsoNormal" style="margin:0cm 0cm 8pt;line-height:15.5467px;font-size:11pt;font-family:Calibri,sans-serif"><br></p><p class="MsoNormal" style="margin:0cm 0cm 8pt;text-align:justify;line-height:15.5467px;font-size:11pt;font-family:Calibri,sans-serif">A
 continuación, te indicamos los pasos a seguir para acceder y utilizar 
correctamente el Practice Test de MOS:</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif"><b>&nbsp;</b></p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif"><b>1)<span style="font-variant-numeric:normal;font-variant-east-asian:normal;font-weight:normal;font-stretch:normal;font-size:7pt;line-height:normal;font-family:&quot;Times New Roman&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></b><b>Regristro en Gmetrix</b></p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">Crea una cuenta en Gmetrix desde este&nbsp;<a href="https://www.gmetrix.net/Public/Register.aspx" style="color:blue" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.gmetrix.net/Public/Register.aspx&amp;source=gmail&amp;ust=1692132602860000&amp;usg=AOvVaw2y8LIb7yrHWadFaOpHIcGZ">enlace de registro</a>.</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif"><b>2)<span style="font-variant-numeric:normal;font-variant-east-asian:normal;font-weight:normal;font-stretch:normal;font-size:7pt;line-height:normal;font-family:&quot;Times New Roman&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></b><b>Acceso a nuestro entorno virtual</b></p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif"><b>&nbsp;</b></p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">Utiliza
 las siguientes credenciales para acceder a nuestro servidor remoto y 
poder realizar el Practice Test sin necesidad de descargar ningún 
software.</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">______________________________<wbr>____________________</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="margin:0cm 0cm 0.0001pt 36pt;text-align:justify;line-height:15.5467px;font-size:11pt;font-family:Calibri,sans-serif"><a href="https://office.pue.es/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://office.pue.es/&amp;source=gmail&amp;ust=1692132602860000&amp;usg=AOvVaw14AQCrdikJfIw6wwKVDamI">Enlace de acceso</a></p><p style="margin:0cm 0cm 0.0001pt 36pt;text-align:justify;line-height:15.5467px;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="margin:0cm 0cm 0.0001pt 36pt;text-align:justify;line-height:15.5467px;font-size:11pt;font-family:Calibri,sans-serif"><b>Usuario:</b>&nbsp;<b>'.$usuari.'</b></p><p style="margin:0cm 0cm 0.0001pt 36pt;text-align:justify;line-height:15.5467px;font-size:11pt;font-family:Calibri,sans-serif"><b>Contraseña:</b>&nbsp;<b>'.$contrasenya.'</b></p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">______________________________<wbr>____________________</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif"><b>3)<span style="font-variant-numeric:normal;font-variant-east-asian:normal;font-weight:normal;font-stretch:normal;font-size:7pt;line-height:normal;font-family:&quot;Times New Roman&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></b><b>Inicio de sesión en Gmetrix</b></p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">Desde
 nuestro entorno remoto, haz click en el icono de Gmetrix e inicia 
sesión con la cuenta que has creado en Paso 1. Desde el panel izquierdo 
clicka en&nbsp;<i>Activar código (Redeem)&nbsp;</i>e introduce el siguiente código:</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">______________________________<wbr>____________________</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif"><b>Código</b>: <b>'.$codiPracticeTest.'</b></p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">______________________________<wbr>____________________</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">Te recomendamos que leas detenidamente el&nbsp;<a href="https://drive.google.com/file/d/1UtzrZdlun4orP0QtRRrCYXbtuvTlDpvt/view?usp=sharing" style="color:blue" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://drive.google.com/file/d/1UtzrZdlun4orP0QtRRrCYXbtuvTlDpvt/view?usp%3Dsharing&amp;source=gmail&amp;ust=1692132602860000&amp;usg=AOvVaw16yurPhAISj_eRHoIlbHrJ">manual de utilización</a>&nbsp;antes de iniciar el Practice Test.</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">Ten en cuenta que la modalidad&nbsp;<i>TRAINING</i>&nbsp;permite realizar el Practice Test sin límite de tiempo, mientras que la modalidad&nbsp;<i>TESTING</i>&nbsp;activa una cuenta atrás, con el mismo tiempo que el examen oficial.</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">Una
 vez finalizado el Practice Test el programa nos emitirá un informe de 
resultados y dará por concluido el simulacro de examen.</p><p style="text-align:justify;line-height:15.5467px;margin:0cm 0cm 0.0001pt 36pt;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><p style="margin:0cm 0cm 0.0001pt;text-align:justify;line-height:15.5467px;font-size:11pt;font-family:Calibri,sans-serif"><b>IMPORTANTE</b>:
 Para realizar el Practice Test de MOS es necesario
 disponer del software del fabricante instalado en tu equipo. Para más 
información, consulta por favor el siguiente&nbsp;<a href="https://support.gmetrix.net/download" style="color:blue" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://support.gmetrix.net/download&amp;source=gmail&amp;ust=1692132602860000&amp;usg=AOvVaw3MHzgj4FIw7CW2AJtmQscn">enlace</a>.</p><p style="margin:0cm 0cm 8pt;text-align:justify;line-height:15.5467px;font-size:11pt;font-family:Calibri,sans-serif">&nbsp;</p><div>

</div></div>';
        $mail->send();
        //Important sempre tancar la instancia
        $mail->smtpClose();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}