<?php
session_start();
require_once '../../../../db/connectDB.php';
require_once  '../../../class/Blog.php';

// for non-admin users
// if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
//     header('Location: /includes/login.php');
//     exit();
// }

$blog = new Blog($conn);
 
// Validate blog post ID
if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
    $_SESSION['error'] = "Invalid blog post ID";
    header('Location:../../../../frontend/admin/dashboard.php?page=blogs');
    exit();
}

$id = (int)$_POST['id'];

try {
    // Get blog post to delete associated image
    $blogPost = $blog->obtenirArticleParId($id);

    if (!$blogPost) {
        header('Location:Location:../../../../frontend/admin/dashboard.php?page=blogs&success=Blog post not found ✖');
        exit();
    }

    // supprimer l'article
    if ($blog->supprimerArticle($id)) {
        // supprimer l'image associée
        if (!empty($blogPost['image'])) {
            $imagePath =  '../../uploads/blogs/' . $blogPost['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
 
    } else {
        $_SESSION['error'] = "Failed to delete blog post";
    }
} catch (PDOException $e) {
    error_log("Database error during deletion: " . $e->getMessage());
    $_SESSION['error'] = "A database error occurred";
}

// Redirect back to blog listing

