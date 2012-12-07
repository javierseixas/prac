<?php

require_once __DIR__.'/../vendor/autoload.php';

use JavierSeixas\PracBundle\Controller\ProductesControllerProvider;
use JavierSeixas\PracBundle\Controller\DescripcionsControllerProvider;
use JavierSeixas\PracBundle\Controller\CategoriesControllerProvider;
use JavierSeixas\PracBundle\Controller\ClassificacioControllerProvider;
use JavierSeixas\PracBundle\Controller\EstocsControllerProvider;
use Symfony\Component\Yaml\Parser;

// Inicialitza aplicació
$app = new Silex\Application();

// Inicialitza pasejador d'arxius yaml
$yaml = new Parser();

// Agafa contingut arxius de configuració yaml
$config = $yaml->parse(file_get_contents(__DIR__.'/config/config.yml'));

// Munta els controladors
$app->mount('/productes', new ProductesControllerProvider());
$app->mount('/descripcions', new DescripcionsControllerProvider());
$app->mount('/categories', new CategoriesControllerProvider());
$app->mount('/classificacio', new ClassificacioControllerProvider());
$app->mount('/estocs', new EstocsControllerProvider());

$app['debug'] = true;
$app['const.idioma.ref'] = 1;

// Carrega els diferents Proveidors de servei

$app->register(new \Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/Resources/views',
    'twig.form.templates'   => array('form_div_layout.html.twig', 'common/form_div_layout.html.twig'),
));

$app['mysqli'] = $app->share(function () use($config) {
    return new mysqli(
        $config['database']['host'], 
        $config['database']['user'],
        $config['database']['password'],
        $config['database']['dbname']
    );
});

$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'  => $config['database']
));

$app->register(new \Silex\Provider\SessionServiceProvider());


$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addGlobal('silex', $app);

    return $twig;
}));


// definitions

$app->get('/', function () use ($app) {

    return $app['twig']->render('layout.html.twig', array());

    return $output;
});


$app->run();
