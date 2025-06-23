<?php

require_once 'User.php'; // Assurez-vous que ce fichier contient la configuration de la base de données
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
    $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
    $pays = htmlspecialchars(trim($_POST['pays'] ?? ''));
    $ville = htmlspecialchars(trim($_POST['ville'] ?? ''));
    $adresse = htmlspecialchars(trim($_POST['adresse'] ?? ''));


 $user = new User($nom, $prenom, $telephone, $pays, $ville, $adresse,  "example@gmail.com", "password123", "password123");   
    try {
        // Validation des données
        if ($user->validateInfo() !== 'valide') {
            throw new Exception($user->validateInfo());
        }

        $_SESSION['nom']      = trim($_POST['nom'] ?? '');
        $_SESSION['prenom']   = trim($_POST['prenom'] ?? '');
        $_SESSION['telephone']= trim($_POST['telephone'] ?? '');
        $_SESSION['pays']     = trim($_POST['pays'] ?? '');
        $_SESSION['ville']    = trim($_POST['ville'] ?? '');
        $_SESSION['adresse']  = trim($_POST['adresse'] ?? '');
            header('Location: ../insertEmail.php');
    exit();

    } catch (Exception $e) {
        
        header('Location: ../index.php?message=' . urlencode($e->getMessage()));
        exit();
    }





}
?>
