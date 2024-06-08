<?php
// db_connect.php

$servername = "database-5015927890.webspace-host.com";
$username = "dbu1953085";
$password = "UrenRegistratieApp1234";
$dbname = "dbs12981776";

// Maak verbinding met de database
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($mysqli->connect_error) {
    die("Verbinding mislukt: " . $mysqli->connect_error);
}