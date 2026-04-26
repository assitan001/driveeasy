<?php
require 'database.php';

$id = $_GET['id'] ?? null;
if (!$id) die("❌ Erreur : Aucun véhicule sélectionné");

$stmt = $pdo->prepare("SELECT * FROM vehicule WHERE id_vehicule = ?");
$stmt->execute([$id]);
$car = $stmt->fetch();

if (!$car) die("❌ Erreur : Véhicule introuvable");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<!--caractère spéciaux-->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($car['marque'] . ' ' . $car['modele']) ?> - Driveeazy</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<!-- ORGA HEADER -->
<header class="header">
    <div class="nav-container">
        <a href="index.php" class="logo">Driveeazy</a>
        <nav class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="catalogue.php">Voitures</a>
        </nav>
    </div>
</header>

<!-- DETAILS VOITURE -->
<div class="car-details-container">
    
    <!-- IMAGE & SPECS -->
    <div class="car-details-left">
        <div class="car-image-wrapper">
            <img src="images/<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['marque']) ?>">
            <span class="badge"><?= htmlspecialchars($car['type']) ?></span>
        </div>
        
        <div class="car-specs-grid">
            <div class="spec-item">
                <span class="spec-label">Couleur</span>
                <span class="spec-value"><?= htmlspecialchars($car['couleur']) ?></span>
            </div>
        </div>
    </div>

    <!-- BOOKING -->
    <div class="car-details-right">
        <h1><?= htmlspecialchars($car['marque'] . ' ' . $car['modele']) ?></h1>
        <p class="car-type"><?= htmlspecialchars($car['type']) ?></p>
        
        <div class="price-section">
            <span class="price"><?= htmlspecialchars($car['prix_jour']) ?>€</span>
            <span class="price-label">/ jour</span>
        </div>

        <div class="booking-widget">
            <div class="input-group">
                <label for="jours">Durée de location</label>
                <div class="number-input">
                    <button type="button" onclick="decrementDays()">−</button>
                    <input type="number" id="jours" value="1" min="1" max="365" readonly>
                    <button type="button" onclick="incrementDays()">+</button>
                </div>
            </div>

            <div class="price-calc">
                <span>Total estimé</span>
                <span id="total" class="total-price">0€</span>
            </div>

            <a href="reservation.php?id=<?= $car['id_vehicule'] ?>" class="btn-reserve">
                Réserver maintenant
            </a>

            <p class="secure-text">🔒 Paiement sécurisé - Annulation gratuite jusqu'à 48h</p>
        </div>
    </div>

</div>

<!-- FOOTER -->
<footer class="footer">
    <p>© 2026 Driveeazy • Location premium de véhicules</p>
</footer>

<script>
const prix = <?= $car['prix_jour'] ?>;
const joursInput = document.getElementById("jours");
const totalDisplay = document.getElementById("total");

function updateTotal() {
    const jours = parseInt(joursInput.value) || 1;
    totalDisplay.textContent = (prix * jours) + "€";
}

function incrementDays() {
    joursInput.value = parseInt(joursInput.value) + 1;
    updateTotal();
}

function decrementDays() {
    if (parseInt(joursInput.value) > 1) {
        joursInput.value = parseInt(joursInput.value) - 1;
        updateTotal();
    }
}

joursInput.addEventListener("input", updateTotal);
updateTotal();
</script>

</body>
</html>