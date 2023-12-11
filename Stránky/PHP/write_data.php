<?php
echo "Začátek process_registration.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Připojení k databázi
require_once('index.php');

$name = $conn->real_escape_string($_POST["name"]);
$realname = $conn->real_escape_string($_POST["realname"]);
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$address = $conn->real_escape_string($_POST["address"]);
$email = $conn->real_escape_string($_POST["email"]);

// Získání posledního použitého ID
$result = $conn->query("SELECT MAX(id) AS max_id FROM openlogin");
$row = $result->fetch_assoc();
$last_id = $row['max_id'];

// Nové ID pro vložení
$new_id = $last_id + 1;

// Datum registrace
$regdate = date("Y-m-d H:i:s");

// Zpracování a vložení dat do databáze
$sql = "INSERT INTO openlogin (id, name, realname, password, address, email, regdate) VALUES ('$new_id', '$name', '$realname', '$password', '$address', '$email', '$regdate')";

if ($conn->query($sql) === TRUE) {
    echo "Registrace úspěšná";

    // Získání dat z databáze pro kontrolu
    $selectQuery = "SELECT * FROM openlogin WHERE name='$name'";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        // Výpis nebo zpracování dat z databáze
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . "<br>";
            echo "Name: " . $row["name"] . "<br>";
            echo "Realname: " . $row["realname"] . "<br>";
            echo "Address: " . $row["address"] . "<br>";
            echo "Email: " . $row["email"] . "<br>";
            echo "Regdate: " . $row["regdate"] . "<br>";
        }
    } else {
        echo "Žádná data nebyla nalezena v databázi.";
    }
} else {
    echo "Chyba při registraci: " . $conn->error;
}
echo "Konec process_registration.php";
?>
