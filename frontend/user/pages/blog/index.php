<?php require_once '../../../../db/connectDB.php';
require_once '../../../../backend/class/Blog.php';

$blog = new Blog($conn);

// Pagination
$page_actuelle = max(1, $_GET['page'] ?? 1);
$articles_par_page = 6;
$offset = ($page_actuelle - 1) * $articles_par_page;

// Récupérer les articles
$articles = $blog->obtenirArticlesPaginés($offset, $articles_par_page);
$total_articles = $blog->obtenirTotalArticles();
$total_pages = ceil($total_articles / $articles_par_page);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog | TouraMaroc</title>
    <link rel="stylesheet" href="../../../generalCSS/bootstrap.min.css">
    <link rel="stylesheet" href="../../../generalCSS/style.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include '../../components/nav.php'; ?>

    <main class="container my-5">
        <!-- Bannière -->
        <section class="banniere-blog mb-5 text-center py-4 bg-light rounded">
            <h1 class="display-4 fw-bold">Notre Blog Voyage</h1>
            <p class="lead">Découvrez les secrets du Maroc à travers nos récits</p>
        </section>

        <!-- Grille d'articles -->
        <div class="row g-4">
            <?php if (empty($articles)): ?>
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">Aucun article disponible pour le moment.</div>
                </div>
            <?php else: ?>
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-6 col-lg-4">
                        <article class="card-article card h-100 border-0 shadow-sm">
                            <?php if ($article['image']): ?>
                                <img src="../../../../backend/admin/uploads/blogs/<?= htmlspecialchars($article['image']) ?>"
                                    class="card-img-top img-article" alt="<?= htmlspecialchars($article['titre']) ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">
                                        <!-- strftime('%d %B %Y', strtotime($article['date_blog']))  -->
                                        <?php echo date('d-m-Y', strtotime($article['date_blog'])); ?>
                                    </span>
                                    <span class="badge bg-primary">Voyage</span>
                                </div>
                                <h2 class="h5 card-title"><?= htmlspecialchars($article['titre']) ?></h2>
                                <p class="card-text texte-accroche">
                                    <?= substr(strip_tags($article['contenu']), 0, 150) ?>...
                                </p>
                                <div class="d-flex justify-content-center">
                                    <a href="single.php?id=<?= $article['blog_id'] ?>" class="btn btn-outline-primary btn-sm">
                                        Lire la suite
                                    </a>
                                </div>

                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page_actuelle == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page_actuelle - 1 ?>">Précédent</a>
                    </li>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i == $page_actuelle ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= $page_actuelle == $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page_actuelle + 1 ?>">Suivant</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </main>

    <?php include '../../components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>