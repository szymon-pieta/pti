<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Połącz z Bazą Danych</title>
</head>

<body>
  <div class="container">
    <header>
      <h1>Połącz z Bazą Danych</h1>
    </header>

    <?php
    function zabezpiecz($data)
    {
      return htmlspecialchars($data, ENT_QUOTES, "UTF-8");
    }

    $hostName = '';
    $userName = '';
    $password = '';
    $databaseName = '';
    $tableName = 'nazwaTablicy';

    if ($_SERVER['REQUEST_METHOD'] != 'POST' && file_exists("config.php")) {
      include("config.php");
      $hostName = zabezpiecz($host ?? '');
      $userName = zabezpiecz($user ?? '');
      $databaseName = zabezpiecz($database ?? '');
    }

    if (
      $_SERVER['REQUEST_METHOD'] == 'POST'
      && isset($_POST['host'])
      && isset($_POST['user'])
      && isset($_POST['databaseName'])
    ) {

      $hostName = zabezpiecz($_POST['host']);
      $userName = zabezpiecz($_POST['user']);
      $password = zabezpiecz($_POST['password']);
      $databaseName = zabezpiecz($_POST['databaseName']);


      $conn = mysqli_connect($hostName, $userName, $password);
      if (!$conn) {
        echo "<p class='error'>Nie można nawiązać połączenia: " . mysqli_connect_error() . "</p>";
      } else {
        $_POST['tableName'] = $tableName;
        include("generation.php");
        header("Location: a1_konfiguracja.php");
        exit;
      }
    }
    ?>

    <form method='POST'>
      <div>
        <label>Host:</label>
        <input type='text' name='host' value='<?php echo $hostName ?>' required>
      </div>
      <div>
        <label>User:</label>
        <input type='text' name='user' value='<?php echo $userName ?>' required>
      </div>
      <div>
        <label>Password:</label>
        <input type='password' name='password'>
      </div>
      <div>
        <label>Database:</label>
        <input type='text' name='databaseName' value='<?php echo $databaseName ?>' required>
      </div>
      <input type='submit' value='Zapisz konfiguracje'>
    </form>
  </div>
</body>

</html>