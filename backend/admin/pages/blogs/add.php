<?php
session_start();
require_once '../../../../db/connectDB.php';
require_once  '../../../class/Blog.php';  

$blog = new Blog($conn);
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // inputs
    $auteur = htmlspecialchars(trim($_POST['auteur']));
    $titre = htmlspecialchars(trim($_POST['titre']));
    $contenu = htmlspecialchars(trim($_POST['contenu']));
    
    // image upload
    $image = '';
    if (isset($_FILES['image'])) {
        $uploadDir ='../../uploads/blogs/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Validate image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; 
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $_FILES['image']['tmp_name']);
        
        if (!in_array($mimeType, $allowedTypes)) {
            $error = "Only JPG, PNG, and WEBP images are allowed.";
        } elseif ($_FILES['image']['size'] > $maxSize) {
            $error = "Image size must be less than 2MB.";
        } else {
            // generer un nom de fichier unique
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = 'blog_' . bin2hex(random_bytes(8)) . '.' . $extension;
            $targetPath = $uploadDir . $imageName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image = $imageName;
            } else {
                $error = "Failed to upload image.";
            }
        }
    }
    
    // validation
    if (empty($titre) || empty($contenu)) {
        $error = "Title and content are required.";
    }
    
    // creer article/ bolg
    if (!$error) {
        try {
            if ($blog->creerArticle($auteur, $titre, $contenu, $image)) { 
                header('Location:../../../../frontend/admin/dashboard.php?page=blogs&success=blog a etet ajouté');
                exit();
            } else {
                $error = "Failed to create blog post.";
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $error = "Database error.";
        }
    }
}
?> 