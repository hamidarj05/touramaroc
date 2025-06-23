<?php
session_start();
require_once 'User.php'; 

require_once "connexionBD.php";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["ForgotEmail"])) {
    $password = trim($_POST["password"] ?? "");
    $confirmPassword = trim($_POST["confirmPassword"] ?? "");
    $ForgotEmail = $_SESSION["ForgotEmail"];

    try {
        // Validations
        // if (strlen($password) < 6) {
        //     throw new Exception("Le mot de passe est trop court (minimum 6 caractères).");
        // }

        // if ($password !== $confirmPassword) {
        //     throw new Exception("Le mot de passe et sa confirmation ne correspondent pas.");
        // }


        $user = new User("nom", "prenom", "0123456789", "maroc", "tangier", "beni makkada", 'examlpe@gmail.com', $confirmPassword,  $confirmPassword);


        if ($user->validePassword() !== true) {
            throw new Exception($user->validePassword());
        }
        if ($user->valideConfirmPassword() !== true) {
            throw new Exception($user->valideConfirmPassword());
        }
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $pdo = connexion("localhost", "touramaroc", "root", "simoo@365");

        if (!$pdo) {
            throw new Exception("Erreur de connexion à la base de données.");
        }

        $stmt = $pdo->prepare("UPDATE users SET mot_de_passe = :mot_de_passe, confirmPwd = :confirmPwd WHERE email = :email");

        $stmt->bindParam(":mot_de_passe", $hashedPassword);
        $stmt->bindParam(":confirmPwd", $hashedPassword); 
        $stmt->bindParam(":email", $ForgotEmail);

        $stmt->execute();

        

        // Optionnel : supprimer la session d'email de récupération
        unset($_SESSION["ForgotEmail"]);
        // header("Location: ../../index.html");
         $message = urlencode("Votre mot de passe a été réinitialisé avec succès");
        header("Location: ../modifyPassword.php?message=" . $message);
        exit();
    } catch (Exception $e) {
        $message = "Erreur : " . urlencode($e->getMessage());
        header("Location: ../modifyPassword.php?message=" . $message);
    }
}
?>
