<?php

require __DIR__.'/../vendor/autoload.php';

$app=require_once __DIR__.'/../bootstrap/app.php';

echo "<pre>";

echo "CONFIG EXISTS : ";
var_dump(file_exists(
__DIR__.'/../config/app.php'
));

echo "<br>";

echo "PROVIDERS EXISTS : ";
var_dump(file_exists(
__DIR__.'/../bootstrap/providers.php'
));

echo "<br>";

echo "APP EXISTS : ";
var_dump(file_exists(
__DIR__.'/../bootstrap/app.php'
));

echo "<br>";

echo "CONTAINER CONFIG : ";

try{

var_dump($app->make("config"));

}catch(Throwable $e){

echo $e->getMessage();

}

die();
