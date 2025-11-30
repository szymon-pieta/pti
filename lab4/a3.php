<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edycja rekordu</title>
</head>

<body>
    <div class="container">
        <?php
        include "config.php";

        $conn = mysqli_connect($host, $user, $password) or die("<p class='error'>Nie można się połączyć</p>");
        mysqli_select_db($conn, $database) or die("<p class='error'>Nie można wybrać bazy</p>");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $imie = $_POST['imie'];
            $ocena = $_POST['ocena'];
            $umie_apache = isset($_POST['umie_apache']) ? 1 : 0;
            $muzyka = $_POST['muzyka'];
            $data_jakas = $_POST['data_jakas'];

            $sql = "UPDATE $tableName SET imie='$imie', ocena='$ocena', umie_apache='$umie_apache', muzyka='$muzyka', data_jakas='$data_jakas' WHERE id='$id'";

            if (mysqli_query($conn, $sql)) {
                header("Location: a2.php");
                exit;
            } else {
                echo "<p class='error'>Błąd aktualizacji: " . mysqli_error($conn) . "</p>";
            }

        } else {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $sql = "SELECT * FROM $tableName WHERE id='$id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    ?>
                    <h2>Edycja rekordu</h2>
                    <form method="POST">
                        <div>
                            <label>ID:</label> 
                            <input type="text" name="id" value="<?php echo $row['id']; ?>" readonly style="background-color: #ddd;">
                        </div>
                        <div>
                            <label>Imię:</label> 
                            <input type="text" name="imie" value="<?php echo $row['imie']; ?>">
                        </div>
                        <div>
                            <label>Ocena:</label> 
                            <input type="number" name="ocena" value="<?php echo $row['ocena']; ?>">
                        </div>
                        <div>
                            <label>Umie Apache: <input type="checkbox" name="umie_apache" <?php echo $row['umie_apache'] ? 'checked' : ''; ?>></label>
                        </div>
                        <div>
                            <label>Muzyka:</label> 
                            <select name="muzyka">
                                <?php
                                $options = ['pop', 'country', 'techno', 'rock', 'metal'];
                                foreach ($options as $opt) {
                                    $selected = ($row['muzyka'] == $opt) ? 'selected' : '';
                                    echo "<option value='$opt' $selected>$opt</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label>Data:</label> 
                            <input type="date" name="data_jakas" value="<?php echo $row['data_jakas']; ?>">
                        </div>
                        <div class="form-buttons">
                            <input type="submit" value="Zapisz">
                            <a href="a2.php" class="btn-cancel">Anuluj</a>
                        </div>
                    </form>
                    <?php
                } else {
                    echo "<p class='error'>Nie znaleziono rekordu.</p>";
                }
            } else {
                echo "<p class='error'>Brak ID rekordu.</p>";
            }
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>