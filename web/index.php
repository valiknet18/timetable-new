<?php
error_reporting(-1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require_once __DIR__.'/../app/app.php';
require_once __DIR__.'/../app/config/routing.php';
require_once __DIR__.'/../app/config/config.php';

$request = Request::createFromGlobals();
$app->run($request);
