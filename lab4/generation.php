<?php

$a = ' ;
';

$openfile = fopen("config.php", "w");

$b = "<?php" . $a;
fwrite($openfile, $b);

$b = '$user ="' . $_POST["user"] . '"' . $a;
fwrite($openfile, $b);

$b = '$password ="' . $_POST["password"] . '"' . $a;
fwrite($openfile, $b);

$b = '$host ="' . $_POST["host"] . '"' . $a;
fwrite($openfile, $b);

$b = '$database ="' . $_POST["databaseName"] . '"' . $a;
fwrite($openfile, $b);

$b = '$tableName ="' . $_POST["tableName"] . '"' . $a;
fwrite($openfile, $b);

$b = '?>';
fwrite($openfile, $b);
fclose($openfile);

?>