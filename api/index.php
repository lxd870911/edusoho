<?php
date_default_timezone_set('UTC');

require_once __DIR__.'/../vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Topxia\Service\Common\ServiceKernel;
use Topxia\Service\User\CurrentUser;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\HttpFoundation\ParameterBag;
// use Symfony\Component\Debug\Debug;

// Debug::enable();

$config = include __DIR__ . '/config.php';

$connection = DriverManager::getConnection(array(
    'dbname' => $config['database_name'],
    'user' => $config['database_user'],
    'password' => $config['database_password'],   
    'host' => $config['database_host'],
    'driver' => $config['database_driver'],
    'charset' => $config['database_charset'],
));

// var_dump($config);

$serviceKernel = ServiceKernel::create('dev', true);
$serviceKernel->setParameterBag(new ParameterBag($config));
$serviceKernel->setConnection($connection);
// $serviceKernel->getConnection()->exec('SET NAMES UTF8');


include __DIR__ . '/src/functions.php';


$app = new Silex\Application();

$app['debug'] = true;

$app->view(function (array $result, Request $request) use ($app) {
    return new JsonResponse($result);
});

$app->before(function (Request $request) {
    setCurrentUser($request->query->get('token',''));
});

$app->mount('/api/users', include __DIR__ . '/src/users.php' );
$app->mount('/api/me', include __DIR__ . '/src/me.php' );
$app->mount('/api/courses', include __DIR__ . '/src/courses.php' );
$app->mount('/api/announcements', include __DIR__ . '/src/announcements.php' );
$app->mount('/api/coursethreads', include __DIR__ . '/src/coursethreads.php' );
$app->run();