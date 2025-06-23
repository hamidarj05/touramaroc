<?php require_once '../../../../db/connectDB.php';
       require_once  '../../../../backend/class/Blog.php';

$blog = new Blog($conn);

// Validation ID article
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$article = $blog->obtenirArticleParId((int)$_GET['id']);

if (!$article) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($article['titre']) ?> | TouraMaroc</title>
    <link rel="stylesheet" href="../../../generalCSS/bootstrap.min.css">
    <link rel="stylesheet" href="../../../generalCSS/style.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include '../../components/nav.php'; ?>
    
    <main class="container my-5">
        <article class="article-complet">
            <!-- Fil d'Ariane -->
            <nav aria-label="Fil d'Ariane" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Blog</a></li>
                    <li class="breadcrumb-item active">Article</li>
                </ol>
            </nav>

            <!-- Image Principale -->
            <?php if ($article['image']): ?>
            <div class="mb-4">
                <img src="../../../../backend/admin/uploads/blogs/<?= htmlspecialchars($article['image']) ?>"  
                     class="img-fluid rounded image-principale"
                     alt="<?= htmlspecialchars($article['titre']) ?>">
            </div>
            <?php endif; ?>

            <!-- En-tête Article -->
            <header class="mb-4">
                <h1 class="display-5 fw-bold"><?= htmlspecialchars($article['titre']) ?></h1>
                <div class="d-flex align-items-center gap-3 my-3">
                    <span class="text-muted">
                        <i class="bi bi-calendar"></i> 
                          <?php echo date('d-m-Y', strtotime($article['date_blog']));?>
                    </span>
                    <span class="text-muted">
                        <i class="bi bi-person"></i> 
                        <?= htmlspecialchars($article['auteur']) ?>
                    </span>
                </div>
            </header>

            <!-- Contenu -->
            <div class="contenu-article mb-5">
                <?= nl2br(htmlspecialchars($article['contenu'])) ?>
            </div>

            <!-- Bouton Retour -->
            <div class="text-center mt-5">
                <a href="index.php" class="btn btn-primary px-4">
                    <i class="bi bi-arrow-left"></i> Retour au blog
                </a>
            </div>
        </article>
    </main>

    <?php include '../../components/footer.php'; ?>
    
    <script src="../../../generalJS/bootstrap.bundle.min.js"></script>
</body>
</html>