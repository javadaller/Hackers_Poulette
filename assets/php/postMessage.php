<?php
header('Content-Type: application/json');

// Activer le rapport des erreurs pour le débogage (à enlever en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Récupérer les données JSON du corps de la requête
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if ($data && isset($data['email'])) {
        // Validation et sanitation des données
        $name = htmlspecialchars($data['name']);
        $surname = htmlspecialchars($data['surname']);
        $gender = htmlspecialchars($data['gender']);
        $email = htmlspecialchars($data['email']);
        $country = htmlspecialchars($data['country']);
        $subject = htmlspecialchars($data['subject']);
        $message = htmlspecialchars($data['message']);

        // Vérification de l'email valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address.');
        }

        // Configuration de l'email
        $to = $email;
        $subjectEmail = 'Confirmation de réception de votre message';
        $headers = "From: no-reply@votre-site.com\r\n";
        $headers .= "Reply-To: no-reply@votre-site.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Contenu de l'email
        $messageEmail = "
        <html>
        <head>
        <title>Confirmation de réception</title>
        </head>
        <body>
        <h2>Bonjour $name,</h2>
        <p>Nous avons bien reçu votre message avec les informations suivantes :</p>
        <ul>
            <li><strong>Prénom :</strong> $name</li>
            <li><strong>Nom :</strong> $surname</li>
            <li><strong>Genre :</strong> $gender</li>
            <li><strong>Email :</strong> $email</li>
            <li><strong>Pays :</strong> $country</li>
            <li><strong>Sujet :</strong> $subject</li>
            <li><strong>Message :</strong> $message</li>
        </ul>
        <p>Nous vous contacterons bientôt.</p>
        <p>Cordialement,<br>L'équipe de votre site</p>
        </body>
        </html>";

        // Envoi de l'email
        $mailSent = mail($to, $subjectEmail, $messageEmail, $headers);

        if ($mailSent) {
            echo json_encode(['status' => 'success', 'message' => 'Data received and email sent']);
        } else {
            throw new Exception('Email not sent.');
        }
    } else {
        throw new Exception('No data received or email missing.');
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
