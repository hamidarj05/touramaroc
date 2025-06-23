<?php

require_once '../../../db/connectDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationId = isset($_POST['reservationId']) ? $_POST['reservationId'] : null;
    $montant = isset($_POST['montant']) ?  $_POST['montant'] : null;
    $methode = isset($_POST['methode']) ?  $_POST['methode'] : '';
    $statut = isset($_POST['statut']) ?  $_POST['statut']: '';
    $datePaiement = isset($_POST['datePaiement']) ? $_POST['datePaiement'] : '';
    if (isset($_GET['editPaiement'])) {
        $id = $_GET['idEditPaiement'];
        $statut = $_POST['statut'];
        $stmt = $conn->prepare("UPDATE paiements SET statut = :statut WHERE id_paiement = :id");
        $stmt->execute([
            ':statut' => $statut,
            ':id' => $id
        ]);

        header("Location: ../../../frontend/admin/dashboard.php?page=paiments&success=Statut mis à jour");
        exit();
    } 
    else if ($reservationId && $montant && $methode && $statut && $datePaiement) {
        try {
            $stmt = $conn->prepare("
                INSERT INTO paiements (reservation_id, montant, methode, statut, date_paiement)
                VALUES (:reservation_id, :montant, :methode, :statut, :date_paiement)
            ");

            $stmt->execute([
                ':reservation_id' => $reservationId,
                ':montant' => $montant,
                ':methode' => $methode,
                ':statut' => $statut,
                ':date_paiement' => $datePaiement
            ]);
            header("Location: ../../../frontend/admin/dashboard.php?page=paiments&success=Paiment a ete  ajouter");
            exit(); 
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'ajout du paiement : " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Tous les champs sont obligatoires.";
    }
    
} 