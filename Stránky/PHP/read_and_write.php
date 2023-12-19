<?php
// Funkce pro připojení k SQLite databázi
function connectToSQLite($dbPath)
{
    return new SQLite3($dbPath);
}

// Funkce pro připojení k MySQL databázi
function connectToMySQL($servername, $username, $password, $dbname)
{
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Chyba připojení k MySQL databázi: " . $conn->connect_error);
    }

    return $conn;
}

// Funkce pro převedení timestampu na formátovaný čas
function convertTimestampToDatetime($timestamp)
{
    // Převede timestamp na DateTime objekt
    $dateTime = DateTime::createFromFormat('U.u', $timestamp / 1000);

    // Přidá posun času o 1 hodinu (3600 sekund)
    $dateTime->setTimezone(new DateTimeZone('Europe/Prague'));

    // Nyní můžete vrátit formátovaný čas jako řetězec
    return $dateTime->format('Y-m-d H:i:s');
}

// Připojení k SQLite souboru (Minecraft server)
$minecraftDb = connectToSQLite('E:\MC_SWA\servers\eb85dfb1-494e-4bb7-92eb-723cb11b4b32\plugins\OpeNLogin\accounts.db');

// Připojení k MySQL databázi
$servername = "sql11.freesqldatabase.com";
$username = "sql11671132";
$password = "gCKLKEAIi7";
$dbname = "sql11671132";
$mysqlConn = connectToMySQL($servername, $username, $password, $dbname);

// Kontrola připojení k MySQL databázi
if ($mysqlConn->connect_error) {
    die("Chyba připojení k MySQL databázi: " . $mysqlConn->connect_error);
}

// Dotaz na čtení dat z Minecraft serveru
$query = $minecraftDb->query('SELECT * FROM openlogin');

while ($row = $query->fetchArray()) {
    $name = $row['name'];
    $realname = $row['realname'];
    $password = $row['password'];
    $address = $row['address'];
    $regdate = convertTimestampToDatetime($row['regdate']);
    $lastlogin = convertTimestampToDatetime($row['lastlogin']);
    // Dotaz pro kontrolu existence záznamu se stejným jménem a skutečným jménem
    $checkQuery = "SELECT * FROM users WHERE name='$name' AND realname='$realname'";
    $result = $mysqlConn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Aktualizace existujícího záznamu
        $updateQuery = "UPDATE users SET password='$password', address='$address', regdate='$regdate', lastlogin='$lastlogin' WHERE name='$name' AND realname='$realname'";
        $mysqlConn->query($updateQuery);
    } else {
        // Vložení nového záznamu
        $insertQuery = "INSERT INTO users (name, realname, password, address, regdate, lastlogin) VALUES ('$name', '$realname', '$password', '$address', '$regdate', '$lastlogin')";
        $mysqlConn->query($insertQuery);
    }
}

// Uzavření připojení k MySQL databázi
$mysqlConn->close();
// Uzavření připojení k SQLite souboru
$minecraftDb->close();
?>
