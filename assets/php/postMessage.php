<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '/home/arnaudf/www/Hackers_Poulettes/assets/php/mailer/src/Exception.php';
require '/home/arnaudf/www/Hackers_Poulettes/assets/php/mailer/src/PHPMailer.php';
require '/home/arnaudf/www/Hackers_Poulettes/assets/php/mailer/src/SMTP.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

if (empty($data['name']) || empty($data['surname']) || empty($data['email']) || empty($data['subject']) || empty($data['message'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host = 'ssl0.ovh.net';
    $mail->SMTPAuth = true;
    $mail->Username = 'becode@arnaudweb.be';
    $mail->Password = '';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('becode@arnaudweb.be', 'Becode');
    $mail->addAddress(htmlspecialchars($data['email']), htmlspecialchars($data['name']) . ' ' . htmlspecialchars($data['surname']));

    $mail->isHTML(true);
    $mail->Subject = $data['subject'];
    $mail->Body    = '<p><strong>Nom:</strong> ' . htmlspecialchars($data['name']) . ' ' . htmlspecialchars($data['surname']) . '</p>' .
                     '<p><strong>Email:</strong> ' . htmlspecialchars($data['email']) . '</p>' .
                     '<p><strong>Pays:</strong> ' . htmlspecialchars($data['country']) . '</p>' .
                     '<p><strong>Genre:</strong> ' . htmlspecialchars($data['gender']) . '</p>' .
                     '<p><strong>Message:</strong><br>' . nl2br(htmlspecialchars($data['message'])) . '</p>';
    $mail->AltBody = "Nom: {$data['name']} {$data['surname']}\nEmail: {$data['email']}\nPays: {$data['country']}\nGenre: {$data['gender']}\nMessage: {$data['message']}";

    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'Message sent']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "Error : {$mail->ErrorInfo}"]);
}
