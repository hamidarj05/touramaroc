<?php
// Initialize session and check authentication
session_start();
require_once '../../../../db/connectDB.php';
require_once  '../../../class/Blog.php';

// if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
//     header('Location: /includes/login.php');
//     exit();
// }

$blog = new Blog($conn);
$error = null;

 

$id = (int)$_GET['id'];
$blogPost = $blog->obtenirArticleParId($id);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auteur = htmlspecialchars(trim($_POST['auteur']));
    $titre = htmlspecialchars(trim($_POST['titre']));
    $contenu = htmlspecialchars(trim($_POST['contenu']));
    
    $image = $blogPost['image'];
    
    // image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../../uploads/blogs/';
        
        // valider la nouvelle image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $_FILES['image']['tmp_name']);
        
        if (!in_array($mimeType, $allowedTypes)) {
            $error = "Only JPG, PNG, and WEBP images are allowed.";
        } elseif ($_FILES['image']['size'] > $maxSize) {
            $error = "Image size must be less than 2MB.";
        } else {
            
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $newImageName = 'blog_' . bin2hex(random_bytes(8)) . '.' . $extension;
            $targetPath = $uploadDir . $newImageName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image
                if ($image && file_exists($uploadDir . $image)) {
                    unlink($uploadDir . $image);
                }
                $image = $newImageName;
            } else {
                $error = "Failed to upload new image.";
            }
        }
    }
    
    // Validatation
    if (empty($titre) || empty($contenu)) {
        $error = "Title and content are required.";
    }
    
    // Update blog 
    if (!$error) {
        try {
            if ($blog->mettreAJourArticle($id, $auteur, $titre, $contenu, $image)) {
                header('Location:../../../../frontend/admin/dashboard.php?page=blogs&success=blog a etet modifie');
                exit();
            } else {
                $error = "Failed to update blog post.";
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $error = "A database error occurred.";
        }
    }
}
?>

