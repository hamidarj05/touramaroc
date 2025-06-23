<?php
include '../../../../db/connectDB.php';

$sql = "
    SELECT 
        h.id,
        h.hebergement_id,
        h.type,
        COALESCE(ho.nom, ri.nom, ma.nom) AS nom,
        COALESCE(ho.prix, ri.prix, ma.prix) AS prix,
        COALESCE(ho.ville_id, ri.ville_id, ma.ville_id) AS ville_id,
        v.nom AS ville_nom,
        img.urlSrc,
        img.alt
    FROM hebergements h
    LEFT JOIN hotel ho ON ho.id = h.hebergement_id AND h.type = 'hotel'
    LEFT JOIN riads ri ON ri.id = h.hebergement_id AND h.type = 'riad'
    LEFT JOIN maison ma ON ma.id = h.hebergement_id AND h.type = 'maison'
    LEFT JOIN villes v ON v.ville_id = COALESCE(ho.ville_id, ri.ville_id, ma.ville_id)
    LEFT JOIN hebergement_images img ON img.hebergement_id = h.id
    ORDER BY h.type
    LIMIT 6
";
 

$stmt = $conn->prepare($sql);
$stmt->execute();
$hebergements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="bg-white py-12 px-6">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-8"> Nos Hébergements</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <?php foreach ($hebergements as $h): ?>
        <div class="bg-gray-50 rounded-xl overflow-hidden shadow hover:shadow-lg transition duration-300">
          <img src="../../../../backend/admin/pages/uploads/<?= $h["urlSrc"] ?>" alt="<?= $h["alt"]  ?>" class="w-full h-48 object-cover" />
          <div class="p-4">
            <span class="text-xs text-indigo-600 uppercase font-semibold"><?=$h["type"] ?></span>
            <h3 class="text-lg font-semibold text-gray-900"><?= $h["nom"] ?></h3>
            <p class="text-sm text-gray-600">📍 <?= $h["ville_nom"]  ?></p>
            <p class="text-sm text-gray-800 mt-1"><?= $h["prix"], 0, ',', ' '?> MAD / nuit</p>
            <a href="hebergement_details.php?type=<?= $h['type'] ?>&id=<?= $h['hebergement_id'] ?>" class="inline-block mt-3 text-indigo-600 hover:underline text-sm">
              Voir plus
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  
    <div class="mt-10 text-center">
      <a href="../hebergement/index.php" class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-full hover:bg-indigo-700 transition duration-300">
        Voir tous les hébergements
      </a>
    </div>
  </div>
</section>
