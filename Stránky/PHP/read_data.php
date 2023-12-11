<?php
// Připojení k databázi
require_once('index.php');

// Dotaz na čtení dat
$query = $conn->query('SELECT * FROM openlogin');
while ($row = $query->fetch_assoc()) {
    echo "ID: " . $row['id'] . "<br>";
    echo "Name: " . $row['name'] . "<br>";
    echo "Realname: " . $row['realname'] . "<br>";
    echo "Address: " . $row['address'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Regdate: " . $row['regdate'] . "<br>";
}
?>
