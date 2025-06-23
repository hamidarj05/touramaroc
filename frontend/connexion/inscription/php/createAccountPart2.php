<?php
session_start();
require_once 'User.php'; // Assurez-vous que ce fichier contient la configuration de la base de données
// Vérification de la méthode de la requête
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = htmlspecialchars(trim($_POST['password'] ?? ''));
    $confirmPassword = htmlspecialchars(trim($_POST['confirmPassword'] ?? ''));

    try{
        
        $user = new User("nom", "prenom", "0123456789", "maroc", "tangier", "beni makkada", $email, $password, $confirmPassword);

        if ($user->valideEmailAndPassword() !== 'valide'){
            throw new Exception($user->valideEmailAndPassword());
        }
            $_SESSION['email']           = trim($_POST['email'] ?? '');
            $_SESSION['password']        = trim($_POST['password'] ?? '');
            $_SESSION['confirmPassword'] = trim($_POST['confirmPassword'] ?? '');
        // Redirection vers la page d'inscription avec un message de succès
        header('location:../sendCode.php');
        exit();

    }catch(Exception $e){
        // Redirection vers la page d'inscription avec un message d'erreur
        header('Location: ../insertEmail.php?message=' . urlencode($e->getMessage()));
        exit();
    }
    







}

?>