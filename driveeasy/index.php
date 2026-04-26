<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Driveeazy • Location premium</title>
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

<section class="hero">
    <div class="hero-content">


        <h1>Location de voiture<br><span>simple & premium</span></h1>
        <p>Trouvez votre véhicule en quelques secondes, partout en Europe</p>

        <form action="catalogue.php" method="GET" class="search-box">
            <input name="ville" placeholder="Ville (ex: Paris)">
            <input type="date" name="date_debut">
            <input type="date" name="date_fin">
            <button>Rechercher</button>
        </form>
    </div>
</section>

<section class="cars-section">

    <div class="section-header">
        <h2>Nos véhicules</h2>
        <p>Des modèles sélectionnés pour leur confort et leur élégance</p>
    </div>

    <div class="cars-grid">

        <div class="car-card">
            <div class="car-img">
                <img src="images/clio5-jaune.jpg">
            </div>
            <div class="car-content">
                <h3>Clio 5</h3>
                <p>Jaune</p>
                <div class="car-bottom">
                    <span>60.00€/jour</span>
                    <a href="catalogue.php" class="btn-small">Voir</a>
                </div>
            </div>
        </div>

        <div class="car-card">
            <div class="car-img">
                <img src="images/grisrs5.jpg">
            </div>
            <div class="car-content">
                <h3>Audi RS5</h3>
                <p>Gris</p>
                <div class="car-bottom">
                    <span>400.00€/jour</span>
                    <a href="catalogue.php" class="btn-small">Voir</a>
                </div>
            </div>
        </div>

        <div class="car-card">
            <div class="car-img">
                <img src="images/teslaS-noir.jpg">
            </div>
            <div class="car-content">
                <h3>Tesla Model S</h3>
                <p>Noir</p>
                <div class="car-bottom">
                    <span>490.00€/jour</span>
                    <a href="catalogue.php" class="btn-small">Voir</a>
                </div>
            </div>
        </div>

    </div>

</section>

<section class="about">
    <h2>Pourquoi Driveeazy ?</h2>

    <div class="features">
        <div>
            <h3>🚗 Véhicules récents</h3>
            <p>Des voitures modernes et entretenues</p>
        </div>

        <div>
            <h3>⚡ Réservation rapide</h3>
            <p>Moins de 2 minutes pour réserver</p>
        </div>

        <div>
            <h3>🔒 Sécurisé</h3>
            <p>Paiement et données protégés</p>
        </div>
    </div>
</section>

<footer class="footer">
    <p>© 2026 Driveeazy • Location premium de véhicules</p>
</footer>

</body>
</html>