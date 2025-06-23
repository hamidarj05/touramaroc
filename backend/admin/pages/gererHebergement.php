<?php
include '../../../db/connectDB.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hebergementName = $_POST['hebergementName'];
    $hebergementCity = $_POST['hebergementCity'];
    $hebergementType = $_POST['hebergementType'];
    $hebergementPrice = $_POST['hebergementPrice'];
    $hebergementRating = $_POST['hebergementRating'];
    $hebergementDescription = $_POST['hebergementDescription'];
    $hebergementImages = $_FILES['hebergementImages'];
    $imagesUrls = [];
    for ($i = 0; $i < count($hebergementImages['name']); $i++) {
        if (!empty($hebergementImages['tmp_name'][$i])) {
            $tmpName = $hebergementImages['tmp_name'][$i];
            $fileName = $hebergementImages['name'][$i];
            move_uploaded_file($tmpName, 'uploads/' . $fileName);
            $imagesUrls[] = $fileName;
        }
    }
    if (isset($_GET["EditHebergement"])) {
        $type = $_GET["type"];
        $id = $_GET["idEditHebergement"];
 
        if ($type == "hotel") {
            $stmt = $conn->prepare("UPDATE hotel SET nom = :name, prix = :prix, etoiles = :etoiles, ville_id = :ville_id WHERE id = :id");
            $stmt->execute([
                ':name' => $hebergementName,
                ':prix' => $hebergementPrice,
                ':etoiles' => $hebergementRating,
                ':ville_id' => $hebergementCity,
                ':id' => $id
            ]);
        } elseif ($type == "riad") {
            $stmt = $conn->prepare("UPDATE riads SET nom = :name, prix = :prix, ville_id = :ville_id WHERE id = :id");
            $stmt->execute([
                ':name' => $hebergementName,
                ':prix' => $hebergementPrice,
                ':ville_id' => $hebergementCity,
                ':id' => $id
            ]);
        } elseif ($type == "maison") {
            $stmt = $conn->prepare("UPDATE maison SET nom = :name, prix = :prix, ville_id = :ville_id WHERE id = :id");
            $stmt->execute([
                ':name' => $hebergementName,
                ':prix' => $hebergementPrice,
                ':ville_id' => $hebergementCity,
                ':id' => $id
            ]);
        }
 
        $stmt = $conn->prepare("SELECT id FROM hebergements WHERE hebergement_id = :hid AND type = :type");
        $stmt->execute([
            ':hid' => $id,
            ':type' => $type
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hebergementID = $row['id'];
 
        $stmt = $conn->prepare("UPDATE detail_hebergements SET detail = :detail WHERE id_hebergement = :id");
        $stmt->execute([
            ':detail' => $hebergementDescription,
            ':id' => $hebergementID
        ]);

        $stmt = $conn->prepare("DELETE FROM hebergement_images WHERE hebergement_id = :id");
        $stmt->execute([':id' => $hebergementID]);

        $stmt = $conn->prepare("INSERT INTO hebergement_images (hebergement_id, urlSrc, alt) VALUES (:id, :url, :alt)");
        foreach ($imagesUrls as $imageUrl) {
            $stmt->execute([
                ':id' => $hebergementID,
                ':url' => $imageUrl,
                ':alt' => $hebergementName
            ]);
        }


        header("Location:../../../frontend/admin/dashboard.php?page=hebergements&success=Hébergement modifié avec succès");
        exit();
    } else {
        if ($hebergementType == "hotel") {
            $stmt = $conn->prepare("INSERT INTO hotel (nom, prix, etoiles, ville_id) 
                                                VALUES (:name, :prix, :etoiles, :ville_id)");
            $stmt->execute([
                ':name' => $hebergementName,
                ':prix' => $hebergementPrice,
                ':etoiles' => $hebergementRating,
                ':ville_id' => $hebergementCity
            ]);
            $hotelID = $conn->lastInsertId();
            $stmt = $conn->prepare("INSERT INTO hebergements(hebergement_id,type) 
                                                VALUES (:hebergement_id, :type)");
            $stmt->execute([
                ':hebergement_id' => $hotelID,
                ':type' => 'hotel'
            ]);
            $hebergementID = $conn->lastInsertId();
            $stmt = $conn->prepare("INSERT INTO  hebergement_images(hebergement_id, urlSrc, alt) 
                                                VALUES (:hebergement_id, :urlSrc, :altText)");
            foreach ($imagesUrls as $imageUrl) {
                $stmt->execute([
                    ':hebergement_id' => $hebergementID,
                    ':urlSrc' => $imageUrl,
                    ':altText' => $hebergementName
                ]);
            }
            $stmt = $conn->prepare("INSERT INTO detail_hebergements(id_hebergement, detail) 
                                                VALUES (:id_hebergement, :detail)");
            $stmt->execute([
                ':id_hebergement' => $hebergementID,
                ':detail' => $hebergementDescription
            ]);
        } elseif ($hebergementType == "riad") {
            $stmt = $conn->prepare("INSERT INTO riads (nom, prix, ville_id) 
                                                VALUES (:name, :prix, :ville_id)");
            $stmt->execute([
                ':name' => $hebergementName,
                ':prix' => $hebergementPrice,
                ':ville_id' => $hebergementCity
            ]);
            $riadID = $conn->lastInsertId();
            $stmt = $conn->prepare("INSERT INTO hebergements(hebergement_id,type) 
                                                VALUES (:hebergement_id, :type)");
            $stmt->execute([
                ':hebergement_id' => $riadID,
                ':type' => 'riad'
            ]);
            $hebergementID = $conn->lastInsertId();
            $stmt = $conn->prepare("INSERT INTO  hebergement_images(hebergement_id, urlSrc, alt) 
                                                VALUES (:hebergement_id, :urlSrc, :altText)");
            foreach ($imagesUrls as $imageUrl) {
                $stmt->execute([
                    ':hebergement_id' => $hebergementID,
                    ':urlSrc' => $imageUrl,
                    ':altText' => $hebergementName
                ]);
            } 
            $stmt = $conn->prepare("INSERT INTO detail_hebergements(id_hebergement, detail) 
                                                VALUES (:id_hebergement, :detail)");
            $stmt->execute([
                ':id_hebergement' => $hebergementID,
                ':detail' => $hebergementDescription
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO maison (nom, prix, ville_id) 
                                                VALUES (:name, :prix, :ville_id)");
            $stmt->execute([
                ':name' => $hebergementName,
                ':prix' => $hebergementPrice,
                ':ville_id' => $hebergementCity
            ]);
            $maisonId = $conn->lastInsertId();
            $stmt = $conn->prepare("INSERT INTO hebergements(hebergement_id,type) 
                                                VALUES (:hebergement_id, :type)");
            $stmt->execute([
                ':hebergement_id' => $maisonId,
                ':type' => 'maison'
            ]);
            $hebergementID = $conn->lastInsertId();
            $stmt = $conn->prepare("INSERT INTO  hebergement_images(hebergement_id, urlSrc, alt) 
                                                VALUES (:hebergement_id, :urlSrc, :altText)");
            foreach ($imagesUrls as $imageUrl) {
                $stmt->execute([
                    ':hebergement_id' => $hebergementID,
                    ':urlSrc' => $imageUrl,
                    ':altText' => $hebergementName
                ]);
            } 
            echo $hebergementID;
            $stmt = $conn->prepare("INSERT INTO detail_hebergements(id_hebergement, detail) 
                                                VALUES (:id_hebergement, :detail)");
            $stmt->execute([
                ':id_hebergement' => $hebergementID,
                ':detail' => $hebergementDescription
            ]);
        }
        header("Location:../../../frontend/admin/dashboard.php?success=Hébergement ajouté avec succès");
        exit();
    }
}
