<?php
include '../../../../db/connectDB.php';

$sql = "
    SELECT 
        e.id_evenement,
        e.nom,
        e.lieu,
        e.description_evenement,
        e.dateDebut,
        e.dateFin,
        img.urlSrc,
        img.alt
    FROM evenements e
    LEFT JOIN images_evenement img ON img.id_evenement = e.id_evenement
    ORDER BY e.dateDebut ASC
    LIMIT 6
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="bg-gray-50 py-12 px-6">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-8">🎉 Événements à venir</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <?php foreach ($evenements as $event): 
        $img = "../../../../backend/admin/pages/" . htmlspecialchars($event["urlSrc"]);
        $nom = htmlspecialchars($event["nom"]);
        $lieu = htmlspecialchars($event["lieu"]);
        $dateDebut = date("d M Y", strtotime($event["dateDebut"]));
        $dateFin = date("d M Y", strtotime($event["dateFin"]));
        $desc = mb_strimwidth(strip_tags($event["description_evenement"]), 0, 100, "...");
      ?>
        <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition duration-300">
          <img src="<?= $img ?>" alt="<?= htmlspecialchars($event["alt"]) ?>" class="w-full h-48 object-cover" />
          <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900"><?= $nom ?></h3>
            <p class="text-sm text-gray-500 mb-1">📍 <?= $lieu ?></p>
            <p class="text-sm text-gray-500 mb-2">📅 <?= $dateDebut ?> - <?= $dateFin ?></p>
            <p class="text-sm text-gray-700"><?= $desc ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
 
    <div class="mt-10 text-center">
      <a href="../events/index.php" class="inline-block px-6 py-3 bg-rose-600 text-white font-semibold rounded-full hover:bg-rose-700 transition duration-300">
        Voir tous les événements
      </a>
    </div>
  </div>
</section>
