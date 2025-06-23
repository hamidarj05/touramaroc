<?php
require_once '../../../db/connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $villeName = $_POST['villeName'];
    $villeDescription = $_POST['villeDescription'];
    $coordonnees = $_POST['coordonnees'];
    $images = $_FILES['Images'];
    $imagesUrls = [];
    for ($i = 0; $i < count($images['name']); $i++) {
        if (!empty($images['tmp_name'][$i])) {
            $tmpName = $images['tmp_name'][$i];
            $fileName = $images['name'][$i];
            move_uploaded_file($tmpName, 'uploads/' . $fileName);
            $imagesUrls[] = $fileName;
        }
    }
    if (isset($_GET["EditVille"])) {
        $idEditVille = $_GET['idEditVille'];
        $stmt = $conn->prepare("UPDATE villes set nom = :name, ville_description = :description, coordonnees = :coordonnees
                                                            WHERE ville_id = :id");
        echo $idEditVille;
        $stmt->execute([
            ':name' => $villeName,
            ':description' => $villeDescription,
            ':coordonnees' => $coordonnees,
            ':id' => $idEditVille
        ]); 

        foreach ($imagesUrls as $imageUrl) { 
            $stmt = $conn->prepare("DELETE from images_ville  WHERE ville_id = :id");
            $stmt->execute([   
                ':id' => $idEditVille
            ]);
            
            $stmt = $conn->prepare("INSERT INTO images_ville (ville_id, urlSrc, altText)
                                                     VALUES (:ville_id, :urlSrc , :altText)");
            $stmt->execute([ 
                ':ville_id' => $idEditVille,
                ':urlSrc' => $imageUrl,
                ':altText' => $villeName,  
            ]);
        }
        header("Location:../../../frontend/admin/dashboard.php?page=villes&success=Ville Mofifier avec succès");
        exit();
    } else { 
        $stmt = $conn->prepare("INSERT INTO villes (nom, ville_description, coordonnees) 
                                            VALUES (:name, :description, :coordonnees)");
        $stmt->execute([
            ':name' => $villeName,
            ':description' => $villeDescription,
            ':coordonnees' => $coordonnees
        ]);
        $villeId = $conn->lastInsertId();
        var_dump($imagesUrls);
        echo "<br>";
        var_dump($villeId);

        foreach ($imagesUrls as $imageUrl) {
            echo "<br>";
            print_r([
                ':ville_id' => $villeId,
                ':image_url' => $imageUrl,
                ':altText' => $villeName
            ]);
            $stmt = $conn->prepare("INSERT INTO images_ville (ville_id, urlSrc, altText)
                                                     VALUES (:ville_id, :urlSrc , :altText)");
            $stmt->execute([
                ':ville_id' => $villeId,
                ':urlSrc' => $imageUrl,
                ':altText' => $villeName
            ]);
        }
        header("Location:../../../frontend/admin/dashboard.php?success=Ville ajoutée avec succès");
        exit();
    }
}
