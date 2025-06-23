<?php
session_start();
require_once "connexionBD.php";
require_once "User.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    try {
        // if (strlen($password) < 6) {
        //     throw new Exception("Le mot de passe est trop court (minimum 6 caractères).");
        // }

        // $regex = "/^[^@\s]+@[^@\s]+\.[^@\s]+$/";
        // if (!preg_match($regex, $email)) {
        //     throw new Exception("L'email est invalide");
        // }

        $user = new User("nom", "prenom", "0123456789", "maroc", "tangier", "beni makkada", $email, $password, 'password123');
        if ($user->valideEmail() !== true) {
            throw new Exception($result);
        }
        if ($user->validePassword() !== true) {
            throw new Exception($user->validePassword());
        }
        $pdo = connexion("localhost", "touramaroc", "root", "simoo@365");

        if (!$pdo) {
            throw new Exception("Un problème s’est produit lors de la connexion à la base de données");
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$user) {
            throw new Exception("Cet email n'a pas de compte");
        }

        // ✅ Vérifie le mot de passe haché
        if (!password_verify($password, $user->mot_de_passe)) {
            throw new Exception("Le mot de passe ou l'email est incorrect");
        }

        $_SESSION["user_id"] = $user->id_user;
        $_SESSION["nom"] = $user->nom;
        $_SESSION["prenom"] = $user->prenom;
        $_SESSION["pays"] = $user->pays;
        $_SESSION["ville"] = $user->ville;
        $_SESSION["adresse"] = $user->adresse;
        $_SESSION["user_role"] = $user->user_role;
        $_SESSION["date_creation"] = $user->datecreation;

        header("Location: dashboard.php");
        exit();

    } catch (Exception $e) {
        header("Location: ../../index.php?message=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
