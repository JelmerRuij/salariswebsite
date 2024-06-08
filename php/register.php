<?php
include 'db_connect.php';

if ($_POST['submit']) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $registration_date = date('Y-m-d H:i:s'); // Huidige datum en tijd

    // Maak verbinding met de database en voeg de gebruiker toe
    $stmt = $mysqli->prepare("INSERT INTO users (username, email, password, registration_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $registration_date);
    $stmt->execute();
    $stmt->close();
}