<?php

require_once __DIR__.'/../vendor/autoload.php';

use JavierSeixas\PracBundle\Controller\ProductesControllerProvider;
use JavierSeixas\PracBundle\Controller\DescripcionsControllerProvider;
use JavierSeixas\PracBundle\Controller\CategoriesControllerProvider;
use JavierSeixas\PracBundle\Controller\ClassificacioControllerProvider;
use JavierSeixas\PracBundle\Controller\EstocsControllerProvider;

$app = new Silex\Application();

$app->mount('/productes', new ProductesControllerProvider());
$app->mount('/descripcions', new DescripcionsControllerProvider());
$app->mount('/categories', new CategoriesControllerProvider());
$app->mount('/classificacio', new ClassificacioControllerProvider());
$app->mount('/estocs', new EstocsControllerProvider());

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/Resources/views',
));

$app->before(function () use ($app) {
    $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.html.twig'));
});

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'path'     => __DIR__.'/app.db',
    ),
));


// definitions
$app->get('/', function () use ($app) {
    
    $output = 'hola';

    return $app['twig']->render('layout.html.twig', array(
        'name' => $output,
    ));

    return $output;
});


$app->run();
