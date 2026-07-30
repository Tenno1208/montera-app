<?php

require __DIR__.'/../vendor/autoload.php';

$app=require_once __DIR__.'/../bootstrap/app.php';

echo "<pre>";

var_dump($app->bound('view'));

echo "<br>";

var_dump($app->bound('router'));

echo "<br>";

var_dump($app->bound('config'));

die();
