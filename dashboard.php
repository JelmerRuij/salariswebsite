<?php
session_start();
include './php/db_connect.php';

// Zoek de gebruiker in de database
$stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <div class="container mx-auto py-10">
        <?php
        echo "<h1 class='text-2xl font-bold mb-4'>Welkom, " . $_SESSION['username'] . "!</h1>";

        if ($user) {
            // Haal de uren van de gebruiker op uit de database
            $stmt = $mysqli->prepare("SELECT * FROM hours WHERE user_id = ?");
            $stmt->bind_param("i", $user['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<div class='grid grid-cols-3 gap-4'>";
            echo "<div class='font-bold'>Datum</div>";
            echo "<div class='font-bold'>Uren</div>";
            echo "<div class='font-bold'>Beschrijving</div>";

            while ($row = $result->fetch_assoc()) {
                echo "<div>" . $row['date'] . "</div>";
                echo "<div>" . $row['hours'] . "</div>";
                echo "<div>" . $row['description'] . "</div>";
            }

            echo "</div>";

            $stmt->close();
        } else {
            // Gebruiker niet gevonden
            echo "<p class='text-red-500'>Er is een fout opgetreden.</p>";
        }
        ?>
    </div>
</body>
</html>