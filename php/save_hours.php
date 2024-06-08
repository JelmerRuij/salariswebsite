<?php
session_start();
include 'db_connect.php';

if ($_POST['submit']) {
    $date = $_POST['date'];
    $hours = $_POST['hours'];
    $description = $_POST['description'];
    $username = $_SESSION['username'];
    $employerName = $_POST['employer'];

    // Zoek de gebruiker in de database
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Zoek de ID van de werkgever
        $stmt = $mysqli->prepare("SELECT id FROM employers WHERE name = ?");
        $stmt->bind_param("s", $employerName);
        $stmt->execute();
        $result = $stmt->get_result();
        $employer = $result->fetch_assoc();

        if ($employer) {
            // Sla de uren op in de database
            $stmt = $mysqli->prepare("INSERT INTO hours (user_id, employer_id, date, hours, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iissi", $user['id'], $employer['id'], $date, $hours, $description);
            $stmt->execute();

            // Haal de bonus op uit de database
            $stmt = $mysqli->prepare("SELECT amount FROM bonuses WHERE user_id = ?");
            $stmt->bind_param("i", $user['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $bonus = $result->fetch_assoc();

            if ($bonus) {
                // Doe iets met de bonus...
            }
        }

        $stmt->close();

        // Redirect naar het dashboard
        header("Location: ../dashboard.php");
    } else {
        // Gebruiker niet gevonden
        echo "Er is een fout opgetreden.";
    }
}
?>