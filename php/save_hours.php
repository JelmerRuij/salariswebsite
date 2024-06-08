<?php
session_start();
include 'db_connect.php';

if ($_POST['submit']) {
    $date = $_POST['date'];
    $hours = $_POST['hours'];
    $description = $_POST['description'];
    $username = $_SESSION['username'];

    // Zoek de gebruiker in de database
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Sla de uren op in de database
        $stmt = $mysqli->prepare("INSERT INTO hours (user_id, date, hours, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $user['id'], $date, $hours, $description);
        $stmt->execute();
        $stmt->close();

        // Redirect naar het dashboard
        header("Location: ../dashboard.php");
    } else {
        // Gebruiker niet gevonden
        echo "Er is een fout opgetreden.";
    }
}
?>