<?php

namespace JavierSeixas\PracBundle\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class CategoriesControllerProvider implements ControllerProviderInterface
{
	public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {

            $sql = "SELECT tp.id_tipus_producte, dtp.descripcio
                FROM tipus_producte tp
                JOIN desc_tip_prod dtp ON tp.id_tipus_producte = dtp.id_tipus_producte
                WHERE id_idioma = ?
                ORDER BY descripcio";

            $productes = $app['db']->fetchAll($sql, array((int)$app['const.idioma.ref']));

            return $app['twig']->render('Categories/llistat.html.twig', array(
                'productes' => $productes
            ));
        });


        $controllers->match('/crear', function (Application $app) {

            if ($app['request']->getMethod() == 'POST'){

                try {

                	$id = $app['request']->get('id_tipus_producte');
                	$idioma = $app['request']->get('id_idioma');
                	$dte = $app['request']->get('dte');
                	$descripcio = $app['request']->get('descripcio');

                    $sql = "CALL alta_tipus_producte_desc(".(int)$id.",".(int)$idioma.",'".$descripcio."','".$dte."')";

                    $result = $app['mysqli']->query($sql);
                    if (!$result) {
                        throw new \Exception($app['mysqli']->error);
                    }

                    $app['session']->setFlash('notice', 'Categoria afegida correctament');

            		return $app->redirect('/categories');


                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }

            $sql = "SELECT * FROM idioma i ORDER BY id_idioma ASC";

            $idiomes = $app['db']->fetchAll($sql);
            
            return $app['twig']->render('Categories/crear.html.twig', array(
                'idiomes' => $idiomes
            ));
        });



        $controllers->match('/afegir/{id}', function (Application $app, $id) {

            if ($app['request']->getMethod() == 'POST'){

                try {

                	$id = $id;
                	$idioma = $app['request']->get('id_idioma');
                	$dte = $app['request']->get('dte');
                	$descripcio = $app['request']->get('descripcio');

                    $sql = "CALL alta_tipus_producte_desc(".(int)$id.",".(int)$idioma.",'".$descripcio."','".$dte."')";

                    $result = $app['mysqli']->query($sql);
                    if (!$result) {
                        throw new \Exception($app['mysqli']->error);
                    }

                    $app['session']->setFlash('notice', 'Traducció afegida correctament');

            		return $app->redirect('/categories');


                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }

            $sql = "SELECT i.* FROM idioma i";

            $idiomes = $app['db']->fetchAll($sql, array((int)$id));
            
            return $app['twig']->render('Categories/afegir.html.twig', array(
                'idiomes' => $idiomes,
                'id_tipus' => $id,
            ));
        });

        $controllers->match('/classificar/{id}', function (Application $app, $id) {

            if ($app['request']->getMethod() == 'POST'){

                try {

                	$generic = $app['request']->get('generic');

                    $sql = "CALL alta_classifica_producte(".(int)$generic.",".(int)$id.")";

                    $result = $app['mysqli']->query($sql);
                    if (!$result) {
                        throw new \Exception($app['mysqli']->error);
                    }

                    $app['session']->setFlash('notice', 'Classificació feta correctament');

            		return $app->redirect('/categories');


                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }

            $sql = "SELECT tp.id_tipus_producte, dtp.descripcio 
            	FROM tipus_producte tp 
            	JOIN desc_tip_prod dtp ON dtp.id_tipus_producte = tp.id_tipus_producte
            	WHERE id_idioma = ?
            	AND tp.id_tipus_producte <> ?";

            $categories = $app['db']->fetchAll($sql, array(
            	(int)$app['const.idioma.ref'],
            	(int)$id)
            );
            
            return $app['twig']->render('Categories/classificar.html.twig', array(
                'categories' => $categories,
                'id_tipus' => $id,
            ));
        });

        $controllers->match('/desclassificar/{id}', function (Application $app, $id) {

            if ($app['request']->getMethod() == 'POST'){

                try {

                	$generic = $app['request']->get('generic');

                    $sql = "CALL baixa_classifica_producte(".(int)$generic.",".(int)$id.")";

                    $result = $app['mysqli']->query($sql);
                    if (!$result) {
                        throw new \Exception($app['mysqli']->error);
                    }

                    $app['session']->setFlash('notice', 'Desclassificació feta correctament');

            		return $app->redirect('/categories');


                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }

            $sql = "SELECT dtp.id_tipus_producte, dtp.descripcio 
            	FROM classificacio c 
            	JOIN desc_tip_prod dtp ON dtp.id_tipus_producte = c.id_tipus_producte_generic
            	WHERE id_idioma = ?
            	AND id_tipus_producte_especific = ?
         		";

            $categories = $app['db']->fetchAll($sql, array(
            	(int)$app['const.idioma.ref'],
            	(int)$id)
            );
            
            return $app['twig']->render('Categories/desclassificar.html.twig', array(
                'categories' => $categories,
                'id_tipus' => $id,
            ));
        });

        $controllers->match('/eliminar/{id}', function (Application $app, $id) {

            try {

                $sql = "CALL baixa_tipus_producte(".(int)$id.")";
                
                $result = $app['mysqli']->query($sql);
                if (!$result) {
                    throw new \Exception($app['mysqli']->error);
                }

                $app['session']->setFlash('notice', 'Categoria eliminada satisfactoriament');

            } catch (\Exception $e) {
                $app['session']->setFlash('error', $e->getMessage());                    
            }

            return $app->redirect('/categories');

        });


        return $controllers;
    }

}
