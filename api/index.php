<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

echo "<pre>";

echo "VIEW : ";
var_dump($app->bound('view'));

echo "<br>";

echo "ROUTER : ";
var_dump($app->bound('router'));

echo "<br>";

echo "CONFIG : ";
var_dump($app->bound('config'));

echo "<br>";

echo "EVENT : ";
var_dump($app->bound('events'));

die();
