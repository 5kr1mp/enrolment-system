<?php


try {
    $pdo = new PDO("sqlite:".__DIR__."/database.db");

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected Successfully";
} catch (PDOException $e) {
    die("Connection failed: ".$e->getMessage());
}
?>