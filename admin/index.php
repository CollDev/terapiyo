<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
$app = new Application();

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/routing.php';

if ($app['debug']) {
    $app->run();
} else {
    $app['http_cache']->run();
}