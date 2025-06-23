<?php
include '../../../../db/connectDB.php';

$sql = "
    SELECT 
        v.ville_id,
        v.nom,
        img.urlSrc,
        (
            SELECT COUNT(*) FROM hotel h WHERE h.ville_id = v.ville_id
        ) + (
            SELECT COUNT(*) FROM riads r WHERE r.ville_id = v.ville_id
        ) + (
            SELECT COUNT(*) FROM maison m WHERE m.ville_id = v.ville_id
        ) AS total_hebergements
    FROM villes v
    LEFT JOIN images_ville img ON img.ville_id = v.ville_id
    GROUP BY v.ville_id
    LIMIT 10
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$villes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="px-6 py-12 bg-white">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Meilleures destinations au Maroc</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
      <?php foreach ($villes as $ville): 
        $img = "../../../../backend/admin/pages/uploads/" . htmlspecialchars($ville["urlSrc"]);
        $nom = htmlspecialchars($ville["nom"]);
        $hebergements = number_format($ville["total_hebergements"], 0, ',', ' ');
        $id = (int)$ville["ville_id"];
      ?>
        <a href="../hebergement/index.php" class="group block">
          <div class="aspect-square overflow-hidden rounded-xl shadow-sm bg-gray-100 transition duration-300 group-hover:shadow-lg group-hover:scale-105">
            <img src="<?= $img ?>" alt="<?= $nom ?>" class="w-full h-full object-cover" />
          </div>
          <h3 class="mt-3 text-sm font-semibold text-gray-900 text-center"><?= $nom ?></h3>
          <p class="text-xs text-center text-gray-500"><?= $hebergements ?> hébergements</p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
