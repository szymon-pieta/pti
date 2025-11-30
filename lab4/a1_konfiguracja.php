<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Konfiguracja Bazy Danych</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>Konfiguracja Bazy Danych</h1>
        </header>

        <?php
        if (file_exists("config.php")) {
            include("config.php");
        } else {
            die("<p class='error'>Brak pliku konfiguracyjnego. <a href='a1.php'>Wróć do a1.php</a></p></div></body></html>");
        }

        $conn = mysqli_connect($host, $user, $password);
        if (!$conn) {
            die("<p class='error'>Nie można nawiązać połączenia: " . mysqli_connect_error() . "</p></div></body></html>");
        }

        echo "<p class='success'>Połączenie z serwerem nawiązane.</p>";

        $db_selected = mysqli_select_db($conn, $database);
        $db_action = $_POST['db_action'] ?? '';

        if (empty($db_action) && isset($_POST['table_action'])) {
            $db_action = 'keep';
        }

        if ($db_selected) {
            if ($db_action == 'recreate') {
                mysqli_query($conn, "DROP DATABASE `$database`");
                if (mysqli_query($conn, "CREATE DATABASE `$database`")) {
                    echo "<p class='info'>Baza usunięta i stworzona ponownie.</p>";
                    mysqli_select_db($conn, $database);
                } else {
                    die("<p class='error'>Błąd tworzenia bazy: " . mysqli_error($conn) . "</p>");
                }
            } elseif ($db_action == 'keep') {
                echo "<p class='info'>Zostawiono istniejącą bazę.</p>";
            } else {
                echo "
                    <p class='info'>Baza danych '$database' istnieje. Czy usunąć i stworzyć nową?</p>
                    <form method='POST'>
                        <div class='select-action-form'>
                            <button type='submit' name='db_action' value='recreate'>Tak</button> 
                            <button type='submit' name='db_action' value='keep'>Nie</button>
                        </div>
                    </form>
                ";
                mysqli_close($conn);
                exit;
            }
        } else {
            if (mysqli_query($conn, "CREATE DATABASE `$database`")) {
                echo "<p class='info'>Baza danych utworzona.</p>";
                mysqli_select_db($conn, $database);
            } else {
                die("<p class='error'>Błąd tworzenia bazy: " . mysqli_error($conn) . "</p>");
            }
        }

        $table = mysqli_query($conn, "SHOW TABLES LIKE '$tableName'");
        $table_exists = mysqli_num_rows($table) > 0;
        $table_action = $_POST['table_action'] ?? '';

        if ($table_exists) {
            if ($table_action == 'recreate') {
                mysqli_query($conn, "DROP TABLE `$tableName`");
                createTable($conn, $tableName);
                echo "<p class='info'>Tabela usunięta i stworzona ponownie.</p>";
            } elseif ($table_action == 'keep') {
                echo "<p class='info'>Zostawiono istniejącą tabelę.</p>";
            } else {
                echo "
                    <p class='info'>Tabela '$tableName' istnieje. Czy usunąć i stworzyć nową?</p>
                    <form method='POST' >
                        <div class='select-action-form'>
                            <button type='submit' name='table_action' value='recreate'>Tak</button> 
                            <button type='submit' name='table_action' value='keep'>Nie</button>
                        </div>
                    </form>
                ";
                mysqli_close($conn);
                exit;
            }
        } else {
            createTable($conn, $tableName);
            echo "<p class='info'>Tabela utworzona.</p>";
        }

        echo "<br><a href='a2.php' class='btn-link'>Wyświetl dane</a>";

        mysqli_close($conn);

        function createTable($conn, $tableName)
        {
            $sql = "CREATE TABLE IF NOT EXISTS $tableName (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                imie varchar(20) NOT NULL,
                ocena int NOT NULL,
                umie_apache boolean NOT NULL,
                muzyka text NOT NULL,
                data_jakas date NOT NULL
            )";
            if (!mysqli_query($conn, $sql)) {
                die("<p class='error'>Błąd tworzenia tabeli: " . mysqli_error($conn) . "</p>");
            }
        }
        ?>
    </div>
</body>

</html>