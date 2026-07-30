<?php

require __DIR__.'/../vendor/autoload.php';

$app=require_once __DIR__.'/../bootstrap/app.php';

echo "<pre>";

echo "services.php : ";

var_dump(
file_exists(
__DIR__."/../bootstrap/cache/services.php"
));

echo "<br>";

echo "packages.php : ";

var_dump(
file_exists(
__DIR__."/../bootstrap/cache/packages.php"
));

die();
