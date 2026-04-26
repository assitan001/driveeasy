<?php
require 'database.php';

$id = $_GET['id'] ?? null;
if (!$id) die("❌ Erreur : Aucun véhicule sélectionné");

$stmt = $pdo->prepare("SELECT * FROM vehicule WHERE id_vehicule = ?");
$stmt->execute([$id]);
$car = $stmt->fetch();

if (!$car) die("❌ Erreur : Véhicule introuvable");

// Traiter la soumission du formulaire
$erreur = '';
$success = '';


// update final
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $date_debut = trim($_POST['date_debut'] ?? '');
    $date_fin = trim($_POST['date_fin'] ?? '');

    // Validation
    if (!$nom) $erreur = "Le nom est obligatoire";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreur = "Email invalide";
    elseif (!$telephone) $erreur = "Le téléphone est obligatoire";
    elseif (!$date_debut) $erreur = "La date de début est obligatoire";
    elseif (!$date_fin) $erreur = "La date de fin est obligatoire";
    elseif ($date_fin <= $date_debut) $erreur = "La date de fin doit être après la date de début";
    else {
        // Calculer le nombre de jours
        $debut = new DateTime($date_debut);
        $fin = new DateTime($date_fin);
        $jours = $fin->diff($debut)->days + 1;
        $prix_total = $jours * $car['prix_jour'];

        // Insérer dans la base de données
        try {
            $sql = "INSERT INTO reservation (id_vehicule, nom, email, telephone, date_debut, date_fin, prix_total, statut) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'en attente')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id, $nom, $email, $telephone, $date_debut, $date_fin, $prix_total]);
            
            $success = "✅ Réservation confirmée ! Vous recevrez une confirmation par email.";
        } catch (PDOException $e) {
            $erreur = "Erreur lors de la réservation : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Réservation - Driveeazy</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<!-- HEADER -->
<header class="header">
    <div class="nav-container">
        <a href="index.php" class="logo">Driveeazy</a>
        <nav class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="catalogue.php">Voitures</a>
        </nav>
    </div>
</header>

<!-- RESERVATION SECTION -->
<div class="reservation-container">
    
    <!-- VEHICLE CARD -->
    <div class="vehicle-card">
        <div class="vehicle-image">
            <img src="images/<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['marque']) ?>">
            <span class="vehicle-badge"><?= htmlspecialchars($car['type']) ?></span>
        </div>
        <div class="vehicle-info">
            <h1><?= htmlspecialchars($car['marque'] . ' ' . $car['modele']) ?></h1>
            <div class="vehicle-specs">
               
                <span class="spec">🎨 <?= htmlspecialchars($car['couleur']) ?></span>
            </div>
            <div class="vehicle-price">
                <span class="price-value"><?= htmlspecialchars($car['prix_jour']) ?>€</span>
                <span class="price-label">/ jour</span>
            </div>
            <ul class="perks">
                <li>✓ Assurance incluse</li>
                <li>✓ Kilométrage illimité</li>
                <li>✓ Annulation gratuite 48h avant</li>
                <li>✓ Assistance 24/7</li>
            </ul>
        </div>
    </div>

    <!-- BOOKING FORM -->
    <div class="booking-form-section">
        <div class="form-header">
            <h2>Finalisez votre réservation</h2>
            <p>Complétez vos informations pour confirmer</p>
        </div>

        <?php if ($erreur): ?>
            <div style="background: rgba(255,0,0,0.1); border: 1px solid #ff0000; color: #ff6b6b; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div style="background: rgba(0,255,0,0.1); border: 1px solid #00ff00; color: #51cf66; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="booking-form">
            
            <!-- INFORMATIONS PERSONNELLES -->
            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom complet *</label>
                    <input type="text" id="nom" name="nom" placeholder="Jean Dupont" required>
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" placeholder="vous@example.com" required>
                </div>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone *</label>
                <input type="tel" id="telephone" name="telephone" placeholder="+33 6 12 34 56 78" required>
            </div>

            <!-- DATES -->
            <div class="form-row">
                <div class="form-group">
                    <label for="date_debut">Date de début *</label>
                    <input type="date" id="date_debut" name="date_debut" required>
                </div>
                <div class="form-group">
                    <label for="date_fin">Date de fin *</label>
                    <input type="date" id="date_fin" name="date_fin" required>
                </div>
            </div>

            <!-- PRICE SUMMARY -->
            <div class="price-summary">
                <div class="summary-row">
                    <span>Prix/jour</span>
                    <span id="daily-price"><?= htmlspecialchars($car['prix_jour']) ?>€</span>
                </div>
                <div class="summary-row">
                    <span id="duration-label">Durée</span>
                    <span id="duration">0 jour</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span id="total-amount">0€</span>
                </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <button type="submit" class="submit-btn">
                Confirmer la réservation
            </button>

            <p class="secure-notice">
                🔒 Paiement sécurisé par SSL • Donnees protégées
            </p>
        </form>
    </div>

</div>

<!-- FOOTER -->
<footer class="footer">
    <p>© 2026 Driveeazy • Location premium de véhicules</p>
</footer>

<script>
const prixJour = <?= $car['prix_jour'] ?>;
const dateDebut = document.getElementById('date_debut');
const dateFin = document.getElementById('date_fin');
const durationSpan = document.getElementById('duration');
const totalAmount = document.getElementById('total-amount');

function calculateDays() {
    if (!dateDebut.value || !dateFin.value) return;
    
    const debut = new Date(dateDebut.value);
    const fin = new Date(dateFin.value);
    const jours = Math.ceil((fin - debut) / (1000 * 60 * 60 * 24)) + 1;
    
    if (jours > 0) {
        durationSpan.textContent = jours + ' jour' + (jours > 1 ? 's' : '');
        totalAmount.textContent = (jours * prixJour) + '€';
    }
}

dateDebut.addEventListener('change', calculateDays);
dateFin.addEventListener('change', calculateDays);
</script>

</body>
</html>