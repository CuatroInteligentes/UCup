<?php

header('Location: index.php');
$fp = fopen("buf.txt", "w");
$mytext = $_POST['temp'];
$test = fwrite($fp, $mytext);
/*if ($test) echo 'Changes have been saved!';
else echo 'Error';*/
fclose($fp);
