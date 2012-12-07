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
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {

            $sql = "SELECT p.id_producte, descripcio_curta
                FROM producte p
                JOIN desc_prod dp ON p.id_producte = dp.id_producte
                WHERE id_idioma = ?
                ORDER BY descripcio_curta";

            $productes = $app['db']->fetchAll($sql, array((int)$app['const.idioma.ref']));

            return $app['twig']->render('Productes/llistat.html.twig', array(
                'productes' => $productes
            ));
        });


        $controllers->match('/crear', function (Application $app) {

            if ($app['request']->getMethod() == 'POST'){

                try {

                    if ($app['request']->get('preu_actual') <= $app['request']->get('preu_oferta') ) {
                        throw new \Exception("El preu oferta no pot ser mes gran que el el preu normal");
                    }

                    if ($app['request']->get('es_oferta')) {
                        $es_oferta = 1;
                    } else {
                        $es_oferta = 0;
                    }

                    $sql = "CALL alta_producte_atribut(".$app['request']->get('preu_actual').",".$es_oferta.",".$app['request']->get('preu_oferta').",". $app['request']->get('estoc_inicial').",". $app['request']->get('estoc_final').",". $app['request']->get('estoc_notificacio').", @id_producte)";

                    $result = $app['mysqli']->query($sql);
                    if (!$result) {
                        throw new \Exception($app['mysqli']->error);
                    }

                    $result = $app['mysqli']->query("CALL recupera_ultim_producte(@idprod)");
                    if ($result) {
                        $data = $result->fetch_assoc();
                    } else {
                        throw new \Exception($app['mysqli']->error);
                    }

                    $app['mysqli']->next_result();

                    $sql = "CALL alta_producte_desc (".$data['id_producte'].", ".$app['const.idioma.ref'].", '".$app['request']->get('descripcioCurta')."', '".$app['request']->get('descripcioLlarga')."')";
                    $result = $app['mysqli']->query($sql);
                    if (!$result) {
                        throw new \Exception($app['mysqli']->error);
                    }

                    return $app->redirect('/productes');

                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }

            return $app['twig']->render('Productes/crear.html.twig', array(
		    ));
        });


        $controllers->match('/editar/{id}', function (Application $app, $id) {


            if ($app['request']->getMethod() == 'POST'){

                try {

                    if ($app['request']->get('preu_actual') <= $app['request']->get('preu_oferta') ) {
                        throw new \Exception("El preu oferta no pot ser mes gran que el el preu normal");
                    }

                    if ($app['request']->get('es_oferta')) {
                        $es_oferta = 1;
                    } else {
                        $es_oferta = 0;
                    }

                    $sql = "CALL modifica_producte_atribut(".$app['request']->get('preu_actual').",".$es_oferta.",".$app['request']->get('preu_oferta').",". $app['request']->get('estoc_inicial').",". $app['request']->get('estoc_final').",". $app['request']->get('estoc_notificacio').", ".(int)$id.")";
                    
                    $result = $app['mysqli']->query($sql);
                    if (!$result) {
                        throw new \Exception($app['mysqli']->error);
                    }

                    $app['session']->setFlash('notice', 'Producte modificat satisfactoriament');

                } catch (\Exception $e) {
                    $app['session']->setFlash('error', $e->getMessage());                    
                }

            }


            $sql = "SELECT *
                FROM producte p
                WHERE id_producte = ?";

            $producte = $app['db']->fetchAssoc($sql, array((int)$id));

            return $app['twig']->render('Productes/modificar.html.twig', array(
                'producte' => $producte
            ));
        });

        $controllers->match('/eliminar/{id}', function (Application $app, $id) {

            try {

                $sql = "CALL baixa_producte(".(int)$id.")";
                
                $result = $app['mysqli']->query($sql);
                if (!$result) {
                    throw new \Exception($app['mysqli']->error);
                }

                $app['session']->setFlash('notice', 'Producte eliminat satisfactoriament');

            } catch (\Exception $e) {
                $app['session']->setFlash('error', $e->getMessage());                    
            }

            return $app->redirect('/productes');

        });
        
        return $controllers;
    }

}

