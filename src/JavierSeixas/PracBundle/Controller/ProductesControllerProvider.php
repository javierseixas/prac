<?php

namespace JavierSeixas\PracBundle\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class ProductesControllerProvider implements ControllerProviderInterface
{
	public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {

        	$output = 'hola';

            return $app['twig']->render('Productes/llistat.html.twig', array(
		        'name' => $output,
		    ));
        });

        return $controllers;
    }

}