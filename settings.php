<?php
session_start();
include './php/db_connect.php';

// Zoek de gebruiker in de database
$stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Voeg een werkgever toe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employer'], $_POST['wage'])) {
    $stmt = $mysqli->prepare("INSERT INTO employers (user_id, name, wage) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $user['id'], $_POST['employer'], $_POST['wage']);
    $stmt->execute();
    $stmt->close();
    header("Location: settings.php"); // Redirect naar dezelfde pagina
    exit();
}

// Voeg een bonus toe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'], $_POST['description'])) {
    $stmt = $mysqli->prepare("INSERT INTO bonuses (user_id, amount, description) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $user['id'], $_POST['amount'], $_POST['description']);
    $stmt->execute();
    $stmt->close();
    header("Location: settings.php"); // Redirect naar dezelfde pagina
    exit();
}

// Verwijder of bewerk een bonus, salaris of werkgever
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'])) {
    if ($_POST['action'] === 'delete') {
        if (isset($_POST['type']) && $_POST['type'] === 'employer') {
            $stmt = $mysqli->prepare("DELETE FROM employers WHERE id = ?");
            if ($stmt === false) {
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $bind = $stmt->bind_param("i", $_POST['id']);
            if ($bind === false) {
                die('bind_param() failed: ' . htmlspecialchars($stmt->error));
            }
            $exec = $stmt->execute();
            if ($exec === false) {
                die('execute() failed: ' . htmlspecialchars($stmt->error));
            }
            $stmt->close();
            header("Location: settings.php"); // Redirect naar dezelfde pagina
            exit();
        } else {
            $stmt = $mysqli->prepare("DELETE FROM bonuses WHERE id = ?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header("Location: settings.php"); // Redirect naar dezelfde pagina
            exit();
        }
    } elseif ($_POST['action'] === 'edit') {
        // Hier zou je de logica voor het bewerken van een bonus of salaris plaatsen
    }
}


// Haal de werkgevers van de gebruiker op
$stmt = $mysqli->prepare("SELECT * FROM employers WHERE user_id = ?");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$employers = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Haal de bonussen van de gebruiker op
$stmt = $mysqli->prepare("SELECT * FROM bonuses WHERE user_id = ?");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$bonuses = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instellingen</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <div class="container mx-auto py-10">
        <h1 class='text-2xl font-bold mb-4'>Instellingen</h1>

        <h2 class='text-xl font-bold mb-2'>Account</h2>
        <p>Gebruikersnaam: <?php echo $_SESSION['username']; ?></p>
        <p>Email: <?php echo $user['email']; ?></p>

        <h2 class='text-xl font-bold mb-2'>Werkgevers</h2>
        <form method="POST">
            <input type="text" name="employer" placeholder="Naam van de werkgever" required>
            <input type="number" step="0.01" name="wage" placeholder="Uurloon" required>
            <button type="submit">Voeg toe</button>
        </form>
        <?php foreach ($employers as $employer): ?>
    <p><?php echo $employer['name']; ?>: €<?php echo number_format($employer['wage'], 2); ?></p>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $employer['id']; ?>">
        <input type="hidden" name="type" value="employer">
        <button type="submit" name="action" value="edit">Bewerken</button>
        <button type="submit" name="action" value="delete">Verwijderen</button>
    </form>
<?php endforeach; ?>

        <h2 class='text-xl font-bold mb-2'>Bonussen</h2>
        <form method="POST">
            <input type="number" step="0.01" name="amount" placeholder="Bedrag van de bonus" required>
            <input type="text" name="description" placeholder="Beschrijving van de bonus">
            <button type="submit">Voeg toe</button>
        </form>
        <?php foreach ($bonuses as $bonus): ?>
    <p><?php echo $bonus['description']; ?>: €<?php echo number_format($bonus['amount'], 2); ?></p>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $bonus['id']; ?>">
        <input type="hidden" name="type" value="bonus">
        <button type="submit" name="action" value="edit">Bewerken</button>
        <button type="submit" name="action" value="delete">Verwijderen</button>
    </form>
<?php endforeach; ?>

        <footer class='mt-10'>
            <p>© 2024</p>
        </footer>
    </div>
</body>
</html>