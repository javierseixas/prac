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

                // $db = new \PDO('mysql:dbname=prac;host=localhost','root','javier');

                
                $result = mysqli_query($app['mysqli.connect'], "CALL recupera_ultim_producte(@idprod)");
                if ($result) {
                    $data = $result->fetch_assoc();
                    print_r($data);
                } else {
                    die('error: '.mysqli_error($mysqli));
                }
                // $sql = "CALL alta_producte_atribut (?, ?, ?, ?, ?, ?, @valor)";
                // $stmt = $app['db']->prepare($sql);
                // $stmt->bindValue(1, $app['request']->get('preu_actual'));
                // $stmt->bindValue(2, $app['request']->get('es_oferta'));
                // $stmt->bindValue(3, $app['request']->get('preu_oferta'));
                // $stmt->bindValue(4, $app['request']->get('estoc_inicial'));
                // $stmt->bindValue(5, $app['request']->get('estoc_final'));
                // $stmt->bindValue(6, $app['request']->get('estoc_notificacio'));
                // $stmt->execute();

                // $sql = "CALL recupera_ultim_producte(@ultim_producte)";
                // $stmt = $db->prepare($sql);
                // $stmt->bindParam(1, $id_producte, \PDO::PARAM_INT, 12);
                // $stmt->execute();
                // $sql = "SELECT @valor";
                // $stmt = $app['db']->prepare($sql);
                // $stmt->execute();
                // $valor = $stmt->fetchColumn();

                // echo 'id: '.$id_producte;
                // die();

                // $db->query("CALL alta_producte_atribut(".$app['request']->get('preu_actual').",0,".$app['request']->get('preu_oferta').",". $app['request']->get('estoc_inicial').",". $app['request']->get('estoc_final').",". $app['request']->get('estoc_notificacio').", @id_producte)");
                // $db->query("CALL recupera_ultim_producte(@ultim_producte)");
                // $stmt_2 = $db->query("SELECT @ultim_producte");
                // var_dump($db->query("SELECT @ultim_producte"));
                // $id_producte = $stmt_2->fetch(\PDO::FETCH_ASSOC);
                // print_r($id_producte);
                die('end');


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

