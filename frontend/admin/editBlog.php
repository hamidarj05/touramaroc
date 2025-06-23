<?php
// Initialize session and check authentication
session_start(); 

// if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
//     header('Location: /includes/login.php');
//     exit();
// }
include_once '../../db/connectDB.php';
require_once '../../backend/class/Blog.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
</head>
<body> 
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-image img-thumbnail';
                    preview.appendChild(img);
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Form validation
        document.getElementById('blogForm').addEventListener('submit', function(e) {
            const title = document.getElementById('titre').value.trim();
            const content = document.getElementById('contenu').value.trim();
            
            if (!title || !content) {
                e.preventDefault();
                alert('Title and content are required!');
            }
        });
    </script>
</body>
</html>