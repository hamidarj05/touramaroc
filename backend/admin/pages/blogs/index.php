<?php
// authentication
session_start();
require_once '../../includes/db.php';
require_once '../../../class/Blog.php';

// Redirect if not admin
if (!isset($_SESSION['user']) || empty($_SESSION['user']['is_admin'])) {
    header('Location: /includes/login.php');
    exit();
}

$blog = new Blog($conn);

// Flash messages
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;

// Clear flash messages
unset($_SESSION['success'], $_SESSION['error']);

// Get all blog posts
try {
    $blogs = $blog->obtenirTousArticles();
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $error = "Failed to load blog posts. Please try again later.";
    $blogs = [];
}

// Handle bulk actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_action'])) {
    $action = $_POST['bulk_action'];
    $selected = $_POST['selected'] ?? [];
    
    if (!empty($selected)) {
        try {
            foreach ($selected as $id) {
                if (ctype_digit($id)) {
                    $id = (int)$id;
                    
                    if ($action === 'delete') {
                        $post = $blog->obtenirArticleParId($id);
                        if ($post && $blog->supprimerArticle($id)) {
                            // Delete associated image
                            if (!empty($post['image'])) {
                                $imagePath = realpath(__DIR__ . '/../../../uploads/blogs/' . $post['image']);
                                if ($imagePath && file_exists($imagePath) && is_writable($imagePath)) {
                                    unlink($imagePath);
                                }
                            }
                        }
                    }
                }
            }
            
            $_SESSION['success'] = "Bulk action completed successfully";
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            error_log("Bulk action error: " . $e->getMessage());
            $_SESSION['error'] = "Failed to complete bulk action";
            header('Location: index.php');
            exit();
        }
    }
}

require_once '../../includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .table img {
            max-width: 100px;
            max-height: 60px;
            object-fit: cover;
        }
        .action-buttons {
            white-space: nowrap;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>
                <i class="bi bi-journal-text"></i> Manage Blog Posts
            </h1>
            <a href="add.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New
            </a>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="post" id="bulkForm">
            <div class="card mb-4">
                <div class="card-header bg-light sticky-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <select name="bulk_action" class="form-select me-2" style="width: auto;">
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i> Apply
                            </button>
                        </div>
                        <div class="text-muted">
                            <?= count($blogs) ?> item(s)
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($blogs)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No blog posts found. <a href="add.php">Create your first post</a>.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($blogs as $post): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected[]" value="<?= (int)$post['blog_id'] ?>" class="form-check-input">
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($post['titre']) ?></strong>
                                        </td>
                                        <td>
                                            <?php if (!empty($post['image'])): ?>
                                                <img src="../../uploads/blogs/<?= htmlspecialchars($post['image']) ?>" 
                                                     alt="<?= htmlspecialchars($post['titre']) ?>" 
                                                     class="img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted">No image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($post['auteur']) ?></td>
                                        <td>
                                            <?= date('M j, Y', strtotime($post['date_blog'])) ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="edit.php?id=<?= (int)$post['blog_id'] ?>" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="post" action="delete.php" class="d-inline">
                                                    <input type="hidden" name="id" value="<?= (int)$post['blog_id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this post?')"
                                                            title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if (!empty($blogs)): ?>
                    <div class="card-footer bg-light">
                        <div class="text-muted text-center">
                            Showing <?= count($blogs) ?> item(s)
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all checkboxes
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            
            selectAll.addEventListener('change', function(e) {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = e.target.checked;
                });
            });
            
            // Update "Select All" checkbox when individual checkboxes change
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (!this.checked) {
                        selectAll.checked = false;
                    } else {
                        // Check if all are now selected
                        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                        selectAll.checked = allChecked;
                    }
                });
            });
            
            // Bulk form submission confirmation
            document.getElementById('bulkForm').addEventListener('submit', function(e) {
                const selected = Array.from(this.querySelectorAll('input[name="selected[]"]:checked'));
                
                if (selected.length === 0) {
                    alert('Please select at least one item to perform this action');
                    e.preventDefault();
                    return;
                }
                
                if (!confirm(`Are you sure you want to delete ${selected.length} selected item(s)?`)) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>