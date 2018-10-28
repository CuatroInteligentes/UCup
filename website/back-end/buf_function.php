<?php

//echo $_POST['temp'];

$fp = fopen("bufera.txt", "w");
$mytext = $_POST['temp'];
$test = fwrite($fp, $mytext);
if ($test) echo 'Данные в файл успешно занесены.';
else echo 'Ошибка при записи в файл.';
fclose($fp); //Закрытие файла

