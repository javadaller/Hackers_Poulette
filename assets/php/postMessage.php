<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '/home/arnaudf/www/Hackers_Poulettes/assets/php/mailer/src/Exception.php';
require '/home/arnaudf/www/Hackers_Poulettes/assets/php/mailer/src/PHPMailer.php';
require '/home/arnaudf/www/Hackers_Poulettes/assets/php/mailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Paramètres du serveur
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'ssl0.ovh.net';
    $mail->SMTPAuth = true;
    $mail->Username = 'becode@arnaudweb.be';
    $mail->Password = '';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // Destinataires
    $mail->setFrom('becode@arnaudweb.be', 'Becode');
    $mail->addAddress('arnaudvanacker@yahoo.fr', 'Arnaud');

    // Contenu
    $mail->isHTML(true);
    $mail->Subject = 'Voici le sujet';
    $mail->Body    = 'Ceci est le corps du message en HTML <b>en gras !</b>';
    $mail->AltBody = 'Ceci est le corps en texte brut pour les clients de messagerie non-HTML';

    $mail->send();
    echo 'Le message a été envoyé';
} catch (Exception $e) {
    echo "Le message n'a pas pu être envoyé. Erreur du Mailer : {$mail->ErrorInfo}";
}
