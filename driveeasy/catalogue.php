<?php
require 'database.php';

$couleur = $_GET['couleur'] ?? '';

$sql = "SELECT * FROM vehicule WHERE 1=1";
$params = [];

if ($couleur) {
    $sql .= " AND couleur = ?";
    $params[] = $couleur;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vehicules = $stmt->fetchAll();
?>

<!DOCTYPE html>

<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catalogue - Driveeazy</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header class="header">
    <div class="nav-container">
        <a href="index.php" class="logo">Driveeazy</a>
        <nav class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="catalogue.php">Voitures</a>
        </nav>
    </div>
</header>

<div class="catalogue-container">
    <div class="catalogue-header">
        <h1>Nos véhicules</h1>
        <p>Découvrez notre sélection de véhicules premium</p>
    </div>


<form method="GET" class="filters-bar">
    <select name="couleur" class="filter-select">
        <option value="">Toutes les couleurs</option>
        <option value="noir" <?= $couleur === 'noir' ? 'selected' : '' ?>>Noir</option>
        <option value="blanc" <?= $couleur === 'blanc' ? 'selected' : '' ?>>Blanc</option>
        <option value="rouge" <?= $couleur === 'rouge' ? 'selected' : '' ?>>Rouge</option>
        <option value="bleu" <?= $couleur === 'bleu' ? 'selected' : '' ?>>Bleu</option>
        <option value="gris" <?= $couleur === 'gris' ? 'selected' : '' ?>>Gris</option>
    </select>

    <button type="submit" class="btn-filter">Filtrer</button>
</form>

<div class="cars-grid">
    <?php if (empty($vehicules)): ?>
        <p class="no-results">Aucun véhicule 😢</p>
    <?php else: ?>
        <?php foreach ($vehicules as $row): ?>
            <div class="car-card">
                <div class="car-img">
                    <img src="images/<?= htmlspecialchars($row['image']) ?>">
                    <div class="car-overlay">
                        <a href="voiture.php?id=<?= $row['id_vehicule'] ?>" class="quick-view">Voir</a>
                    </div>
                </div>
                <div class="car-content">
                    <h3><?= htmlspecialchars($row['marque'].' '.$row['modele']) ?></h3>
                    <p><?= htmlspecialchars($row['type']) ?></p>
                    <div class="car-bottom">
                        <span><?= $row['prix_jour'] ?>€/jour</span>
                        <a href="reservation.php?id=<?= $row['id_vehicule'] ?>" class="btn-small">Réserver</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
```

</div>

<footer class="footer">
    <p>© 2026 Driveeazy</p>
</footer>

</body>
</html>
