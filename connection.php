<?php
// Database configuration
$host = "mysql";
$username = "root";
$password = "password";
$database = "rhys_firearms";

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set default fetch mode
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // DO NOT echo — it breaks session handling!
    error_log("DB Connection failed: " . $e->getMessage());
    die("Database connection error.");
}
?>