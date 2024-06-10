<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Activer les erreurs de PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '/home/arnaudf/www/Hackers_Poulettes/assets/php/mailer/src/Exception.php';
require '/home/arnaudf/www/Hackers_Poulettes/assets/php/mailer/src/PHPMailer.php';
require '/home/arnaudf/www/Hackers_Poulettes/assets/php/mailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Paramètres du serveur
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Activer la sortie de débogage verbose
    $mail->isSMTP();                        // Envoyer via SMTP
    $mail->Host = 'ssl0.ovh.net';         // Définir le serveur SMTP pour envoyer via Gmail
    $mail->SMTPAuth = true;                 // Activer l'authentification SMTP
    $mail->Username = 'becode@arnaudweb.be'; // Votre nom d'utilisateur Gmail
    $mail->Password = 'becode6220';   // Votre mot de passe Gmail ou mot de passe d'application
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Activer le chiffrement TLS
    $mail->Port = 465;                      // Port TCP à utiliser

    // Destinataires
    $mail->setFrom('becode@arnaudweb.be', 'Becode'); // Adresse de l'expéditeur
    $mail->addAddress('arnaudvanacker@yahoo.fr', 'Arnaud'); // Ajouter un destinataire

    // Contenu
    $mail->isHTML(true);                    // Définir le format de l'e-mail à HTML
    $mail->Subject = 'Voici le sujet';
    $mail->Body    = 'Ceci est le corps du message en HTML <b>en gras !</b>';
    $mail->AltBody = 'Ceci est le corps en texte brut pour les clients de messagerie non-HTML';

    $mail->send();
    echo 'Le message a été envoyé';
} catch (Exception $e) {
    // Enregistrez l'erreur dans un fichier de logs
    error_log("Erreur lors de l'envoi du message : " . $mail->ErrorInfo);
    echo "Le message n'a pas pu être envoyé. Erreur du Mailer : {$mail->ErrorInfo}";
}
?>
