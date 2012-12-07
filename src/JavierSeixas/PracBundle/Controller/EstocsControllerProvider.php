<?php

namespace JavierSeixas\PracBundle\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class EstocsControllerProvider implements ControllerProviderInterface
{
	public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {

            $sql = "SELECT p.id_producte, descripcio_curta
                FROM producte p
                JOIN desc_prod dp ON p.id_producte = dp.id_producte
                WHERE id_idioma = ?
                ORDER BY descripcio_curta";

            $productes = $app['db']->fetchAll($sql, array((int)$app['const.idioma.ref']));

            return $app['twig']->render('Estocs/llistat.html.twig', array(
                'productes' => $productes
            ));
        });


        $controllers->match('/modificar/{id}', function (Application $app, $id) {


            if ($app['request']->getMethod() == 'POST'){

                try {

                    $sql = "CALL modifica_estoc_actual(". $app['request']->get('estoc_final').", ".(int)$id.")";
                    
                    $result = $app['mysqli']->query($sql);
                    if (!$result) {
                        throw new \Exception($app['mysqli']->error);
                    }

                    $app['session']->setFlash('notice', 'Estoc modificat satisfactoriament');

                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }


            $sql = "SELECT *
                FROM producte p
                JOIN desc_prod dp ON p.id_producte = dp.id_producte  
                WHERE p.id_producte = 25
                AND dp.id_idioma = 1";

            $producte = $app['db']->fetchAssoc($sql, array((int)$id, (int)$app['const.idioma.ref']));

            return $app['twig']->render('Estocs/modificar.html.twig', array(
                'producte' => $producte
            ));
        });

        return $controllers;
    }

}
