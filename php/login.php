<?php
include 'db_connect.php';

if ($_POST['submit']) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Zoek de gebruiker in de database
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Controleer het wachtwoord
    if ($user && password_verify($password, $user['password'])) {
        // Succesvolle login
        session_start();
        $_SESSION['username'] = $user['username'];
        header("Location: ../dashboard.php");
    } else {
        // Onjuist e-mailadres of wachtwoord
        echo "Onjuist e-mailadres of wachtwoord.";
    }

    $stmt->close();
}