<?php

$servername = "sql11.freesqldatabase.com";
$username = "sql11671132";
$password = "gCKLKEAIi7";
$dbname = "sql11671132";

// Připojení k databázi
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}

// Získání IP adresy klienta
$ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

// Pokud je adresa ::1, použij localhost
if ($ipAddress == '::1') {
    $ipAddress = '127.0.0.1';
}

// Konverze IPv6 na IPv4
$ipAddress = filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

// Nastavení časové zóny v rámci PHP
date_default_timezone_set('Europe/Prague'); // Změňte na svou potřebnou časovou zónu

// Zpracování formuláře pro registraci nebo čtení/zápis dat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získání dat z formuláře
    $realname = $conn->real_escape_string($_POST["realname"]);
    $name = strtolower($realname);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = isset($_POST["email"]) && $_POST["email"] !== "" ? $conn->real_escape_string($_POST["email"]) : null;

    // Kontrola, zda uživatel s daným jménem nebo emailem již existuje
    if ($email !== null) {
        $checkQuery = "SELECT * FROM users WHERE LOWER(name) = LOWER('$name') OR email = '$email'";
    } else {
        $checkQuery = "SELECT * FROM users WHERE LOWER(name) = LOWER('$name') AND email IS NULL";
    }
    
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "Uživatel s tímto jménem nebo emailem již existuje.";
    } else {
        // Nové ID pro vložení
        $new_id = getNewId($conn);

        // Datum registrace
        $regdate = date("Y-m-d H:i:s");

        // Zpracování a vložení dat do databáze
        $sql = "INSERT INTO users (id, name, realname, password, email, regdate, address) 
            VALUES ('$new_id', '$name', '$realname', '$password', '$email', '$regdate', '$ipAddress')";

        if ($conn->query($sql) === TRUE) {
            echo "Registrace úspěšná";

            // Získání dat z databáze pro kontrolu
            $selectQuery = "SELECT * FROM users WHERE name='$name'";
            $result = $conn->query($selectQuery);

            if ($result->num_rows > 0) {
                // Výpis nebo zpracování dat z databáze
                while ($row = $result->fetch_assoc()) {
                    echo "ID: " . $row["id"] . "<br>";
                    echo "Name: " . $row["name"] . "<br>";
                    echo "Realname: " . $row["realname"] . "<br>";
                    echo "Email: " . $row["email"] . "<br>";
                    echo "Regdate: " . $row["regdate"] . "<br>";
                    echo "IP Address: " . $row["address"] . "<br>";
                }
            } else {
                echo "Žádná data nebyla nalezena v databázi.";
            }
        } else {
            echo "Chyba při registraci: " . $conn->error;
        }
    }
} else {
    include "../RegistraceAPrihlaseni/registrace.html"; // Jinak zobrazit obsah souboru nwms.html
}

// Uzavření připojení k databázi
$conn->close();

// Funkce pro získání nového ID
function getNewId($connection) {
    $result = $connection->query("SELECT MAX(id) AS max_id FROM users");
    $row = $result->fetch_assoc();
    $last_id = $row['max_id'];
    return $last_id + 1;
}
?>
