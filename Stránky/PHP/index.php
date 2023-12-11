<?php
echo "Server API: " . php_sapi_name();

$servername = "sql11.freesqldatabase.com";
$username = "sql11669104";
$password = "4MyME1HJFa";
$dbname = "sql11669104";

// Připojení k databázi
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}

// Nastavení časové zóny v rámci PHP
date_default_timezone_set('Europe/Prague'); // Změňte na svou potřebnou časovou zónu

// Zpracování formuláře pro registraci nebo čtení/zápis dat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "registrace.php"; // Skript pro registraci, pokud byl odeslán formulář
} elseif (isset($_GET["action"]) && $_GET["action"] == "read") {
    include "read_data.php"; // Skript pro čtení dat, pokud je zadána akce "read"
} elseif (isset($_GET["action"]) && $_GET["action"] == "write") {
    include "write_data.php"; // Skript pro zápis dat, pokud je zadána akce "write"
} else {
    include "../RegistraceAPrihlaseni/registrace.html"; // Jinak zobrazit obsah souboru nwms.html
}

// Uzavření připojení k databázi
$conn->close();
?>
