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

                $sql = "CALL alta_producte_atribut (?, ?, ?, ?, ?, ?)";
                $stmt = $app['db']->prepare($sql);
                $stmt->bindValue(1, $app['request']->get('preu_actual'));
                $stmt->bindValue(2, $app['request']->get('es_oferta'));
                $stmt->bindValue(3, $app['request']->get('preu_oferta'));
                $stmt->bindValue(4, $app['request']->get('estoc_inicial'));
                $stmt->bindValue(5, $app['request']->get('estoc_final'));
                $stmt->bindValue(6, $app['request']->get('estoc_notificacio'));
                $id_producte = $stmt->execute();

//                $id_producte = $app['db']->lastInsertId();


                $sql = "CALL alta_producte_desc (?, ?, ?, ?)";
                $stmt = $app['db']->prepare($sql);
                $stmt->bindValue(1, $id_producte);
                $stmt->bindValue(2, $app['const.idioma.ref']);
                $stmt->bindValue(3, $app['request']->get('descripcioCurta'));
                $stmt->bindValue(4, $app['request']->get('descripcioLlarga'));
                $stmt->execute();



                $app['session']->setFlash('notice', 'Producte creat satisfactoriament');

                return $app->redirect('/productes');
//                }
//                else{
//                    $app['session']->setFlash('error', 'Site was not updated. Please, check errors below');
//                }
            }

            return $app['twig']->render('Productes/crear.html.twig', array(
		    ));
        });

        return $controllers;
    }

}

