<?php
include '../../../../db/connectDB.php';

$sql = "
    SELECT 
        'tour' AS type,
        t.tour_id AS id,
        t.titre,
        t.prix,
        t.dateDebut,
        t.dateFin,
        t.tour_description AS description,
        v.nom AS ville_nom,
        img.urlSrc,
        img.altText
    FROM tours t
    JOIN villes v ON t.ville_id = v.ville_id
    LEFT JOIN images_tour img ON img.tour_id = t.tour_id
    GROUP BY t.tour_id

    UNION

    SELECT 
        'activite' AS type,
        a.activite_id AS id,
        a.titre,
        a.prix,
        a.dateDebut,
        a.dateFin,
        a.activite_description AS description,
        v.nom AS ville_nom,
        img.urlSrc,
        img.altText
    FROM activites a
    JOIN villes v ON a.ville_id = v.ville_id
    LEFT JOIN images_activites img ON img.activite_id = a.activite_id
    GROUP BY a.activite_id

    ORDER BY dateDebut DESC
    LIMIT 8
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="bg-white px-6 py-10">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Tours & Activités</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php foreach ($items as $item): ?>
        <div class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-xl transition duration-300">
          <img src="../../../../backend/admin/pages/uploads/<?= htmlspecialchars($item['urlSrc']) ?>" alt="<?= htmlspecialchars($item['altText']) ?>" class="w-full h-52 object-cover">
          <div class="p-4">
            <span class="text-xs uppercase tracking-wide text-indigo-600 font-medium"><?= strtoupper($item['type']) ?></span>
            <h3 class="text-lg font-semibold text-gray-800 mt-1"><?= htmlspecialchars($item['titre']) ?></h3>
            <p class="text-sm text-gray-600"><?= htmlspecialchars($item['ville_nom']) ?></p>
            <p class="text-sm text-gray-500 mt-1"><?= number_format($item['prix'], 0, ',', ' ') ?> MAD</p>
            <p class="text-xs text-gray-400 mt-2"><?= date('d M', strtotime($item['dateDebut'])) ?> → <?= date('d M', strtotime($item['dateFin'])) ?></p>
            <p class="text-sm text-gray-500 mt-2"><?= substr($item['description'], 0, 90) ?>...</p>
            <a href="../toursactivities/index.php?type=<?= $item['type'] ?>&id=<?= $item['id'] ?>" class="mt-3 inline-block text-sm text-indigo-600 hover:underline">Voir plus</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
