<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dodaj wpis</title>
</head>

<body>
    <div class="container">
        <?php
        include "config.php";
        $conn = mysqli_connect($host, $user, $password) or die("<p class='error'>Nie można się połączyć</p>");
        mysqli_select_db($conn, $database) or die("<p class='error'>Nie można wybrać bazy</p>");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $imie = $_POST['imie'];
            $ocena = $_POST['ocena'];
            $umie_apache = isset($_POST['umie_apache']) ? 1 : 0;
            $muzyka = $_POST['muzyka'];
            $data_jakas = $_POST['data_jakas'];

            $sql = "INSERT INTO $tableName (imie, ocena, umie_apache, muzyka, data_jakas) VALUES ('$imie', '$ocena', '$umie_apache', '$muzyka', '$data_jakas')";

            if (mysqli_query($conn, $sql)) {
                header("Location: a2.php");
                exit;
            } else {
                echo "<p class='error'>Błąd dodawania rekordu: " . mysqli_error($conn) . "</p>";
            }

        } else {
            ?>
            <h2>Dodaj nowy wpis</h2>
            <form method="POST">
                <div>
                    <label>Imię:</label>
                    <input type="text" name="imie" required>
                </div>
                <div>
                    <label>Ocena:</label>
                    <input type="number" name="ocena" required>
                </div>

                <label>Umie Apache: <input type="checkbox" name="umie_apache"></label>

                <div>
                    <label>Muzyka:</label>
                    <select name="muzyka">
                        <option value="pop">pop</option>
                        <option value="country">country</option>
                        <option value="techno">techno</option>
                        <option value="rock">rock</option>
                        <option value="metal">metal</option>
                    </select>
                </div>
                <div>
                    <label>Data:</label>
                    <input type="date" name="data_jakas" required>
                </div>
                <input type="submit" value="Dodaj">
            </form>
            <?php
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>