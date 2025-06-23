<?php
session_start();

// Charger PHPMailer via Composer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$randomNumber = "1111"; 
$_SESSION["Code"] = $randomNumber;




    $email = "livesimo683@gmail.com";
    $nomCompte = "samadi";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Adresse email invalide.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = '6fd747003@smtp-brevo.com';  
        $mail->Password = 'vrDJtMXRnCzfdqAN';         
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur et destinataire
        $mail->setFrom('6fd747003@smtp-brevo.com', 'TouraMaroc');
        $mail->addAddress($email, $nomCompte);

        // Contenu du mail
        $mail->isHTML(true);
        $mail->Subject = 'Vérification de la création de votre compte';
        $mail->Body = "
            <p>Bonjour <strong>$nomCompte</strong>,</p>
            <p>Merci pour la création de votre compte chez <strong>TouraMaroc</strong>.</p>
            <p>Voici votre code de vérification :</p>
            <h2 style='color:blue;'>$randomNumber</h2>
            <p>Veuillez entrer ce code pour activer votre compte.</p>
            <br>
            <p>Cordialement,<br>L'équipe TouraMaroc</p>
        ";
        $mail->AltBody = "Bonjour $nomCompte, votre code de vérification est : $randomNumber";

        $mail->send();
        echo "✅ Email envoyé avec succès à $email !";
        // $message= "✅ Email envoyé avec succès à $email !";
        // header('location:createAccountP3h.php?message='. urlencode($message));

    } catch (Exception $e) {
        echo "❌ Échec de l'envoi de l'email. Erreur : {$mail->ErrorInfo}";
        // $message= "❌ Échec de l'envoi de l'email. Erreur : {$mail->ErrorInfo}";
        // header('location:createAccountP3h.php?message='. urlencode($message));

    }
// }
?>
