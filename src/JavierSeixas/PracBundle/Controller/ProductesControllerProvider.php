<?php

namespace JavierSeixas\PracBundle\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

use JavierSeixas\PracBundle\Entity\Producte;
use JavierSeixas\PracBundle\Entity\ProducteDesc;
use JavierSeixas\PracBundle\Form\ProducteType;
use JavierSeixas\PracBundle\Form\ProducteDescType;

class ProductesControllerProvider implements ControllerProviderInterface
{
	public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {

            $producte = new Producte();
            $form = $app['form.factory']->create(new ProducteType(), $producte);

            $output = 'hola';

            return $app['twig']->render('Productes/llistat.html.twig', array(
                'form' => $form,
            ));
        });

        $controllers->match('/crear', function (Application $app) {

            if ($app['request']->getMethod() == 'POST'){
                print_r($app['request']->get('producte')['preu_actual']);
                $form->bind($app['request']);

                if ($form->isValid()){

                    $sql = "SELECT * FROM producte WHERE id = ?";
                    $post = $app['db']->fetchAssoc($sql, array(1));
                        print_r($post);

                    $app['session']->setFlash('notice', 'Producte creat satisfactoriament');

                    return $app->redirect('/productes');
                }
                else{
                    $app['session']->setFlash('error', 'Site was not updated. Please, check errors below');
                }
            }

            return $app['twig']->render('Productes/crear.html.twig', array(
		    ));
        });

        return $controllers;
    }

}

