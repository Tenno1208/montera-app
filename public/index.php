<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

echo "<pre>";

try{

    echo "VIEW : ";
    var_dump($app->make('view'));

}catch(Throwable $e){

    echo "<h2>ERROR NIH BOS</h2>";

    echo $e->getMessage();

    echo "<br><br>";

    echo $e->getFile();

    echo "<br><br>";

    echo $e->getLine();

}
