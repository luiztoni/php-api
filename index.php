<?php
$loader = require 'vendor/autoload.php';
$loader->add('Demo\\', __DIR__.'/src/');
$app = new Demo\PhpApi\App();
$app->run();
