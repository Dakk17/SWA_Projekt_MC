<?php

$servername = "sql11.freesqldatabase.com"; // nebo IP adresa serveru s databází
$username = "sql11669104";
$password = "4MyME1HJFa";
$dbname = "sql11669104";

// Připojení k databázi
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}

// Zpracování formuláře pro přihlášení
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];

    // Získání uloženého hesla pro daného uživatele
    $sql = "SELECT * FROM users WHERE name = '$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row["password"];

        // Kontrola shody hesel
        if (password_verify($password, $storedPassword)) {
            echo "Přihlášení úspěšné";
            // Zde můžeš provést další akce, např. nastavení relace atd.
        } else {
            echo "Nesprávné heslo";
        }
    } else {
        echo "Uživatel neexistuje";
    }
}

// Uzavření připojení k databázi
$conn->close();
?>
