<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {

    require __DIR__ . '/../public/index.php';

} catch (Throwable $e) {

    echo "<h1>ERROR NIH BOS</h1>";

    echo "<pre>";
    echo "Pesan Error : ".$e->getMessage();
    echo "\n\n";

    echo "File : ".$e->getFile();
    echo "\n\n";

    echo "Baris : ".$e->getLine();
    echo "\n\n";

    echo $e->getTraceAsString();
    echo "</pre>";

}
