<?php

namespace JavierSeixas\PracBundle\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class DescripcionsControllerProvider implements ControllerProviderInterface
{
	public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {

            $sql = "SELECT p.id_producte, descripcio_curta
                FROM producte p
                JOIN desc_prod dp ON p.id_producte = dp.id_producte
                WHERE id_idioma = ?
                ORDER BY descripcio_curta";

            $productes = $app['db']->fetchAll($sql, array((int)$app['const.idioma.ref']));

            return $app['twig']->render('Descripcions/llistat.html.twig', array(
                'productes' => $productes
            ));
        });


        $controllers->match('/afegir/{id}', function (Application $app, $id) {

            if ($app['request']->getMethod() == 'POST'){

                try {

                	$idioma = $app['request']->get('id_idioma');
                	$descripcioCurta = $app['request']->get('descripcioCurta');
                	$descripcioLlarga = $app['request']->get('descripcioLlarga');

                    $sql = "CALL alta_producte_desc(".(int)$id.",".(int)$idioma.",'".$descripcioCurta."','".$descripcioLlarga."')";

                    $result = $app['mysqli']->query($sql);
                    if (!$result) {
                        throw new \Exception($app['mysqli']->error);
                    }

                    $app['session']->setFlash('notice', 'Descripció afegida correctament');

            		return $app->redirect('/productes');


                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }

            $sql = "SELECT dp.*, i.*
                FROM idioma i
                LEFT JOIN desc_prod dp ON i.id_idioma = dp.id_idioma
                WHERE id_producte IS NULL";

            $idiomes = $app['db']->fetchAll($sql, array((int)$id));
            
            return $app['twig']->render('Descripcions/afegir.html.twig', array(
                'idiomes' => $idiomes
            ));
        });


        $controllers->match('/traduir/{id}', function (Application $app, $id) {

            if ($app['request']->getMethod() == 'POST'){

                try {

		            $sql = "SELECT * FROM idioma i";

		            $idiomes = $app['db']->fetchAll($sql);

		            foreach ($idiomes as $key => $idioma) {
		            	
		            	if ($app['request']->get('idioma_'.$idioma['id_idioma'])) {

		            		$traduccio = $app['request']->get('idioma_'.$idioma['id_idioma']);
		            		$descripcioCurta = $traduccio['descripcioCurta'];
		            		$descripcioLlarga = $traduccio['descripcioLlarga'];

		                    $sql = "CALL modifica_producte_desc(".(int)$id.",".(int)$idioma['id_idioma'].",'".$descripcioCurta."','".$descripcioLlarga."')";
		                    
		                    $result = $app['mysqli']->query($sql);
		                    if (!$result) {
		                        throw new \Exception($app['mysqli']->error);
		                    }

		            	}

		            }

                    $app['session']->setFlash('notice', 'Producte modificat satisfactoriament');

                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }


            $sql = "SELECT dp.*, i.*
                FROM desc_prod dp
                LEFT JOIN idioma i ON i.id_idioma = dp.id_idioma
                WHERE id_producte = ?";

            $traduccions = $app['db']->fetchAll($sql, array((int)$id));

            return $app['twig']->render('Descripcions/traduir.html.twig', array(
                'traduccions' => $traduccions
            ));
        });


        return $controllers;
    }

}
