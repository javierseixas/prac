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

$app->before(function () use ($app) {
    $app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.html.twig'));
});

$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'  => $config['database']
));

$app->register(new \Nutwerk\Provider\DoctrineORMServiceProvider(), array(
    'db.orm.proxies_dir'           => __DIR__.'/cache/doctrine/Proxy',
    'db.orm.proxies_namespace'     => 'DoctrineProxy',
    'db.orm.auto_generate_proxies' => true,
    'db.orm.entities'              => array(array(
        'type'      => 'yml',
        'path'      => __DIR__.'/../src/JavierSeixas/PracBundle/Resources/mapping',
        'namespace' => 'JavierSeixas\PracBundle\Entity',
    )),
));

$app->register(new \Silex\Provider\FormServiceProvider());

$app->register(new \Silex\Provider\TranslationServiceProvider(), array('locale_fallback' => 'ca',));

$app->register(new \Silex\Provider\SessionServiceProvider());

// definitions

$app->get('/', function () use ($app) {
    
    $output = 'hola';

    return $app['twig']->render('layout.html.twig', array(
        'name' => $output,
    ));

    return $output;
});


$app->run();
