<?php
// Paramètres de connexion
$host = 'localhost';
$db = 'driveeasy'; // nom de la base
$user = 'root';
$pass = ''; // vide sur XAMPP
$charset = 'utf8mb4';

// DSN (chaîne de connexion)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options PDO (important)
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Affiche les erreurs
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Tableau associatif
    PDO::ATTR_EMULATE_PREPARES => false, // Sécurité
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>