<?php
echo "Začátek process_registration.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Funkce pro získání nového ID
function getNewId($connection) {
    $result = $connection->query("SELECT MAX(id) AS max_id FROM users");
    $row = $result->fetch_assoc();
    $last_id = $row['max_id'];
    return $last_id !== null ? $last_id + 1 : 1;
}

// Kontrola, zda jsou data POST metody dostupná
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["realname"], $_POST["password"], $_POST["address"], $_POST["email"])) {
    $realname = $conn->real_escape_string($_POST["realname"]);
    $name = strtolower($realname); // Uložení jména jako lowercase
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $address = $conn->real_escape_string($_POST["address"]);
    $email = $conn->real_escape_string($_POST["email"]);

    // Kontrola, zda uživatel s daným jménem nebo emailem již existuje
    $checkQuery = "SELECT * FROM users WHERE LOWER(name) = LOWER('$name') OR email = '$email'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "Uživatel s tímto jménem nebo emailem již existuje.";
    } else {
        // Získání nového ID pro vložení
        $new_id = getNewId($conn);

        // Datum registrace
        $regdate = date("Y-m-d H:i:s");

        // Zpracování a vložení dat do databáze
        $sql = "INSERT INTO users (id, name, realname, password, address, email, regdate) VALUES ('$new_id', '$name', '$realname', '$password', '$address', '$email', '$regdate')";

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
    }
} else {
    echo "Data pro registraci nebyla poskytnuta.";
}
echo "Konec process_registration.php";
?>
