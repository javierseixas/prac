<?php

namespace JavierSeixas\PracBundle\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class ClassificacioControllerProvider implements ControllerProviderInterface
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

            return $app['twig']->render('Classificacio/llistat.html.twig', array(
                'productes' => $productes
            ));
        });

        $controllers->match('/classificar/{id}', function (Application $app, $id) {


            $sql = "SELECT p.id_tipus_producte
                FROM pertanyer p
                WHERE p.id_producte = ?";

            $categories_actuals = $app['db']->fetchAll($sql, array((int)$id));

			$categories_act_ids = array();
            foreach ($categories_actuals as $key => $value) {
            	
            	$categories_act_ids[] = $value['id_tipus_producte'];
            }

            if ($app['request']->getMethod() == 'POST'){

                try {

                	$classificacio = $app['request']->get('classificacio');

                	$a_crear = array_diff($classificacio, $categories_act_ids);
                	$a_esborrar = array_diff($categories_act_ids, $classificacio);

                	foreach ($a_crear as $key => $value) {
                		$sql = "CALL alta_producte_tipus(".(int)$id.", ".(int)$value.")";
                    
	                    $result = $app['mysqli']->query($sql);

	                    if (!$result) {
	                        throw new \Exception($app['mysqli']->error);
	                    }
                	}

                	foreach ($a_esborrar as $key => $value) {
                		$sql = "CALL baixa_producte_tipus(".(int)$id.", ".(int)$value.")";
                    
	                    $result = $app['mysqli']->query($sql);

	                    if (!$result) {
	                        throw new \Exception($app['mysqli']->error);
	                    }
                	}

                    $categories_act_ids = $classificacio;

                    $app['session']->setFlash('notice', 'Classificació feta satisfactoriament');

                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }


            $sql = "SELECT *
                FROM tipus_producte tp
                JOIN desc_tip_prod dtp ON tp.id_tipus_producte = dtp.id_tipus_producte
                WHERE dtp.id_idioma = ?";

            $categories = $app['db']->fetchAll($sql, array((int)$app['const.idioma.ref']));



            return $app['twig']->render('Classificacio/classificar.html.twig', array(
                'categories' => $categories,
                'categories_actuals' => $categories_actuals,
                'categories_act_ids' => $categories_act_ids
            ));
        });

        return $controllers;
    }

}
