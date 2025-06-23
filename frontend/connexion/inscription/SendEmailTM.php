<?php
session_start();

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "php/connexionBD.php";
require_once "php/User.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST["email"] ?? '');

    try {
        // $regex = "/^[^@\s]+@[^@\s]+\.[^@\s]+$/";

        // if (!preg_match($regex, $email)) {
        //     throw new Exception("L'email est invalide");
        // }

        $user = new User("nom", "prenom", "0123456789", "maroc", "tangier", "beni makkada", $email, "password123", "password123");
        $result = $user->valideEmail();

        if ($result !== true) {
            // throw new Exception($result);
            die($result);
        }
        $pdo = connexion("localhost", "touramaroc", "root", "");
        if (!$pdo) {
            throw new Exception("Un problème s’est produit lors de la connexion à la base de données");
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_OBJ);

        if ($admin) {
            throw new Exception("cet email existe dans la base de données");
        }

        $_SESSION["email"] = $email;
        $randomNumber = rand(1000, 9999);

        setcookie("Code", $randomNumber, time() + 60, "/");






        $nomCompte = $_SESSION['nom'] ?? 'Utilisateur';


        // Vérification basique de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("❌ Adresse email invalide."); 
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
            $mail->CharSet = 'UTF-8';
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
            // echo "✅ Email envoyé avec succès à $email !";
            $message = "✅ Email envoyé avec succès à $email !";
            header('location:sendCode.php?message=' . urlencode($message));
        } catch (Exception $e) {
            // echo "❌ Échec de l'envoi de l'email. Erreur : {$mail->ErrorInfo}";
            $message = "❌ Échec de l'envoi de l'email. Erreur : {$mail->ErrorInfo}";
            header('location:sendCode.php?message=' . urlencode($message));
        }
    } catch (Exception $e) {
        header('location:sendCode.php?message=' . urlencode($e->getMessage()));
    }
}
