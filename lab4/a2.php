<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tablica rekordów</title>
</head>

<body>
    <div class="container">
        <?php
        include "config.php";

        $conn = mysqli_connect($host, $user, $password) or die("<p class='error'>Nie można nawiazać połączenia</p>");

        mysqli_select_db($conn, $database) or die("<p class='error'>Baza danych nie istnieje</p>");

        include "a5.php";

        echo "
        <header>
            <h1>Lista Rekordów Tabeli {$tableName}</h1>
        </header>";

        echo "
        <table>
            <tr>
                <th><a href='?sort=id&order=$new_order'>ID</a></th>
                <th><a href='?sort=imie&order=$new_order'>Imie</a></th>
                <th><a href='?sort=ocena&order=$new_order'>Ocena</a></th>
                <th><a href='?sort=umie_apache&order=$new_order'>Umie Apache</a></th>
                <th><a href='?sort=muzyka&order=$new_order'>Muzyka</a></th>
                <th><a href='?sort=data_jakas&order=$new_order'>Data</a></th>
                <th>Usuń</th>
                <th>Popraw</th>
            </tr>";

        $result = mysqli_query($conn, $sql1);

        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                echo "
          <tr>
            <td>" . $row[0] . "</td>
            <td>" . $row[1] . "</td>
            <td>" . $row[2] . "</td>
            <td>" . ($row[3] ? 'Tak' : 'Nie') . "</td>
            <td>" . $row[4] . "</td>
            <td>" . $row[5] . "</td>
            <td>
                <a class='btn-delete' href='a4.php?id=" . $row[0] . "'>Usuń</a>
            </td>
            <td>
                <a class='btn-edit' href='a3.php?id=" . $row[0] . "'>Popraw</a>
            </td>
          </tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>Brak danych lub tabela nie istnieje.</td></tr>";
        }
        echo "</table>";
        echo "<a href='a6.php' class='btn-link'>Dodaj wpis</a>";
        ?>
    </div>
</body>

</html>