<?php
include "config.php";

$conn = mysqli_connect($host, $user, $password) or die("Błąd połączenia");

mysqli_select_db($conn, $database) or die("Błąd połączenia z bazą");

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM $tableName WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: a2.php");
        exit;
    } else {
        echo "Błąd usuwania rekordu: " . mysqli_error($conn);
    }
} else {
    echo "Brak ID rekordu do usunięcia.";
}

mysqli_close($conn);
?>