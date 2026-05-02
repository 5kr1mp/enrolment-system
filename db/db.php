<?php

$dbHost = getenv("DB_HOST") ?? "localhost";
$dbUser = getenv("DB_USER") ?? "root";
$dbPass = getenv("DB_PASS") ?? "";
$dbName = "enrollment_system";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected Successfully";
} catch (PDOException $e) {
    die("Connection failed: ".$e->getMessage());
}
?>